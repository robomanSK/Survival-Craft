<!doctype html>
<html lang="sk">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Survival-Craft je slovenský Minecraft server ponúkajúci režimy Survival, Skyblock a Vanilla. Pripojte sa k našej rastúcej komunite a zažite dobrodružstvo!" />
		<meta name="keywords" content="Minecraft, Survival, Skyblock, Vanilla, Slovenský server, Hranie, Komunita, Hry" />
		<meta name="author" content="Survival-Craft Team" />
		<link rel="icon" href="assets/img/3D SC.png">
		<title>Survival-Craft | Survival • Skyblock • Vanilla</title>
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
				<h1>Survival-Craft</h1>
				<p class="lead" >Slovenský Minecraft server — Survival • Skyblock • Vanilla</p>
				<p class="meta" >IP: <button id="copy-ip-text" class="copy-ip" data-ip="play.survival-craft.sk" aria-label="Kopírovať IP">play.survival-craft.sk</button> • Discord: <a class="meta-link" href="https://discord.gg/vXQBZ7Z" target="_blank" rel="noopener">discord.gg/vXQBZ7Z</a></p>
							<div class="hero-cta">
								<a class="btn" href="#features" data-text-sk="Viac o serveri" data-text-cz="Více o serveru">Viac o serveri</a>

							</div>
				</div>
				<div class="hero-card">
					<div class="card">
					<h3 data-text-sk="Rýchle pripojenie" data-text-cz="Rychlé připojení">Rýchle pripojenie</h3>
					<!-- tlačidlo skopíruje IP servera do schránky -->
					<button class="btn small" id="copy-ip-btn" data-ip="play.survival-craft.sk" type="button" data-text-sk="Pripojiť sa" data-text-cz="Připojit se">Pripojiť sa</button>
					<!-- rýchle odkazy na dynmapy  -->
					<div class="dynmaps">
						<a class="btn small" href="https://survival.survival-craft.sk" target="_blank" rel="noopener" >Dynmapa Survival</a>
						<a class="btn small ghost" href="https://vanilla.survival-craft.sk" target="_blank" rel="noopener" >Dynmapa Vanilla</a>
					</div>
					</div>
				</div>
			</div>
		</header>

		<main class="container">
			<section id="features" class="features">
				<h2 data-text-sk="Čo ponúkame" data-text-cz="Co nabízíme">Čo ponúkame</h2>
				<div class="grid">
					<article class="feature">
						<h3>Survival</h3>
						<p data-text-sk="Tradičný survival s dôrazom na komunitu — economy, hráčske obchody a udalosti." data-text-cz="Tradiční survival se zaměřením na komunitu — ekonomika, hráčské obchody a události.">Tradičný survival s dôrazom na komunitu — economy, hráčske obchody a udalosti.</p>
					</article>
					<article class="feature">
						<h3>Skyblock</h3>
						<p data-text-sk="Stavanie ostrova, vlastné výzvy a súťaže — ideálne pre hráčov, ktorí majú radi progres." data-text-cz="Stavění ostrova, vlastní výzvy a soutěže — ideální pro hráče, kteří mají rádi progres.">Stavanie ostrova, vlastné výzvy a súťaže — ideálne pre hráčov, ktorí majú radi progres.</p>
					</article>
					<article class="feature">
						<h3>Vanilla</h3>
						<p data-text-sk="Čistý vanilla zážitok bez zbytočných pluginov — iba jemné vylepšenia pre stabilitu." data-text-cz="Čistý vanilla zážitek bez zbytečných pluginů — pouze jemná vylepšení pro stabilitu.">Čistý vanilla zážitok bez zbytočných pluginov — iba jemné vylepšenia pre stabilitu.</p>
					</article>
				</div>
			</section>

			<section class="vip-teaser">
				<div class="hero-slideshow" aria-roledescription="slideshow">
					<div class="slides">
						<img src="assets/img/galery/1.png" class="slide active" alt="Galeria 1">
						<img src="assets/img/galery/2.png" class="slide" alt="Galeria 2">
						<img src="assets/img/galery/3.png" class="slide" alt="Galeria 3">
					</div>
					<button class="slide-prev" aria-label="Predchádzajúci slide">‹</button>
					<button class="slide-next" aria-label="Ďalší slide">›</button>
					<div class="slide-indicators" aria-hidden="true"></div>
				</div>
			</section>

			<section id="rules" class="rules">
				<h2 data-text-sk="Pravidlá" data-text-cz="Pravidla">Pravidlá</h2>
				<ul>
					<li data-text-sk="Žiadny griefing ani stealing bez povolenia." data-text-cz="Žádný griefing ani krádež bez povolení.">Žiadny griefing ani stealing bez povolenia.</li>
					<li data-text-sk="Respektuj ostatných hráčov a staff." data-text-cz="Respektuj ostatní hráče a staff.">Respektuj ostatných hráčov a staff.</li>
					<li data-text-sk="Žiadne exploitovanie bugov — nahlás aj keď nájdeš." data-text-cz="Žádné zneužívání bugů — nahlaste i když najdete.">Žiadne exploitovanie bugov — nahlás aj keď nájdeš.</li>
					<li data-text-sk="Dodržiavaj pravidlá Discordu a Minecraft servera." data-text-cz="Dodržuj pravidla Discordu a Minecraft serveru.">Dodržiavaj pravidlá Discordu a Minecraft servera.</li>
				</ul>
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
	</footer>	</body>
</html>

