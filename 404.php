<?php
http_response_code(404);
?>
<!doctype html>
<html lang="sk">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>404 • Stránka nenájdená — Survival-Craft</title>
    <link rel="icon" href="assets/img/3D SC.png">
    <link rel="stylesheet" href="assets/styles/style.css">
    <script src="assets/js/script.js" defer></script>
  </head>
  <body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <main class="container" style="padding:4rem 1rem; text-align:center;">
      <h1 style="font-size:2.2rem;margin-bottom:0.6rem">404 — Stránka nenájdená</h1>
      <p style="color:var(--muted);margin-bottom:1.4rem">Prepáč, stránka ktorú hľadáš neexistuje alebo bola presunutá.</p>
      <p>
        <a class="btn" href="index.php">Späť na domov</a>
        <a class="btn ghost" href="/" style="margin-left:.6rem">Kontaktuj nás na Discord</a>
      </p>
      <section style="margin-top:2rem;color:var(--muted)">
        <p>Môžeš tiež skontrolovať URL alebo navštíviť jednu z hlavných stránok:</p>
        <div style="display:flex;gap:0.6rem;justify-content:center;margin-top:0.8rem;flex-wrap:wrap">
          <a class="btn small" href="vip.php">VIP</a>
          <a class="btn small ghost" href="team.php">Tím</a>
          <a class="btn small" href="votes.php">Hlasovanie</a>
        </div>
      </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
  </body>
</html>
