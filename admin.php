<?php
include 'includes/auth.php';
require_once __DIR__ . '/Classes/Admin.php';

requireRole("admin");

$admin = new Admin(
    "Admin User",
    "admin@cinerez.com",
    "admin",
    ["manage_movies", "manage_reservations", "view_reports"]
);

$movies = [
    "The Super Mario Galaxy Movie",
    "Project Hail Mary",
    "Lee Cronin's The Mummy",
    "The Drama",
    "You, Me & Tuscany",
    "Hoppers",
    "Reminders of Him",
    "A Great Awakening"
];

$reservations = [
    [
        "code" => "CRZ-2026-1201",
        "customer" => "Arta H.",
        "movie" => "Project Hail Mary",
        "seats" => ["B2", "B3"],
        "total" => 12.00
    ],
    [
        "code" => "CRZ-2026-1202",
        "customer" => "Erion P.",
        "movie" => "Hoppers",
        "seats" => ["D4", "D5", "D6"],
        "total" => 16.50
    ],
    [
        "code" => "CRZ-2026-1203",
        "customer" => "Lena K.",
        "movie" => "The Super Mario Galaxy Movie",
        "seats" => ["F7"],
        "total" => 5.00
    ],
    [
        "code" => "CRZ-2026-1204",
        "customer" => "Besa M.",
        "movie" => "A Great Awakening",
        "seats" => ["C1", "C2"],
        "total" => 9.00
    ]
];

$totalMovies = count($movies);
$totalReservations = count($reservations);

$totalRevenue = 0;
foreach ($reservations as $reservation) {
    $totalRevenue += $reservation["total"];
}

function cleanText($value)
{
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}

function formatPrice($price)
{
    return "EUR " . number_format($price, 2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | CineRez</title>
    <link rel="stylesheet" href="css/style.css">
    <noscript>
        <style>
            body {
                opacity: 1 !important;
                transform: none !important;
            }
        </style>
    </noscript>
    <script defer src="js/main.js"></script>
</head>
<body>

<div class="background-overlay"></div>

<header class="site-header glass">
    <div class="container nav-wrap">
        <a class="logo" href="index.php">
            <img src="images/cinerez-logo.svg" alt="CineRez logo">
            <span>CineRez</span>
        </a>

        <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">Menu</button>

        <?php include 'nav.php'; ?>
    </div>
</header>

<main class="container">
    <section class="glass page-head">
        <h1>Admin Dashboard</h1>

        <p><?php echo cleanText($admin->getDashboardMessage()); ?></p>

        <p>
            Logged in as:
            <strong><?php echo cleanText($admin->getRole()); ?></strong>
            (<?php echo cleanText($admin->getEmail()); ?>)
        </p>

        <p>
            Permissions:
            <?php echo cleanText(implode(", ", $admin->getPermissions())); ?>
        </p>
    </section>

    <section class="stats-grid">
        <article class="glass stat-card">
            <h3>Total Movies</h3>
            <p><?php echo $totalMovies; ?></p>
        </article>

        <article class="glass stat-card">
            <h3>Total Reservations</h3>
            <p><?php echo $totalReservations; ?></p>
        </article>

        <article class="glass stat-card">
            <h3>Total Revenue</h3>
            <p><?php echo formatPrice($totalRevenue); ?></p>
        </article>

        <article class="glass stat-card">
            <h3>Can Manage Movies</h3>
            <p><?php echo $admin->canManageMovies() ? "Yes" : "No"; ?></p>
        </article>
    </section>

    <section class="glass panel-card dashboard-table-card">
        <h2>Reservations</h2>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Customer</th>
                        <th>Movie</th>
                        <th>Seats</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo cleanText($reservation["code"]); ?></td>
                            <td><?php echo cleanText($reservation["customer"]); ?></td>
                            <td><?php echo cleanText($reservation["movie"]); ?></td>
                            <td><?php echo cleanText(implode(", ", $reservation["seats"])); ?></td>
                            <td><?php echo formatPrice($reservation["total"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="glass panel-card">
        <h2>OOP Admin Class Demo</h2>

        <p>
            This dashboard uses the <strong>Admin</strong> class from
            <code>Classes/Admin.php</code>.
        </p>

        <p>
            The Admin object is created with <code>new Admin(...)</code>,
            and the dashboard uses:
            <code>getDashboardMessage()</code>,
            <code>getEmail()</code>,
            <code>getPermissions()</code>,
            and <code>canManageMovies()</code>.
        </p>

        <p>
            This also demonstrates inheritance because
            <code>Admin extends User</code>.
        </p>
    </section>
</main>

<footer class="site-footer">
    <div class="container footer-inner">
        <p>&copy; 2026 CineRez. All rights reserved.</p>
        <p>Frontend-only static demo version.</p>
    </div>
</footer>

</body>
</html>