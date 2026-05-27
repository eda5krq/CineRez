<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

header('Content-Type: application/json');

function jsonResponse(bool $success, string $message): void
{
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if (!isLoggedIn()) {
    jsonResponse(false, 'Please log in to cancel reservations.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Invalid request method.');
}

$reservationId = filter_input(INPUT_POST, 'reservation_id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$reservationId) {
    jsonResponse(false, 'Invalid reservation id.');
}

try {
    $pdo = getPDO();
    $statement = $pdo->prepare(
        'SELECT id, status FROM reservations WHERE id = :id AND user_id = :user_id LIMIT 1'
    );
    $statement->execute([
        'id' => $reservationId,
        'user_id' => currentUserId(),
    ]);
    $reservation = $statement->fetch();

    if (!$reservation) {
        jsonResponse(false, 'Reservation not found.');
    }

    if ($reservation['status'] === 'cancelled') {
        jsonResponse(true, 'Reservation was already cancelled.');
    }

    $update = $pdo->prepare(
        "UPDATE reservations SET status = 'cancelled' WHERE id = :id AND user_id = :user_id"
    );
    $update->execute([
        'id' => $reservationId,
        'user_id' => currentUserId(),
    ]);

    jsonResponse(true, 'Reservation cancelled successfully.');
} catch (Throwable $exception) {
    error_log('CineRez AJAX cancel failed: ' . $exception->getMessage());
    jsonResponse(false, 'Reservation could not be cancelled.');
}
