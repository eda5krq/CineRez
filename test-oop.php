<?php

require_once __DIR__ . "/Classes/movie.php";
require_once __DIR__ . "/Classes/user.php";
require_once __DIR__ . "/Classes/admin.php";
require_once __DIR__ . "/Classes/booking.php";

$movie = new Movie("Interstellar", "Sci-Fi", "169 min", 4.8, 5);
$user = new User("normalUser", "user");
$admin = new Admin("adminUser", "admin");
$booking = new Booking("Interstellar", "Eda", "eda@example.com", "044123456", 2);

?>
<!DOCTYPE html>
<html>
<head>
    <title>CineRez OOP Test</title>
</head>
<body>

    <h1>CineRez - OOP Test</h1>

    <h2>Movie Information</h2>
    <p><strong>Title:</strong> <?php echo $movie->getTitle(); ?></p>
    <p><strong>Genre:</strong> <?php echo $movie->getGenre(); ?></p>
    <p><strong>Duration:</strong> <?php echo $movie->getDuration(); ?></p>
    <p><strong>Rating:</strong> <?php echo $movie->getRating(); ?></p>
    <p><strong>Price:</strong> <?php echo $movie->getPrice(); ?> €</p>

    <hr>

    <h2>User Information</h2>
    <p><strong>Username:</strong> <?php echo $user->getUsername(); ?></p>
    <p><strong>Role:</strong> <?php echo $user->getRole(); ?></p>

    <hr>

    <h2>Admin Information</h2>
    <p><strong>Username:</strong> <?php echo $admin->getUsername(); ?></p>
    <p><strong>Role:</strong> <?php echo $admin->getRole(); ?></p>

    <?php if ($admin->canManageMovies()) { ?>
        <p><strong>Admin Access:</strong> Can manage movies</p>
    <?php } else { ?>
        <p><strong>Admin Access:</strong> Cannot manage movies</p>
    <?php } ?>

    <hr>

    <h2>Booking Information</h2>
    <p><strong>Movie:</strong> <?php echo $booking->getMovieTitle(); ?></p>
    <p><strong>Customer:</strong> <?php echo $booking->getCustomerName(); ?></p>
    <p><strong>Email:</strong> <?php echo $booking->getEmail(); ?></p>
    <p><strong>Phone:</strong> <?php echo $booking->getPhone(); ?></p>
    <p><strong>Tickets:</strong> <?php echo $booking->getTickets(); ?></p>

</body>
</html>