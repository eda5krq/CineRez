<main class="container">
    <section class="glass auth-card">
        <h1>Create Account</h1>
        <p>Register to reserve faster and track your bookings.</p>

        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo e($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="register.php" class="stack-form">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?php echo e($name); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo e($email); ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button class="btn btn-primary" type="submit">Register</button>
        </form>
    </section>
</main>
