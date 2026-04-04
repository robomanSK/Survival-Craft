<!doctype html>
<html lang="sk">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="assets/img/3D SC.png">
    <title>VIP | Survival-Craft</title>
    <link rel="stylesheet" href="assets/styles/style.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.3.2/css/flag-icons.min.css" />
    <script src="assets/js/script.js" defer></script>
  </head>
  <body>
    <header class="hero">
      <nav class="site-nav">
        <div class="container">
					<a class="brand" href="index.html"><img src="assets/img/3D SC.png" alt="SurvivalCraft Logo" class="brand-logo"></a>
          <div class="lang-accordion">
            <button class="lang-toggle" type="button" aria-expanded="false" aria-label="Vybrať jazyk"><span class="fi fi-sk"></span><span class="arrow">▼</span></button>
            <div class="lang-options" aria-hidden="true">
							<button class="lang-btn" data-lang="sk" type="button"><span class="fi fi-sk"></span> SK</button>
							<button class="lang-btn" data-lang="cz" type="button"><span class="fi fi-cz"></span> CZ</button>
            </div>
          </div>
          <button class="nav-toggle" aria-expanded="false" aria-label="Otvoriť menu" data-aria-sk="Otvoriť menu" data-aria-cz="Otevřít nabídku"><span class="hamburger"></span></button>
          <ul class="nav-list">
            <li><a class="nav-link" href="index.html" data-text-sk="Domov" data-text-cz="Domů">Domov</a></li>
            <li><a class="nav-link" href="vip.html" data-text-sk="VIP" data-text-cz="VIP">VIP</a></li>
            <li><a class="nav-link" href="team.html" data-text-sk="Tím" data-text-cz="Tým">Tím</a></li>
            <li><a class="nav-link" href="votes.html" data-text-sk="Hlasovanie" data-text-cz="Hlasování">Hlasovanie</a></li>
            <li><a class="nav-link" href="https://discord.gg/vXQBZ7Z" target="_blank" rel="noopener" data-text-sk="Discord" data-text-cz="Discord">Discord</a></li>
          </ul>
        </div>
      </nav>
      <div class="container hero-inner">
        <div class="hero-text">
          <h1 data-text-sk="VIP - Survival-Craft" data-text-cz="VIP - Survival-Craft">VIP - Survival-Craft</h1>
          <p class="lead" data-text-sk="Podporte server a získajte výhody" data-text-cz="Podpořte server a získejte výhody">Podporte server a získajte výhody</p>
          <div class="hero-cta">
            <a class="btn" href="index.html" data-text-sk="Späť na hlavnú" data-text-cz="Zpět na domovskou">Späť na hlavnú</a>
            <a class="btn ghost" href="#donate" data-text-sk="Darovanie" data-text-cz="Darování">Darovanie</a>
          </div>
        </div>
      </div>
    </header>

    <main class="container">
      <section id="vip" class="vip">
        <h2 data-text-sk="VIP výhody" data-text-cz="VIP výhody">VIP výhody</h2>
        <p class="intro" data-text-sk="Staň sa VIP a podpora serveru ti prinesie komfort a pekné bonusy. Všetky balíčky sú bezpečné a legálne." data-text-cz="Staň se VIPem a podpora serveru ti přinese komfort a pěkné bonusy. Všechny balíčky jsou bezpečné a legální.">Staň sa VIP a podpora serveru ti prinesie komfort a pekné bonusy. Všetky balíčky sú bezpečné a legálne.</p>

        <!-- Prepínač medzi režimami -->
        <div class="mode-switcher">
          <button class="mode-btn active" data-mode="survival">Survival</button>
          <button class="mode-btn" data-mode="skyblock">Skyblock</button>
        </div>

        <!-- Survival VIP výhody -->
        <div class="vip-grid" id="survival-vip">
          <div class="vip-card popular">
            <h3>VIP</h3>
            <p class="price" data-price-sk="€4.99 / mesiac" data-price-cz="129 Kč / měsíc">€4.99 / mesiac</p>
            <ul>
              <li>Prednosť v rade (priority join)</li>
              <li>Väčší /nick color + prefix</li>
              <li>Malý chest / home bonus (1 extra home)</li>
              <li>Vstup do VIP kanála na Discorde</li>
            </ul>
            <a class="btn vip-btn" href="#donate" data-text-sk="Kúpiť VIP" data-text-cz="Koupit VIP" data-href-sk="#donate" data-href-cz="https://payment-cz.example.com/vip">Kúpiť VIP</a>
          </div>

          <div class="vip-card">
            <h3>VIP+</h3>
            <p class="price" data-price-sk="€9.99 / mesiac" data-price-cz="249 Kč / měsíc">€9.99 / mesiac</p>
            <ul>
              <li>Všetko z VIP</li>
              <li>Extra homey (3)</li>
              <li>Menší warp slot</li>
              <li>Zvýhodnené ceny v hráčskom obchode</li>
            </ul>
            <a class="btn vip-btn" href="#donate" data-text-sk="Kúpiť VIP+" data-text-cz="Koupit VIP+" data-href-sk="#donate" data-href-cz="https://payment-cz.example.com/vip-plus">Kúpiť VIP+</a>
          </div>

          <div class="vip-card">
            <h3>Sponzor</h3>
            <p class="price">Sponzorské balíčky</p>
            <ul>
              <li>Podpora serveru + exkluzívny sponzorský odznak</li>
              <li>Prístup k mesačným giveaway</li>
            </ul>
            <a class="btn vip-btn" href="#donate" data-text-sk="Stať sa sponzorom" data-text-cz="Stát se sponzorem" data-href-sk="#donate" data-href-cz="https://payment-cz.example.com/sponsor">Stať sa sponzorom</a>
          </div>
        </div>

        <!-- Skyblock VIP výhody -->
        <div class="vip-grid hidden" id="skyblock-vip">
          <div class="vip-card popular">
            <h3>VIP</h3>
            <p class="price" data-price-sk="€4.99 / mesiac" data-price-cz="129 Kč / měsíc">€4.99 / mesiac</p>
            <ul>
              <li>Prednosť v rade (priority join)</li>
              <li>Farby a prefixý v chate</li>
              <li>Island vylepšenia a bonusy</li>
              <li>Vstup do VIP kanála na Discorde</li>
            </ul>
            <a class="btn vip-btn" href="#donate" data-text-sk="Kúpiť VIP" data-text-cz="Koupit VIP" data-href-sk="#donate" data-href-cz="https://payment-cz.example.com/vip">Kúpiť VIP</a>
          </div>

          <div class="vip-card">
            <h3>VIP+</h3>
            <p class="price" data-price-sk="€9.99 / mesiac" data-price-cz="249 Kč / měsíc">€9.99 / mesiac</p>
            <ul>
              <li>Všetko z VIP</li>
              <li>Viac priestoru na island (2x väčší)</li>
              <li>Špeciálne prestiže rewards</li>
              <li>Zvýhodnené ceny v obchode</li>
            </ul>
            <a class="btn vip-btn" href="#donate" data-text-sk="Kúpiť VIP+" data-text-cz="Koupit VIP+" data-href-sk="#donate" data-href-cz="https://payment-cz.example.com/vip-plus">Kúpiť VIP+</a>
          </div>

          <div class="vip-card">
            <h3>Sponzor</h3>
            <p class="price">Sponzorské balíčky</p>
            <ul>
              <li>Podpora serveru + exkluzívny sponzorský odznak</li>
              <li>Prístup k mesačným giveaway</li>
            </ul>
            <a class="btn vip-btn" href="#donate" data-text-sk="Stať sa sponzorom" data-text-cz="Stát se sponzorem" data-href-sk="#donate" data-href-cz="https://payment-cz.example.com/sponsor">Stať sa sponzorom</a>
          </div>
        </div>

      <section id="donate" class="connect">
        <h2>Darovanie</h2>
        <p>Podporiť server môžete cez Stripe / PayPal alebo vopred dohodnutý spôsob. Kontakt: <a href="mailto:admin@survivalcraft.sk">admin@survivalcraft.sk</a></p>
        <p><a class="btn" href="#">Prejsť na darovanie</a></p>
        <p class="dynmaps">
          <a class="btn small" href="https://survival.survival-craft.sk" target="_blank" rel="noopener">Dynmap Survival</a>
          <a class="btn small ghost" href="https://vanilla.survival-craft.sk" target="_blank" rel="noopener">Dynmap Vanilla</a>
        </p>
      </section>
    </main>

    <footer class="site-footer">
      <div class="container">
        <p data-text-sk="© Survival-Craft • Built with ❤️ for players" data-text-cz="© Survival-Craft • Vytvořeno s ❤️ pro hráče">© Survival-Craft • Built with ❤️ for players </p>
        <div class="footer-contact">
          <span data-text-sk="Kontakt:" data-text-cz="Kontakt:">Kontakt:</span>
          <a class="btn small" href="https://discord.gg/vXQBZ7Z" target="_blank" rel="noopener" data-text-sk="Discord" data-text-cz="Discord">Discord</a>
          <a class="btn small ghost" href="feedback.html" data-text-sk="Spätná väzba" data-text-cz="Zpětná vazba">Spätná väzba</a>
          <a class="btn small ghost" href="baltop.html" data-text-sk="Baltop" data-text-cz="Baltop">Baltop</a>
        </div>
      </div>
    </footer>

  </body>
</html>
