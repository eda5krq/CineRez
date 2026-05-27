<main class="container">
    <section class="glass auth-card">
        <h1>Login</h1>
        <p>Use your CineRez account to reserve tickets and manage bookings.</p>

        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo e($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="login.php" class="stack-form">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo e($email); ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button class="btn btn-primary" type="submit">Login</button>
        </form>

        <div class="demo-box">
            <p><strong>User:</strong> user@cinerez.com / User123</p>
            <p><strong>Admin:</strong> admin@cinerez.com / Admin123</p>
        </div>
    </section>
</main>
