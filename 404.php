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
      <h1 style="font-size:2.2rem;margin-bottom:0.6rem" data-text-sk="404 — Stránka nenájdená" data-text-cz="404 — Stránka nenalezena">404 — Stránka nenájdená</h1>
      <p style="color:var(--muted);margin-bottom:1.4rem" data-text-sk="Prepáč, stránka ktorú hľadáš neexistuje alebo bola presunutá." data-text-cz="Omlouvám se, stránka, kterou hledáš, neexistuje nebo byla přesunuta.">Prepáč, stránka ktorú hľadáš neexistuje alebo bola presunutá.</p>
      <p>
        <a class="btn" href="index.php" data-text-sk="Späť na domov" data-text-cz="Zpět domů">Späť na domov</a>
        <a class="btn ghost" href="https://stt.gg/hYkyHSFc" target="_blank" rel="noopener" style="margin-left:.6rem" data-text-sk="Kontaktuj nás na Stoate" data-text-cz="Kontaktuj nás na Stoatu">Kontaktuj nás na Stoate</a>
      </p>
      <section style="margin-top:2rem;color:var(--muted)">
        <p data-text-sk="Môžeš tiež skontrolovať URL alebo navštíviť jednu z hlavných stránok:" data-text-cz="Můžeš také zkontrolovat URL nebo navštívit jednu z hlavních stránek:">Môžeš tiež skontrolovať URL alebo navštíviť jednu z hlavných stránok:</p>
        <div style="display:flex;gap:0.6rem;justify-content:center;margin-top:0.8rem;flex-wrap:wrap">
          <a class="btn small" href="vip.php" data-text-sk="VIP" data-text-cz="VIP">VIP</a>
          <a class="btn small ghost" href="team.php" data-text-sk="Tím" data-text-cz="Tým">Tím</a>
          <a class="btn small" href="votes.php" data-text-sk="Hlasovanie" data-text-cz="Hlasování">Hlasovanie</a>
        </div>
      </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
  </body>
</html>
