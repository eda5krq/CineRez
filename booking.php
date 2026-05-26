<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

requireLogin();

$pageTitle = 'Booking';
$basePath = '';
$errors = [];
$showtimes = ['16:00', '18:30', '21:00'];
$occupiedSeats = ['A3', 'A4', 'B5', 'C2', 'C8', 'D6', 'E1', 'F9', 'G4', 'H7'];
$formData = $_POST;

$movieId = filter_input(INPUT_POST, 'movie_id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])
    ?: filter_input(INPUT_GET, 'movie_id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])
    ?: 1;

try {
    $pdo = getPDO();
    $statement = $pdo->prepare('SELECT id, title, description, genre, duration, release_year, poster FROM movies WHERE id = :id');
    $statement->execute(['id' => $movieId]);
    $movie = $statement->fetch();

    if (!$movie) {
        setFlash('error', 'Movie not found.');
        redirect('movies.php');
    }
} catch (Throwable $exception) {
    setFlash('error', $exception->getMessage());
    redirect('movies.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservationDate = trim($_POST['reservation_date'] ?? '');
    $showtime = trim($_POST['showtime'] ?? '');
    $adultTickets = max(0, (int) ($_POST['adult_tickets'] ?? 0));
    $studentTickets = max(0, (int) ($_POST['student_tickets'] ?? 0));
    $childTickets = max(0, (int) ($_POST['child_tickets'] ?? 0));
    $selectedSeats = trim($_POST['selected_seats'] ?? '');
    $seatCodes = array_values(array_filter(array_map('trim', explode(',', $selectedSeats))));
    $ticketCount = $adultTickets + $studentTickets + $childTickets;

    if ($reservationDate === '') {
        $errors[] = 'Reservation date is required.';
    } elseif ($reservationDate < date('Y-m-d')) {
        $errors[] = 'Reservation date cannot be in the past.';
    }

    if (!in_array($showtime, $showtimes, true)) {
        $errors[] = 'Please choose a valid showtime.';
    }

    if ($ticketCount < 1) {
        $errors[] = 'Choose at least one ticket.';
    }

    if (count($seatCodes) !== $ticketCount) {
        $errors[] = 'Selected seats must match the number of tickets.';
    }

    foreach ($seatCodes as $seatCode) {
        if (!preg_match('/^[A-H](10|[1-9])$/', $seatCode) || in_array($seatCode, $occupiedSeats, true)) {
            $errors[] = 'One or more selected seats are invalid.';
            break;
        }
    }

    if (empty($errors)) {
        $_SESSION['pending_reservation'] = [
            'movie_id' => (int) $movie['id'],
            'reservation_date' => $reservationDate,
            'showtime' => $showtime,
            'seat_codes' => $seatCodes,
            'seats' => $ticketCount,
            'adult_tickets' => $adultTickets,
            'student_tickets' => $studentTickets,
            'child_tickets' => $childTickets,
            'total' => ($adultTickets * 5.00) + ($studentTickets * 3.50) + ($childTickets * 2.50),
        ];

        redirect('checkout.php');
    }
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/views/reservations/booking-form.php';
include __DIR__ . '/includes/footer.php';
