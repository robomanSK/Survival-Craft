<?php
require_once __DIR__ . '/includes/auth.php';

$pdo = scEnsureStorage();
header('Content-Type: text/plain; charset=utf-8');
if ($pdo === null) {
    echo "DB connection not available\n";
    exit;
}

$info = scFindAuthMeTable($pdo);
if ($info === null) {
    echo "AuthMe-like table not detected in current database.\n";
    exit;
}

echo "Detected table: " . $info['table'] . "\n";
echo "username column: " . $info['username_col'] . "\n";
echo "password column: " . $info['password_col'] . "\n";
echo "salt column: " . ($info['salt_col'] ?? '(none)') . "\n\n";

$u = (string)($_GET['u'] ?? '');
if ($u === '') {
    echo "To inspect a user, append ?u=USERNAME to the URL.\n";
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM `{$info['table']}` WHERE `{$info['username_col']}` = :u LIMIT 1");
    $stmt->execute([':u' => $u]);
    $row = $stmt->fetch();
} catch (Throwable $e) {
    echo "Query error: " . $e->getMessage() . "\n";
    exit;
}

if (!$row) {
    echo "No row found for user: $u\n";
    exit;
}

echo "Found row for user: " . ($row[$info['username_col']] ?? '[missing]') . "\n";
$pass = $row[$info['password_col']] ?? '';
echo "Stored password value: " . $pass . "\n\n";

$ok = scVerifyAuthMeUser($pdo, $u, (string)($_GET['p'] ?? ''));
if ($ok !== null) {
    echo "scVerifyAuthMeUser() returns: SUCCESS\n";
} else {
    echo "scVerifyAuthMeUser() returns: FAIL (try passing ?p=PASSWORD to test)\n";
}

echo "\nNote: Avoid sharing real passwords; you can paste the stored password hash here for debugging.\n";

exit;
