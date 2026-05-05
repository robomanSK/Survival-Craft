<?php

require_once __DIR__ . '/db.php';

function scInitSession(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function scEnsureStorage(): ?PDO
{
    $pdo = getDbConnection();
    if (!$pdo instanceof PDO) {
        return null;
    }

    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS admin_users (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(64) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            display_name VARCHAR(120) NOT NULL,
            role VARCHAR(32) NOT NULL DEFAULT 'admin',
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            last_login_at TIMESTAMP NULL DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $pdo->exec("CREATE TABLE IF NOT EXISTS feedback_messages (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(120) NULL,
            email VARCHAR(190) NOT NULL,
            message TEXT NOT NULL,
            consent TINYINT(1) NOT NULL DEFAULT 0,
            status VARCHAR(24) NOT NULL DEFAULT 'new',
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            handled_at TIMESTAMP NULL DEFAULT NULL,
            ip_address VARCHAR(45) NULL,
            user_agent VARCHAR(255) NULL,
            INDEX idx_feedback_status_created (status, created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        scSeedAdminUser($pdo);

        return $pdo;
    } catch (Throwable $e) {
        return null;
    }
}

function scSeedAdminUser(PDO $pdo): void
{
    try {
        $count = (int)$pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
    } catch (Throwable $e) {
        return;
    }

    if ($count > 0) {
        return;
    }

    $username = trim((string)(getenv('ADMIN_USERNAME') ?: 'admin'));
    $password = (string)(getenv('ADMIN_PASSWORD') ?: 'ChangeMe123!');
    $displayName = trim((string)(getenv('ADMIN_DISPLAY_NAME') ?: 'Admin tím'));

    if ($username === '') {
        $username = 'admin';
    }
    if ($password === '') {
        $password = 'ChangeMe123!';
    }
    if ($displayName === '') {
        $displayName = 'Admin tím';
    }

    $stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash, display_name, role) VALUES (:username, :password_hash, :display_name, 'admin')");
    $stmt->execute([
        ':username' => $username,
        ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ':display_name' => $displayName,
    ]);
}

function scCsrfToken(string $context): string
{
    scInitSession();
    if (!isset($_SESSION['csrf_tokens']) || !is_array($_SESSION['csrf_tokens'])) {
        $_SESSION['csrf_tokens'] = [];
    }

    if (empty($_SESSION['csrf_tokens'][$context])) {
        $_SESSION['csrf_tokens'][$context] = bin2hex(random_bytes(16));
    }

    return (string)$_SESSION['csrf_tokens'][$context];
}

function scAuthMeAllowedPrimaryGroups(): array
{
    $configured = (string)(getenv('AUTHME_ALLOWED_PRIMARY_GROUPS') ?: getenv('AUTHME_ALLOWED_PRIMARY_GROUP') ?: 'majitel');
    $groups = array_map('trim', explode(',', $configured));
    $groups = array_values(array_filter($groups, static fn(string $value): bool => $value !== ''));

    return $groups !== [] ? $groups : ['owner'];
}

function scAuthMePrimaryGroupAllowed(?string $group): bool
{
    if ($group === null || trim($group) === '') {
        return false;
    }

    return in_array(strtolower(trim($group)), array_map('strtolower', scAuthMeAllowedPrimaryGroups()), true);
}

function scFetchLuckPermsPrimaryGroup(PDO $pdo, string $username): ?string
{
    try {
        $stmt = $pdo->prepare("SELECT primary_group FROM luckperms_players WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        $row = $stmt->fetch();
    } catch (Throwable $e) {
        return null;
    }

    if (!$row || !array_key_exists('primary_group', $row)) {
        return null;
    }

    $group = trim((string)$row['primary_group']);
    return $group !== '' ? $group : null;
}

function scFindAuthMeTable(PDO $pdo): ?array
{
    try {
        $rows = $pdo->query("SELECT TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND COLUMN_NAME IN ('password','pass','username','user','name','realname','salt')")->fetchAll();
    } catch (Throwable $e) {
        return null;
    }

    $tables = [];
    foreach ($rows as $r) {
        $t = $r['TABLE_NAME'];
        if (!isset($tables[$t])) {
            $tables[$t] = [];
        }
        $tables[$t][] = $r['COLUMN_NAME'];
    }

    foreach ($tables as $table => $cols) {
        $hasPass = array_intersect($cols, ['password', 'pass']);
        $hasUser = array_intersect($cols, ['username', 'user', 'name', 'realname']);
        if (!empty($hasPass) && !empty($hasUser)) {
            $passCol = array_values($hasPass)[0] ?? null;
            $userCol = array_values($hasUser)[0] ?? null;
            if ($passCol !== null && $userCol !== null) {
                return [
                    'table' => $table,
                    'password_col' => $passCol,
                    'username_col' => $userCol,
                    'realname_col' => in_array('realname', $cols, true) ? 'realname' : null,
                    'salt_col' => in_array('salt', $cols, true) ? 'salt' : null,
                ];
            }
        }
    }

    return null;
}

function scVerifyAuthMeUser(PDO $pdo, string $username, string $password): ?array
{
    $info = scFindAuthMeTable($pdo);
    if ($info === null) {
        return null;
    }

    $table = $info['table'];
    $ucol = $info['username_col'];
    $pcol = $info['password_col'];
    $rcol = $info['realname_col'] ?? null;
    $scol = $info['salt_col'] ?? null;

    try {
        $stmt = $pdo->prepare("SELECT * FROM `{$table}` WHERE `{$ucol}` = :u LIMIT 1");
        $stmt->execute([':u' => $username]);
        $row = $stmt->fetch();
    } catch (Throwable $e) {
        return null;
    }

    if (!$row) {
        return null;
    }

    $primaryGroup = scFetchLuckPermsPrimaryGroup($pdo, $username);
    $realName = $username;
    if ($rcol !== null && array_key_exists($rcol, $row)) {
        $candidate = trim((string)$row[$rcol]);
        if ($candidate !== '') {
            $realName = $candidate;
        }
    }

    if (!scAuthMePrimaryGroupAllowed($primaryGroup)) {
        return null;
    }

    $stored = (string)($row[$pcol] ?? '');
    $storedLower = strtolower($stored);

    // bcrypt / password_hash
    if (strpos($stored, '$2y$') === 0 || strpos($stored, '$2a$') === 0 || strpos($stored, '$argon2') === 0) {
        if (password_verify($password, $stored)) {
            return ['username' => $username, 'display_name' => $realName, 'primary_group' => $primaryGroup];
        }
        return null;
    }

    // $SHA$<salt>$<hash> style — try several common variants (case-insensitive)
    if (stripos($stored, '$sha$') !== false) {
        $parts = explode('$', $stored);
        // expect ['', 'SHA', salt, hash]
        if (isset($parts[2]) && isset($parts[3])) {
            $salt = trim($parts[2]);
            $hash = strtolower(trim($parts[3]));

            $variants = [];

            // common: sha256(password + salt) and sha256(salt + password)
            $variants[] = strtolower(hash('sha256', $password . $salt));
            $variants[] = strtolower(hash('sha256', $salt . $password));

            // sometimes salt stored as hex that should be binary
            if (ctype_xdigit($salt) && strlen($salt) % 2 === 0) {
                $bin = @hex2bin($salt);
                if ($bin !== false) {
                    $variants[] = strtolower(hash('sha256', $password . $bin));
                    $variants[] = strtolower(hash('sha256', $bin . $password));
                }
            }

            // sometimes stored hash is just sha256(password) (legacy)
            $variants[] = strtolower(hash('sha256', $password));

            // some setups double-hash or combine in different orders
            $variants[] = strtolower(hash('sha256', hash('sha256', $password) . $salt));
            $variants[] = strtolower(hash('sha256', $salt . hash('sha256', $password)));

            // check all variants
            foreach ($variants as $v) {
                if ($v === $hash) {
                    return ['username' => $username, 'display_name' => $realName, 'primary_group' => $primaryGroup];
                }
            }
        }

        return null;
    }

    // If salt column is present
    if ($scol !== null && isset($row[$scol])) {
        $salt = (string)$row[$scol];
        if (hash('sha256', $password . $salt) === $storedLower || hash('sha256', $salt . $password) === $storedLower) {
            return ['username' => $username, 'display_name' => $realName, 'primary_group' => $primaryGroup];
        }
    }

    // Plain sha256 hex
    if (ctype_xdigit($stored) && strlen($stored) === 64) {
        if (hash('sha256', $password) === $storedLower) {
            return ['username' => $username, 'display_name' => $realName, 'primary_group' => $primaryGroup];
        }
    }

    return null;
}

function scVerifyCsrfToken(string $context, ?string $token): bool
{
    scInitSession();
    if ($token === null || $token === '') {
        return false;
    }

    $stored = $_SESSION['csrf_tokens'][$context] ?? '';
    return is_string($stored) && hash_equals($stored, $token);
}

function scLoginAdmin(PDO $pdo, string $username, string $password): ?array
{
    $stmt = $pdo->prepare("SELECT id, username, password_hash, display_name, role FROM admin_users WHERE username = :username LIMIT 1");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    $authmeInfo = scFindAuthMeTable($pdo);
    $authmeUser = null;
    if ($authmeInfo !== null) {
        $authmeUser = scVerifyAuthMeUser($pdo, $username, $password);
    }

    // If user exists locally and password matches, normal flow
    if ($user && password_verify($password, (string)$user['password_hash'])) {
        if ($authmeInfo !== null && $authmeUser === null) {
            return null;
        }

        $update = $pdo->prepare("UPDATE admin_users SET last_login_at = NOW() WHERE id = :id");
        $update->execute([':id' => (int)$user['id']]);

        scInitSession();
        session_regenerate_id(true);
        $_SESSION['admin_user'] = [
            'id' => (int)$user['id'],
            'username' => (string)$user['username'],
            'display_name' => (string)$user['display_name'],
            'role' => (string)$user['role'],
        ];

        return $_SESSION['admin_user'];
    }

    // Fallback: try to authenticate against AuthMe-stored credentials
    if ($authmeUser !== null) {
        // If local admin row exists, update its password hash and display name
        if ($user) {
            $update = $pdo->prepare("UPDATE admin_users SET password_hash = :ph, display_name = :dn, last_login_at = NOW() WHERE id = :id");
            $update->execute([
                ':ph' => password_hash($password, PASSWORD_DEFAULT),
                ':dn' => $authmeUser['display_name'] ?? $username,
                ':id' => (int)$user['id'],
            ]);
            $id = (int)$user['id'];
            $role = $user['role'];
        } else {
            // create a local admin user mapped to AuthMe account
            $ins = $pdo->prepare("INSERT INTO admin_users (username, password_hash, display_name, role) VALUES (:username, :ph, :dn, 'admin')");
            $ins->execute([
                ':username' => $username,
                ':ph' => password_hash($password, PASSWORD_DEFAULT),
                ':dn' => $authmeUser['display_name'] ?? $username,
            ]);
            $id = (int)$pdo->lastInsertId();
            $role = 'admin';
        }

        scInitSession();
        session_regenerate_id(true);
        $_SESSION['admin_user'] = [
            'id' => $id,
            'username' => $username,
            'display_name' => $authmeUser['display_name'] ?? $username,
            'role' => $role,
        ];

        return $_SESSION['admin_user'];
    }

    return null;
}

function scCurrentAdmin(): ?array
{
    scInitSession();
    if (empty($_SESSION['admin_user']) || !is_array($_SESSION['admin_user'])) {
        return null;
    }

    return $_SESSION['admin_user'];
}

function scRequireAdmin(): array
{
    $admin = scCurrentAdmin();
    if ($admin === null) {
        header('Location: login.php');
        exit;
    }

    return $admin;
}

function scLogoutAdmin(): void
{
    scInitSession();
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool)$params['secure'], (bool)$params['httponly']);
    }

    session_destroy();
}

function scAllowedFeedbackStatuses(): array
{
    return ['new', 'in_progress', 'handled'];
}

function scCreateFeedback(PDO $pdo, array $data): bool
{
    $stmt = $pdo->prepare("INSERT INTO feedback_messages (
        name,
        email,
        message,
        consent,
        status,
        ip_address,
        user_agent
    ) VALUES (
        :name,
        :email,
        :message,
        :consent,
        'new',
        :ip_address,
        :user_agent
    )");

    return $stmt->execute([
        ':name' => $data['name'] !== '' ? $data['name'] : null,
        ':email' => $data['email'],
        ':message' => $data['message'],
        ':consent' => $data['consent'] ? 1 : 0,
        ':ip_address' => $data['ip_address'] !== '' ? $data['ip_address'] : null,
        ':user_agent' => $data['user_agent'] !== '' ? $data['user_agent'] : null,
    ]);
}

function scFetchFeedbackMessages(PDO $pdo, ?string $status = null): array
{
    $sql = "SELECT id, name, email, message, consent, status, created_at, updated_at, handled_at, ip_address, user_agent
            FROM feedback_messages";
    $params = [];

    if ($status !== null && in_array($status, scAllowedFeedbackStatuses(), true)) {
        $sql .= " WHERE status = :status";
        $params[':status'] = $status;
    }

    $sql .= " ORDER BY created_at DESC, id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

function scUpdateFeedbackStatus(PDO $pdo, int $id, string $status): bool
{
    if (!in_array($status, scAllowedFeedbackStatuses(), true)) {
        return false;
    }

    $stmt = $pdo->prepare("UPDATE feedback_messages
        SET status = :status,
            handled_at = CASE WHEN :status = 'handled' THEN COALESCE(handled_at, NOW()) ELSE NULL END
        WHERE id = :id");

    return $stmt->execute([
        ':status' => $status,
        ':id' => $id,
    ]);
}

function scAdminCountFeedback(PDO $pdo): array
{
    $counts = [
        'new' => 0,
        'in_progress' => 0,
        'handled' => 0,
        'all' => 0,
    ];

    $stmt = $pdo->query("SELECT status, COUNT(*) AS total FROM feedback_messages GROUP BY status");
    foreach ($stmt->fetchAll() as $row) {
        $status = (string)($row['status'] ?? '');
        if (array_key_exists($status, $counts)) {
            $counts[$status] = (int)$row['total'];
        }
    }

    $counts['all'] = array_sum([$counts['new'], $counts['in_progress'], $counts['handled']]);

    return $counts;
}
