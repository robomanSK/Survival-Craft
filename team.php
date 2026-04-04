<!doctype html>
<html lang="sk">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="assets/img/3D SC.png">
    <title>Tím | Survival-Craft</title>
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
          <h1 data-text-sk="Admin Tím" data-text-cz="Admin Tým">Admin Tím</h1>
          <p class="lead" data-text-sk="Stretnite náš tím správcov serveru" data-text-cz="Poznamenejte si náš tým správců serveru">Stretnite náš tím správcov serveru</p>
          <div class="hero-cta">
            <a class="btn" href="index.html" data-text-sk="Späť na hlavnú" data-text-cz="Zpět na domovskou">Späť na hlavnú</a>
            <a class="btn ghost" href="#team" data-text-sk="Pozrieť tím" data-text-cz="Zobrazit tým">Pozrieť tím</a>
          </div>
        </div>
      </div>
    </header>

    <main class="container">
      <section id="team" class="team-section">
        <h2 data-text-sk="Náš tím" data-text-cz="Náš tým">Náš tím</h2>
        <p class="intro" data-text-sk="Tímu ľudí, ktorí robia z Survival-Craft skvelý server." data-text-cz="Tým lidí, kteří dělají ze Survival-Craft skvělý server.">Tímu ľudí, ktorí robia z Survival-Craft skvelý server.</p>

        <div class="team-grid">
          <div class="team-member">
            <div class="member-avatar">👑</div>
            <h3>Admin názov</h3>
            <p class="role">Zakladateľ & Vedúci</p>
            <p class="description">Zakladateľ serveru a vedúci administrácie. Rozhoduje o smerovaní serveru.</p>
            <div class="socials">
              <a href="https://discord.com" target="_blank" rel="noopener" class="social-link">Discord</a>
            </div>
          </div>

          <div class="team-member">
            <div class="member-avatar">⚔️</div>
            <h3>Admin 2</h3>
            <p class="role">Senior Administrator</p>
            <p class="description">Spravuje technickú časť serveru a riadi ostatných admincov.</p>
            <div class="socials">
              <a href="https://discord.com" target="_blank" rel="noopener" class="social-link">Discord</a>
            </div>
          </div>

          <div class="team-member">
            <div class="member-avatar">🛡️</div>
            <h3>Admin 3</h3>
            <p class="role">Moderátor</p>
            <p class="description">Dozerá na bezpečnosť a poriadok na serveri.</p>
            <div class="socials">
              <a href="https://discord.com" target="_blank" rel="noopener" class="social-link">Discord</a>
            </div>
          </div>

          <div class="team-member">
            <div class="member-avatar">🔧</div>
            <h3>Admin 4</h3>
            <p class="role">Vývojár</p>
            <p class="description">Vyvíja pluginy a zlepšuje technickú infraštruktúru serveru.</p>
            <div class="socials">
              <a href="https://discord.com" target="_blank" rel="noopener" class="social-link">Discord</a>
            </div>
          </div>
        </div>
      </section>

      <section class="connect">
        <h2 data-text-sk="Kontaktuj tím" data-text-cz="Kontaktuj tým">Kontaktuj tím</h2>
        <p data-text-sk="Máš otázky alebo chceš nahlásit problém? Kontaktuj nás cez Discord alebo email." data-text-cz="Máš otázky nebo chceš nahlásit problém? Kontaktuj nás přes Discord nebo e-mail.">Máš otázky alebo chceš nahlásit problém? Kontaktuj nás cez Discord alebo email.</p>
        <p><a class="btn" href="https://discord.gg/vXQBZ7Z" target="_blank" rel="noopener" data-text-sk="Prejsť na Discord" data-text-cz="Jít na Discord">Prejsť na Discord</a></p>
        <p style="color: var(--muted); margin-top: 1rem;" data-text-sk="Email: " data-text-cz="E-mail: ">Email: <a href="mailto:admin@survivalcraft.sk">admin@survivalcraft.sk</a></p>
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
