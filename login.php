<?php
require_once __DIR__ . '/includes/auth.php';

$pdo = scEnsureStorage();
$loginError = '';
$username = '';

if (scCurrentAdmin() !== null) {
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($pdo === null) {
        $loginError = 'Databázové pripojenie nie je dostupné.';
    } elseif (!scVerifyCsrfToken('login', (string)($_POST['csrf_token'] ?? ''))) {
        $loginError = 'Platnosť formulára vypršala, skúste to znova.';
    } elseif ($username === '' || $password === '') {
        $loginError = 'Vyplňte používateľské meno aj heslo.';
    } elseif (scLoginAdmin($pdo, $username, $password) === null) {
        $loginError = 'Nesprávne prihlasovacie údaje.';
    } else {
        header('Location: admin.php');
        exit;
    }
}

$csrfToken = scCsrfToken('login');
?>
<!doctype html>
<html lang="sk">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin prihlásenie | Survival-Craft</title>
    <link rel="stylesheet" href="assets/styles/style.css">
  </head>
  <body>
    <main class="auth-shell container">
      <section class="auth-card">
        <p class="auth-kicker">Survival-Craft</p>
        <h1>Admin prihlásenie</h1>
        <p class="lead">Prihlásenie pre tím, ktorý bude spracovávať spätnú väzbu.</p>

        <?php if ($loginError !== ''): ?>
          <div class="feedback-alert" role="alert"><?php echo htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <form class="auth-form" method="post" action="login.php">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>" />
          <div>
            <label for="username">Používateľské meno</label>
            <input id="username" name="username" type="text" autocomplete="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" required />
          </div>
          <div>
            <label for="password">Heslo</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required />
          </div>
          <button class="btn submit-btn" type="submit">Prihlásiť sa</button>
        </form>

      </section>
    </main>
  </body>
</html>
