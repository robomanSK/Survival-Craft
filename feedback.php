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
        <form id="feedback-form" class="feedback-form" novalidate>
          <div>
            <label for="fb-name">Meno (nepovinné)</label>
            <input id="fb-name" name="name" type="text" placeholder="Tvoje meno" />
          </div>
          <div>
            <label for="fb-email">E-mail</label>
            <input id="fb-email" name="email" type="email" placeholder="tvoj@email.sk" required />
          </div>
          <div>
            <label for="fb-message">Správa</label>
            <textarea id="fb-message" name="message" rows="6" placeholder="Napíšte sem svoju správu..." required></textarea>
          </div>
          <div class="consent-row">
            <label class="consent">
              <input id="fb-consent" name="consent" type="checkbox" />
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
