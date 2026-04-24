<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | CineRez</title>
    <link rel="stylesheet" href="css/style.css">
    <noscript><style>body{opacity:1!important;transform:none!important;}</style></noscript>
    <script defer src="js/main.js"></script>
</head>
<body>
<div class="background-overlay"></div>
<header class="site-header glass">
    <div class="container nav-wrap">
        <a class="logo" href="index.html"><img src="images/cinerez-logo.svg" alt="CineRez logo"><span>CineRez</span></a>
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">Menu</button>
        <?php include 'nav.php'; ?>
    </div>
</header>
<main class="container">
    <section class="checkout-grid">
        <article class="glass summary-card">
            <h2>Booking Summary</h2>
            <p><strong>Movie:</strong> The Super Mario Galaxy Movie</p>
            <p><strong>Date:</strong> 2026-04-26</p>
            <p><strong>Time:</strong> 18:30</p>
            <p><strong>Seats:</strong> B2, B3</p>
            <p><strong>Ticket count:</strong> 2</p>
            <p><strong>Total:</strong> EUR 10.00</p>
        </article>
        <article class="glass">
            <h2>Customer Information</h2>
            <form class="stack-form" method="post" action="#" data-static-demo="true">
                <label>Full Name</label><input type="text" name="full_name" required>
                <label>Email</label><input type="email" name="email" required>
                <label>Phone</label><input type="text" name="phone" placeholder="+38344123456" required>
                <label>Payment Method</label>
                <select name="payment_method" required>
                    <option value="pay_at_cinema">Pay at cinema</option>
                    <option value="card_demo">Card payment (demo unavailable)</option>
                </select>
                <button class="btn btn-primary" type="submit">Confirm Reservation</button>
            </form>
        </article>
    </section>

    <section class="glass ticket-card">
        <h2>Your Ticket</h2>
        <p><strong>Reservation Code:</strong> CRZ-2026-1201</p>
        <p><strong>Name:</strong> Demo User</p>
        <p><strong>Movie:</strong> The Super Mario Galaxy Movie</p>
        <p><strong>Date &amp; Time:</strong> 2026-04-26 at 18:30</p>
        <p><strong>Seats:</strong> B2, B3</p>
        <p><strong>Total:</strong> EUR 10.00</p>
    </section>
</main>
<footer class="site-footer"><div class="container footer-inner"><p>&copy; 2026 CineRez. All rights reserved.</p><p>Frontend-only static demo version.</p></div></footer>
</body>
</html>
