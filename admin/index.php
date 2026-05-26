<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$pageTitle = 'Admin Dashboard';
$basePath = '../';
$stats = ['movies' => 0, 'reservations' => 0, 'users' => 0, 'messages' => 0];
$latestReservations = [];
$dbError = '';

try {
    $pdo = getPDO();
    $stats['movies'] = (int) $pdo->query('SELECT COUNT(*) FROM movies')->fetchColumn();
    $stats['reservations'] = (int) $pdo->query("SELECT COUNT(*) FROM reservations WHERE status = 'active'")->fetchColumn();
    $stats['users'] = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    $stats['messages'] = (int) $pdo->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn();

    $statement = $pdo->query(
        'SELECT r.id, r.reservation_date, r.seats, r.status, u.name AS user_name, m.title
         FROM reservations r
         INNER JOIN users u ON u.id = r.user_id
         INNER JOIN movies m ON m.id = r.movie_id
         ORDER BY r.created_at DESC
         LIMIT 8'
    );
    $latestReservations = $statement->fetchAll();
} catch (Throwable $exception) {
    $dbError = $exception->getMessage();
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../views/admin/dashboard.php';
include __DIR__ . '/../includes/footer.php';
