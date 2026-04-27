<?php

require_once __DIR__ . "/Classes/Movie.php";
require_once __DIR__ . "/Classes/User.php";
require_once __DIR__ . "/Classes/Admin.php";
require_once __DIR__ . "/Classes/Booking.php";
require_once __DIR__ . "/Classes/Ticket.php";

$movie = new Movie(
    1,
    "Project Hail Mary",
    "Sci-Fi",
    156,
    8.0,
    6.50
);

$user = new User(
    "Eda",
    "eda@example.com",
    "user"
);

$admin = new Admin(
    "Admin User",
    "admin@cinerez.com",
    "admin",
    ["manage_movies", "view_bookings"]
);

$booking = new Booking(
    1,
    "Eda",
    ["A1", "A2"],
    "2026-04-25",
    "20:00",
    13.00
);

$ticket = new Ticket(
    "standard",
    "A1",
    6.50
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CineRez OOP Test</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>CineRez - OOP Test</h1>

<p>
    This page demonstrates the use of PHP OOP classes in the CineRez project:
    Movie, User, Admin, Booking and Ticket.
</p>

<hr>

<h2>Movie Object</h2>
<p><strong>ID:</strong> <?php echo $movie->getId(); ?></p>
<p><strong>Title:</strong> <?php echo $movie->getTitle(); ?></p>
<p><strong>Genre:</strong> <?php echo $movie->getGenre(); ?></p>
<p><strong>Duration:</strong> <?php echo $movie->getDuration(); ?> min</p>
<p><strong>Rating:</strong> <?php echo $movie->getRating(); ?></p>
<p><strong>Price:</strong> <?php echo number_format($movie->getPrice(), 2); ?> €</p>
<p><strong>Short Info:</strong> <?php echo $movie->getShortInfo(); ?></p>

<hr>

<h2>User Object</h2>
<p><strong>Name:</strong> <?php echo $user->getName(); ?></p>
<p><strong>Email:</strong> <?php echo $user->getEmail(); ?></p>
<p><strong>Role:</strong> <?php echo $user->getRole(); ?></p>
<p><strong>Dashboard Message:</strong> <?php echo $user->getDashboardMessage(); ?></p>

<hr>

<h2>Admin Object - Inheritance Example</h2>
<p><strong>Name:</strong> <?php echo $admin->getName(); ?></p>
<p><strong>Email:</strong> <?php echo $admin->getEmail(); ?></p>
<p><strong>Role:</strong> <?php echo $admin->getRole(); ?></p>
<p><strong>Permissions:</strong> <?php echo implode(", ", $admin->getPermissions()); ?></p>

<?php if ($admin->canManageMovies()) { ?>
    <p><strong>Admin Access:</strong> Can manage movies</p>
<?php } else { ?>
    <p><strong>Admin Access:</strong> Cannot manage movies</p>
<?php } ?>

<p><strong>Admin Message:</strong> <?php echo $admin->getDashboardMessage(); ?></p>

<hr>

<h2>Booking Object</h2>
<p><strong>Movie ID:</strong> <?php echo $booking->getMovieId(); ?></p>
<p><strong>User Name:</strong> <?php echo $booking->getUserName(); ?></p>
<p><strong>Seats:</strong> <?php echo implode(", ", $booking->getSeats()); ?></p>
<p><strong>Date:</strong> <?php echo $booking->getDate(); ?></p>
<p><strong>Time:</strong> <?php echo $booking->getTime(); ?></p>
<p><strong>Total Price:</strong> <?php echo number_format($booking->getTotalPrice(), 2); ?> €</p>
<p><strong>Reservation Code:</strong> <?php echo $booking->generateReservationCode(); ?></p>
<p><strong>Booking Summary:</strong> <?php echo $booking->getBookingSummary(); ?></p>

<hr>

<h2>Ticket Object</h2>
<p><strong>Type:</strong> <?php echo $ticket->getType(); ?></p>
<p><strong>Seat:</strong> <?php echo $ticket->getSeat(); ?></p>
<p><strong>Price:</strong> <?php echo number_format($ticket->getPrice(), 2); ?> €</p>
<p><strong>Ticket Info:</strong> <?php echo $ticket->getTicketInfo(); ?></p>

<script src="js/main.js"></script>
</body>
</html>