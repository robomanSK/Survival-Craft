<?php
$teamMembers = [
  [
    'avatar' => '👑',
    'name' => 'roboman_SK',
    'role' => 'Zakladatel & Majitel',
    'description' => 'Zakladatel serveru a veduci administracie. Rozhoduje o smerovani serveru.',
    'description_cz' => 'Zakladatel serveru a vedoucí administrace. Rozhoduje o směřování serveru.',
    'stoat_url' => 'https://stt.gg/hYkyHSFc',
  ],
  [
    'avatar' => '⚔️',
    'name' => 'Admin 2',
    'role' => 'Senior Administrator',
    'description' => 'Spravuje technicku cast serveru a riadi ostatnych admincov.',
    'description_cz' => 'Spravuje technickou část serveru a řídí ostatní adminy.',
    'stoat_url' => 'https://stt.gg/hYkyHSFc',
  ],
  [
    'avatar' => '🛡️',
    'name' => 'Admin 3',
    'role' => 'Moderator',
    'description' => 'Dozera na bezpecnost a poriadok na serveri.',
    'description_cz' => 'Dohlíží na bezpečnost a pořádek na serveru.',
    'stoat_url' => 'https://stt.gg/hYkyHSFc',
  ],
  [
    'avatar' => '🔧',
    'name' => 'Admin 4',
    'role' => 'Vyvojar',
    'description' => 'Vyvija pluginy a zlepsuje technicku infrastrukturu serveru.',
    'description_cz' => 'Vyvíjí pluginy a zlepšuje technickou infrastrukturu serveru.',
    'stoat_url' => 'https://stt.gg/hYkyHSFc',
  ],
];

require_once __DIR__ . '/includes/db.php';
$pdo = getDbConnection();

if ($pdo instanceof PDO) {
  try {
    $stmt = $pdo->query("SELECT p.username AS name, p.uuid AS uuid, p.primary_group AS role, '' AS description, '👤' AS avatar, 'https://stt.gg/hYkyHSFc' AS stoat_url
      FROM luckperms_players p
      JOIN luckperms_groups g ON g.name = p.primary_group
      LEFT JOIN (
        SELECT name, MAX(CAST(SUBSTRING_INDEX(permission, '.', -1) AS UNSIGNED)) AS weight
        FROM luckperms_group_permissions
        WHERE permission LIKE 'weight.%'
        GROUP BY name
      ) gw ON gw.name = g.name
      WHERE p.primary_group != 'default' AND p.primary_group != 'vip' AND p.primary_group != 'tiktoker' AND p.primary_group != 'yt'
      ORDER BY COALESCE(gw.weight, 0) DESC, p.primary_group ASC, p.username ASC");
    $rows = $stmt->fetchAll();
    if (!empty($rows)) {
      $teamMembers = $rows;
    }
  } catch (Throwable $e) {
    // Keep static fallback when query/table is not available.
  }
}
?>
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
      <?php include __DIR__ . '/includes/navbar.php'; ?>
      <div class="container hero-inner">
        <div class="hero-text">
          <h1 data-text-sk="Admin Tím" data-text-cz="Admin Tým">Admin Tím</h1>
          <p class="lead" data-text-sk="Stretnite náš tím správcov serveru" data-text-cz="Poznamenejte si náš tým správců serveru">Stretnite náš tím správcov serveru</p>
          <div class="hero-cta">
            <a class="btn" href="index.php" data-text-sk="Späť na hlavnú" data-text-cz="Zpět na domovskou">Späť na hlavnú</a>
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
          <?php foreach ($teamMembers as $member): ?>
            <div class="team-member">
              <div class="member-avatar">
                <?php
                $rawUuid = (string)($member['uuid'] ?? '');
                $skinUuid = strtolower(preg_replace('/[^a-f0-9]/i', '', $rawUuid));
                ?>
                <?php if ($skinUuid !== ''): ?>
                  <img
                    src="https://mc-heads.net/avatar/<?php echo htmlspecialchars($skinUuid); ?>/96"
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    onerror="if(!this.dataset.fallback){this.dataset.fallback='1';this.src='https://crafatar.com/avatars/<?php echo htmlspecialchars($skinUuid); ?>?size=96&overlay';return;} this.style.display='none'; this.nextElementSibling.style.display='inline-flex';"
                  />
                  <span class="avatar-fallback" style="display:none;"><?php echo htmlspecialchars((string)($member['avatar'] ?? '👤')); ?></span>
                <?php else: ?>
                  <?php echo htmlspecialchars((string)($member['avatar'] ?? '👤')); ?>
                <?php endif; ?>
              </div>
              <h3><?php echo htmlspecialchars((string)($member['name'] ?? 'Admin')); ?></h3>
              <p class="role"><?php echo htmlspecialchars((string)($member['role'] ?? 'Role')); ?></p>
              <p class="description" data-text-sk="<?php echo htmlspecialchars((string)($member['description'] ?? '')); ?>" data-text-cz="<?php echo htmlspecialchars((string)($member['description_cz'] ?? '')); ?>"><?php echo htmlspecialchars((string)($member['description'] ?? '')); ?></p>
              <div class="socials">
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <section class="connect">
        <h2 data-text-sk="Kontaktuj tím" data-text-cz="Kontaktuj tým">Kontaktuj tím</h2>
        <p data-text-sk="Máš otázky alebo chceš nahlásit problém? Kontaktuj nás cez Stoat alebo pomocou spätnej vazby." data-text-cz="Máš otázky nebo chceš nahlásit problém? Kontaktuj nás přes Stoat nebo pomocí zpětné vazby.">Máš otázky alebo chceš nahlásit problém? Kontaktuj nás cez Stoat alebo pomocou spätnej vazby.</p>
        <p><a class="btn" href="https://stt.gg/hYkyHSFc" target="_blank" rel="noopener" data-text-sk="Prejsť na Stoat" data-text-cz="Jít na Stoat">Prejsť na Stoat</a></p>
      </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

  </body>
</html>
