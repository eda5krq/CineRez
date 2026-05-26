<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/validation.php';

requireLogin();

$pageTitle = 'Edit Reservation';
$basePath = '';
$errors = [];
$reservationId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if (!$reservationId) {
    setFlash('error', 'Please choose a valid reservation.');
    redirect('profile.php');
}

try {
    $pdo = getPDO();
    $statement = $pdo->prepare(
        'SELECT r.id, r.reservation_date, r.seats, r.status, m.title
         FROM reservations r
         INNER JOIN movies m ON m.id = r.movie_id
         WHERE r.id = :id AND r.user_id = :user_id
         LIMIT 1'
    );
    $statement->execute([
        'id' => $reservationId,
        'user_id' => currentUserId(),
    ]);
    $reservation = $statement->fetch();

    if (!$reservation) {
        setFlash('error', 'Reservation not found.');
        redirect('profile.php');
    }

    if ($reservation['status'] !== 'active') {
        setFlash('error', 'Cancelled reservations cannot be edited.');
        redirect('profile.php');
    }
} catch (Throwable $exception) {
    setFlash('error', $exception->getMessage());
    redirect('profile.php');
}

$reservationDate = $_POST['reservation_date'] ?? $reservation['reservation_date'];
$seats = $_POST['seats'] ?? $reservation['seats'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateRequired((string) $reservationDate, 'Reservation date', $errors);
    validatePositiveInt($seats, 'Seats', $errors);

    if ($reservationDate < date('Y-m-d')) {
        $errors[] = 'Reservation date cannot be in the past.';
    }

    if ((int) $seats > 10) {
        $errors[] = 'You can reserve up to 10 seats.';
    }

    if (empty($errors)) {
        try {
            $update = $pdo->prepare(
                'UPDATE reservations
                 SET reservation_date = :reservation_date, seats = :seats
                 WHERE id = :id AND user_id = :user_id AND status = :status'
            );
            $update->execute([
                'reservation_date' => $reservationDate,
                'seats' => (int) $seats,
                'id' => $reservationId,
                'user_id' => currentUserId(),
                'status' => 'active',
            ]);

            setFlash('success', 'Reservation updated successfully.');
            redirect('profile.php');
        } catch (Throwable $exception) {
            $errors[] = 'Reservation could not be updated.';
            error_log('CineRez reservation update failed: ' . $exception->getMessage());
        }
    }
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/views/reservations/edit-form.php';
include __DIR__ . '/includes/footer.php';
