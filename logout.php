<?php
require_once __DIR__ . '/includes/auth.php';

scLogoutAdmin();
header('Location: index.php');
exit;
