<main class="container">
    <section class="glass auth-card">
        <h1>Edit Reservation</h1>
        <p><?php echo e($reservation['title']); ?></p>

        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo e($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="edit-reservation.php?id=<?php echo (int) $reservation['id']; ?>" class="stack-form">
            <label for="reservation_date">Reservation Date</label>
            <input type="date" id="reservation_date" name="reservation_date" min="<?php echo e(date('Y-m-d')); ?>" value="<?php echo e($reservationDate); ?>" required>

            <label for="seats">Seats</label>
            <input type="number" id="seats" name="seats" min="1" max="10" value="<?php echo (int) $seats; ?>" required>

            <button class="btn btn-primary" type="submit">Save Changes</button>
            <a class="btn btn-outline" href="profile.php">Back to Profile</a>
        </form>
    </section>
</main>
