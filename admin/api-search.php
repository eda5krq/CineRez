<?php
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$pageTitle = 'TVMaze Search';
$basePath = '../';

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../views/admin/api-search.php';
include __DIR__ . '/../includes/footer.php';
