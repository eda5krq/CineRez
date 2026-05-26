<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/validation.php';

requireLogin();

$pageTitle = 'Checkout';
$basePath = '';
$errors = [];
$reservationSuccess = false;
$reservationId = null;
$pending = $_SESSION['pending_reservation'] ?? null;
$fullName = $_SESSION['user_name'] ?? '';
$email = $_SESSION['user_email'] ?? '';

if (!$pending) {
    setFlash('error', 'Please choose seats before checkout.');
    redirect('movies.php');
}

try {
    $pdo = getPDO();
    $statement = $pdo->prepare('SELECT id, title, genre, duration, release_year, poster FROM movies WHERE id = :id');
    $statement->execute(['id' => (int) $pending['movie_id']]);
    $movie = $statement->fetch();

    if (!$movie) {
        unset($_SESSION['pending_reservation']);
        setFlash('error', 'Movie not found.');
        redirect('movies.php');
    }
} catch (Throwable $exception) {
    setFlash('error', $exception->getMessage());
    redirect('movies.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $paymentMethod = trim($_POST['payment_method'] ?? '');

    validateRequired($fullName, 'Full name', $errors);
    validateLength($fullName, 'Full name', 2, 100, $errors);
    validateRequired($email, 'Email', $errors);
    validateEmailAddress($email, $errors);

    if (!in_array($paymentMethod, ['pay_at_cinema', 'card_demo'], true)) {
        $errors[] = 'Please choose a valid payment method.';
    }

    if (empty($errors)) {
        try {
            $insert = $pdo->prepare(
                'INSERT INTO reservations (user_id, movie_id, reservation_date, seats, status)
                 VALUES (:user_id, :movie_id, :reservation_date, :seats, :status)'
            );
            $insert->execute([
                'user_id' => currentUserId(),
                'movie_id' => (int) $pending['movie_id'],
                'reservation_date' => $pending['reservation_date'],
                'seats' => (int) $pending['seats'],
                'status' => 'active',
            ]);

            $reservationId = (int) $pdo->lastInsertId();
            $reservationSuccess = true;
            unset($_SESSION['pending_reservation']);
        } catch (Throwable $exception) {
            $errors[] = 'Reservation could not be saved. Please try again.';
            error_log('CineRez reservation insert failed: ' . $exception->getMessage());
        }
    }
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/views/reservations/checkout-summary.php';
include __DIR__ . '/includes/footer.php';
