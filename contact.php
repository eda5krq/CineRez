<?php
require_once __DIR__ . '/includes/functions.php';

$contactErrors = [];
$contactSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $subject = sanitizeInput($_POST['subject'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');

    if (!preg_match('/^[A-Za-z\s]{2,}$/', $name)) {
        $contactErrors[] = 'Name must contain only letters and spaces, minimum 2 characters.';
    }

    if (!preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $email)) {
        $contactErrors[] = 'Email format is not valid.';
    }

    if (!preg_match('/^[A-Za-z0-9\s.,!?-]{3,}$/', $subject)) {
        $contactErrors[] = 'Subject must contain at least 3 valid characters.';
    }

    if (!preg_match('/^.{10,500}$/s', $message)) {
        $contactErrors[] = 'Message must be between 10 and 500 characters.';
    }

    if (empty($contactErrors)) {
        $contactSuccess = 'Message validated successfully. Thank you for contacting CineRez.';
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | CineRez</title>
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
            <a class="logo" href="index.php"><img src="images/cinerez-logo.svg" alt="CineRez logo"><span>CineRez</span></a>
            <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">Menu</button>
            <?php include 'nav.php'; ?>
        </div>
    </header>
    <main class="container">
        <section class="glass page-head">
            <h1>Contact CineRez</h1>
            <p>Questions, feedback, or support? Send us a message.</p>
        </section>
        <section class="checkout-grid">
            <article class="glass">
                <h2>Contact Form</h2>
                <?php if (!empty($contactErrors)): ?>
                    <div class="alert error">
                        <?php foreach ($contactErrors as $error): ?>
                            <p><?php echo sanitizeInput($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($contactSuccess !== ''): ?>
                    <div class="alert success">
                        <p><?php echo sanitizeInput($contactSuccess); ?></p>
                    </div>
                <?php endif; ?>
                <form method="post" action="contact.php" class="stack-form">
                    <label>Name</label><input type="text" name="name" required>
                    <label>Email</label><input type="email" name="email" required>
                    <label>Subject</label><input type="text" name="subject" required>
                    <label>Message</label><textarea name="message" rows="5" required></textarea>
                    <button class="btn btn-primary" type="submit">Send Message</button>
                </form>
            </article>
            <article class="glass">
                <h2>Cinema Info</h2>
                <p><strong>Address:</strong> Rr. Dardania 15, Prishtina</p>
                <p><strong>Phone:</strong> +38344123456</p>
                <p><strong>Email:</strong> info@cinerez.com</p>
                <p><strong>Opening Hours:</strong> 10:00 - 23:30</p>
                <div class="faq">
                    <h3>FAQ</h3>
                    <button class="faq-question" type="button">Can I cancel a reservation?</button>
                    <div class="faq-answer">
                        <p>Yes, at the cinema counter before showtime (demo policy).</p>
                    </div>
                    <button class="faq-question" type="button">Do you support card payment online?</button>
                    <div class="faq-answer">
                        <p>This static version is frontend-only.</p>
                    </div>
                    <button class="faq-question" type="button">Can I reserve for a friend?</button>
                    <div class="faq-answer">
                        <p>Yes, use their name and phone during checkout.</p>
                    </div>
                </div>
            </article>
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