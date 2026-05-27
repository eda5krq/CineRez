<main class="container">
    <?php if ($reservationSuccess): ?>
        <section class="glass ticket-card">
            <h1>Reservation Confirmed</h1>
            <p><strong>Reservation Code:</strong> CRZ-<?php echo (int) $reservationId; ?></p>
            <p><strong>Movie:</strong> <?php echo e($movie['title']); ?></p>
            <p><strong>Date &amp; Time:</strong> <?php echo e($pending['reservation_date']); ?> at <?php echo e($pending['showtime']); ?></p>
            <p><strong>Seats:</strong> <?php echo e(implode(', ', $pending['seat_codes'])); ?></p>
            <p><strong>Total:</strong> <?php echo formatPrice($pending['total']); ?></p>
            <a class="btn btn-primary" href="profile.php">View My Reservations</a>
        </section>
    <?php else: ?>
        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo e($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <section class="checkout-grid">
            <article class="glass summary-card">
                <h2>Booking Summary</h2>
                <p><strong>Movie:</strong> <?php echo e($movie['title']); ?></p>
                <p><strong>Date:</strong> <?php echo e($pending['reservation_date']); ?></p>
                <p><strong>Time:</strong> <?php echo e($pending['showtime']); ?></p>
                <p><strong>Seats:</strong> <?php echo e(implode(', ', $pending['seat_codes'])); ?></p>
                <p><strong>Ticket count:</strong> <?php echo (int) $pending['seats']; ?></p>
                <p><strong>Total:</strong> <?php echo formatPrice($pending['total']); ?></p>
            </article>

            <article class="glass">
                <h2>Customer Information</h2>
                <form class="stack-form" method="post" action="checkout.php">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo e($fullName); ?>" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo e($email); ?>" required>

                    <label for="payment_method">Payment Method</label>
                    <select id="payment_method" name="payment_method" required>
                        <option value="pay_at_cinema">Pay at cinema</option>
                        <option value="card_demo">Card payment (demo)</option>
                    </select>

                    <button class="btn btn-primary" type="submit">Confirm Reservation</button>
                </form>
            </article>
        </section>
    <?php endif; ?>
</main>
