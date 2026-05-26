<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/auth.php';

$pageTitle = $pageTitle ?? 'CineRez';
$basePath = $basePath ?? '';
$flashMessages = consumeFlashes();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?> | CineRez</title>
    <link rel="stylesheet" href="<?php echo e($basePath); ?>css/style.css">
    <noscript><style>body{opacity:1!important;transform:none!important;}</style></noscript>
    <script defer src="<?php echo e($basePath); ?>js/main.js"></script>
</head>
<body>
<div class="background-overlay"></div>

<header class="site-header glass">
    <div class="container nav-wrap">
        <a class="logo" href="<?php echo e($basePath); ?>index.php" aria-label="CineRez home">
            <img src="<?php echo e($basePath); ?>images/cinerez-logo.svg" alt="CineRez logo">
            <span>CineRez</span>
        </a>
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">Menu</button>
        <?php include __DIR__ . '/nav.php'; ?>
    </div>
</header>

<?php if (!empty($flashMessages)): ?>
    <div class="container flash-stack">
        <?php foreach ($flashMessages as $type => $messages): ?>
            <?php foreach ($messages as $message): ?>
                <div class="alert <?php echo e($type); ?>"><?php echo e($message); ?></div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
