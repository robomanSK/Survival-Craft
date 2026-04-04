<!doctype html>
<html lang="sk">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="assets/img/3D SC.png">
    <title>Hlasovanie | Survival-Craft</title>
    <link rel="stylesheet" href="assets/styles/style.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.3.2/css/flag-icons.min.css" />
    <script src="assets/js/script.js" defer></script>
  </head>
  <body>
    <header class="hero">
      <?php include __DIR__ . '/includes/navbar.php'; ?>
      <div class="container hero-inner">
        <div class="hero-text">
          <h1 data-text-sk="Hlasovanie" data-text-cz="Hlasování">Hlasovanie</h1>
          <p class="lead" data-text-sk="Podporte server hlasovaním — získajte odmeny a pomôžte komunite rásť." data-text-cz="Podpořte server hlasováním — získejte odměny a pomozte komunitě růst.\">Podporte server hlasovaním — získajte odmeny a pomôžte komunite rásť.</p>
          <div class="hero-cta">
            <a class="btn" href="index.php" data-text-sk="Späť na hlavnú" data-text-cz="Zpět na domovskou">Späť na hlavnú</a>
            <a class="btn ghost" href="vip.php" data-text-sk="VIP & Darovanie" data-text-cz="VIP & Darování">VIP & Darovanie</a>
          </div>
        </div>
      </div>
    </header>

    <main class="container">
      <section id="votes" class="connect">
        <h2 data-text-sk="Kde hlasovať" data-text-cz="Kde hlasovat">Kde hlasovať</h2>
        <p class="intro" data-text-sk="Klikni na jednu z nižšie uvedených stránok a podporte náš server. Každé hlasovanie pomáha a často prináša odmeny priamo v hre." data-text-cz="Klikněte na jednu z níže uvedených stránek a podpořte náš server. Každé hlasování pomáhá a často přináší odměny přímo ve hře.\">Klikni na jednu z nižšie uvedených stránok a podporte náš server. Každé hlasovanie pomáha a často prináša odmeny priamo v hre.</p>

        <div class="votes-grid">
          <div class="vote-card">
            <h3>Czech-Craft</h3>
            <p class="description">Popis hlasovacej stránky alebo benefitov.</p>
            <p><a class="vote-link btn" href="https://czech-craft.eu/server/survivalcraft/vote/" target="_blank" rel="noopener">Hlasovať</a></p>
          </div>

          <div class="vote-card">
            <h3>Minecraftservers</h3>
            <p class="description">Popis hlasovacej stránky alebo benefitov.</p>
            <p><a class="vote-link btn" href="https://minecraftservers.org/vote/646590" target="_blank" rel="noopener">Hlasovať</a></p>
          </div>

          <div class="vote-card">
            <h3>MinecraftServery</h3>
            <p class="description">Popis hlasovacej stránky alebo benefitov.</p>
            <p><a class="vote-link btn" href="https://minecraftservery.eu/server/survivalcraft.407" target="_blank" rel="noopener">Hlasovať</a></p>
          </div>

          <div class="vote-card">
            <h3>Craftlist</h3>
            <p class="description">Popis hlasovacej stránky alebo benefitov.</p>
            <p><a class="vote-link btn" href="https://craftlist.org/survivalcraft" target="_blank" rel="noopener">Hlasovať</a></p>
          </div>
        </div>

      </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

  </body>
</html>
