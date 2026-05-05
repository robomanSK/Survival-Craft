<?php
require_once __DIR__ . '/includes/auth.php';

$pdo = scEnsureStorage();
$admin = scRequireAdmin();
$message = '';
$statusFilter = 'all';
$allowedFilters = ['all', 'new', 'in_progress', 'handled'];

if (isset($_GET['status']) && in_array((string)$_GET['status'], $allowedFilters, true)) {
    $statusFilter = (string)$_GET['status'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($pdo === null) {
        $message = 'Databázové pripojenie nie je dostupné.';
    } elseif (!scVerifyCsrfToken('admin', (string)($_POST['csrf_token'] ?? ''))) {
        $message = 'Platnosť formulára vypršala, skúste to znova.';
    } else {
        $action = (string)($_POST['action'] ?? '');
        $feedbackId = (int)($_POST['feedback_id'] ?? 0);
        $newStatus = (string)($_POST['status'] ?? 'new');

        if ($action === 'update_status' && $feedbackId > 0 && scUpdateFeedbackStatus($pdo, $feedbackId, $newStatus)) {
            header('Location: admin.php?status=' . rawurlencode($statusFilter));
            exit;
        }

        $message = 'Nepodarilo sa aktualizovať stav správy.';
    }
}

$csrfToken = scCsrfToken('admin');
$messages = $pdo instanceof PDO ? scFetchFeedbackMessages($pdo, $statusFilter === 'all' ? null : $statusFilter) : [];
$counts = $pdo instanceof PDO ? scAdminCountFeedback($pdo) : ['new' => 0, 'in_progress' => 0, 'handled' => 0, 'all' => 0];
$statusLabels = [
    'new' => 'Nové',
    'in_progress' => 'Rozpracované',
    'handled' => 'Spracované',
];
?>
<!doctype html>
<html lang="sk">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin panel | Survival-Craft</title>
    <link rel="stylesheet" href="assets/styles/style.css">
  </head>
  <body>
    <header class="hero admin-hero">
      <div class="container hero-inner admin-hero-inner">
        <div class="hero-text">
          <h1>Admin panel</h1>
          <p class="lead">Prihlásený ako <?php echo htmlspecialchars((string)($admin['display_name'] ?? $admin['username']), ENT_QUOTES, 'UTF-8'); ?>.</p>
        </div>
        <div class="hero-cta">
          <a class="btn ghost" href="index.php">Späť na web</a>
          <a class="btn" href="logout.php">Odhlásiť sa</a>
        </div>
      </div>
    </header>

    <main class="container admin-shell">
      <?php if ($message !== ''): ?>
        <div class="feedback-alert" role="alert"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
      <?php endif; ?>

      <section class="admin-stats grid">
        <div class="feature"><h2><?php echo (int)$counts['all']; ?></h2><p>Všetky správy</p></div>
        <div class="feature"><h2><?php echo (int)$counts['new']; ?></h2><p>Nové</p></div>
        <div class="feature"><h2><?php echo (int)$counts['in_progress']; ?></h2><p>Rozpracované</p></div>
        <div class="feature"><h2><?php echo (int)$counts['handled']; ?></h2><p>Spracované</p></div>
      </section>

      <section class="admin-panel">
        <div class="admin-panel-head">
          <h2>Spätná väzba</h2>
          <div class="admin-filters">
            <?php foreach ($allowedFilters as $filterKey): ?>
              <a class="filter-chip<?php echo $statusFilter === $filterKey ? ' active' : ''; ?>" href="admin.php?status=<?php echo htmlspecialchars($filterKey, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($statusLabels[$filterKey] ?? 'Všetko', ENT_QUOTES, 'UTF-8'); ?></a>
            <?php endforeach; ?>
          </div>
        </div>

        <?php if ($pdo === null): ?>
          <p>Tabuľku spätnej väzby sa nepodarilo načítať.</p>
        <?php elseif (empty($messages)): ?>
          <p>Zatiaľ tu nie sú žiadne správy.</p>
        <?php else: ?>
          <div class="admin-table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Dátum</th>
                  <th>Od</th>
                  <th>Správa</th>
                  <th>Stav</th>
                  <th>Akcia</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($messages as $messageRow): ?>
                  <tr>
                    <td><?php echo htmlspecialchars((string)($messageRow['created_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                      <strong><?php echo htmlspecialchars((string)($messageRow['name'] ?: 'Bez mena'), ENT_QUOTES, 'UTF-8'); ?></strong><br />
                      <span class="small"><?php echo htmlspecialchars((string)($messageRow['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span>
                    </td>
                    <td>
                      <div class="admin-message"><?php echo nl2br(htmlspecialchars((string)($messageRow['message'] ?? ''), ENT_QUOTES, 'UTF-8')); ?></div>
                      <div class="small admin-meta">Súhlas: <?php echo !empty($messageRow['consent']) ? 'áno' : 'nie'; ?></div>
                    </td>
                    <td><span class="status-pill status-<?php echo htmlspecialchars((string)($messageRow['status'] ?? 'new'), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($statusLabels[(string)($messageRow['status'] ?? 'new')] ?? 'Nové', ENT_QUOTES, 'UTF-8'); ?></span></td>
                    <td>
                      <form method="post" action="admin.php?status=<?php echo htmlspecialchars($statusFilter, ENT_QUOTES, 'UTF-8'); ?>" class="admin-action-form">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="action" value="update_status" />
                        <input type="hidden" name="feedback_id" value="<?php echo (int)$messageRow['id']; ?>" />
                        <?php if ((string)($messageRow['status'] ?? 'new') !== 'handled'): ?>
                          <input type="hidden" name="status" value="handled" />
                          <button class="btn small" type="submit">Označiť ako spracované</button>
                        <?php else: ?>
                          <input type="hidden" name="status" value="new" />
                          <button class="btn small ghost" type="submit">Vrátiť na nové</button>
                        <?php endif; ?>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </section>
    </main>
  </body>
</html>
