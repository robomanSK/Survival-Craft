<?php
require_once __DIR__ . '/includes/auth.php';

$pdo = scEnsureStorage();
$feedbackError = '';
$feedbackValues = [
  'name' => '',
  'email' => '',
  'message' => '',
  'consent' => false,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $feedbackValues['name'] = trim((string) ($_POST['name'] ?? ''));
  $feedbackValues['email'] = trim((string) ($_POST['email'] ?? ''));
  $feedbackValues['message'] = trim((string) ($_POST['message'] ?? ''));
  $feedbackValues['consent'] = isset($_POST['consent']);

  if ($pdo === null) {
    $feedbackError = 'Databázové pripojenie nie je dostupné.';
  } elseif (!scVerifyCsrfToken('feedback', (string) ($_POST['csrf_token'] ?? ''))) {
    $feedbackError = 'Platnosť formulára vypršala, skúste to znova.';
  } elseif (!filter_var($feedbackValues['email'], FILTER_VALIDATE_EMAIL)) {
    $feedbackError = 'Zadajte platný e-mail.';
  } elseif ($feedbackValues['message'] === '') {
    $feedbackError = 'Správa je povinná.';
  } elseif (!$feedbackValues['consent']) {
    $feedbackError = 'Je potrebný súhlas so spracovaním údajov.';
  } else {
    scCreateFeedback($pdo, [
      'name' => $feedbackValues['name'],
      'email' => $feedbackValues['email'],
      'message' => $feedbackValues['message'],
      'consent' => $feedbackValues['consent'],
      'ip_address' => (string) ($_SERVER['REMOTE_ADDR'] ?? ''),
      'user_agent' => (string) ($_SERVER['HTTP_USER_AGENT'] ?? ''),
    ]);

    header('Location: /Survival-Craft/thankyou.php', true, 303);
    exit;
  }
}

$feedbackCsrf = scCsrfToken('feedback');
?>
<!doctype html>
<html lang="sk">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="assets/img/3D SC.png">
    <title>Feedback | Survival-Craft</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.3.2/css/flag-icons.min.css" />
    <script src="assets/js/script.js" defer></script>
  </head>
  <body>
    <header class="hero">
      <?php include __DIR__ . '/includes/navbar.php'; ?>
      <div class="container hero-inner">
        <div class="hero-text">
          <h1 data-text-sk="Spätná väzba" data-text-cz="Zpětná vazba">Spätná väzba</h1>
          <p class="lead" data-text-sk="Máte pripomienky alebo nápady? Napíšte nám." data-text-cz="Máte připomínky nebo nápady? Napište nám.">Máte pripomienky alebo nápady? Napíšte nám.</p>
        </div>
      </div>
    </header>

    <main class="container">
      <section class="feedback-section">
        <form id="feedback-form" class="feedback-form" method="post" action="feedback.php" novalidate>
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($feedbackCsrf, ENT_QUOTES, 'UTF-8'); ?>" />
          <?php if ($feedbackError !== ''): ?>
            <div class="feedback-alert" role="alert"><?php echo htmlspecialchars($feedbackError, ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
          <div>
            <label for="fb-name">Meno (nepovinné)</label>
            <input id="fb-name" name="name" type="text" placeholder="Tvoje meno" value="<?php echo htmlspecialchars($feedbackValues['name'], ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div>
            <label for="fb-email">E-mail</label>
            <input id="fb-email" name="email" type="email" placeholder="tvoj@email.sk" value="<?php echo htmlspecialchars($feedbackValues['email'], ENT_QUOTES, 'UTF-8'); ?>" required />
          </div>
          <div>
            <label for="fb-message">Správa</label>
            <textarea id="fb-message" name="message" rows="6" placeholder="Napíšte sem svoju správu..." required><?php echo htmlspecialchars($feedbackValues['message'], ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div class="consent-row">
            <label class="consent">
              <input id="fb-consent" name="consent" type="checkbox" <?php echo $feedbackValues['consent'] ? 'checked' : ''; ?> />
              <span data-text-sk="Súhlasím so spracovaním osobných údajov" data-text-cz="Souhlasím se zpracováním osobních údajů">Súhlasím so spracovaním osobných údajov</span>
            </label>
          </div>
          <div class="form-actions">
            <button class="btn submit-btn" type="submit" data-text-sk="Odoslať" data-text-cz="Odeslat">Odoslať</button>
            <span class="form-error" aria-live="polite" style="color: #ffb4b4; display:block; margin-top:.6rem"></span>
          </div>
        </form>
      </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
  </body>
</html>
