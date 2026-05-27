<main class="container">
    <section class="glass auth-card">
        <h1>Delete Movie</h1>
        <p>Are you sure you want to delete <strong><?php echo e($movie['title']); ?></strong>?</p>
        <p class="small-muted">Movies with reservations cannot be deleted because reservations keep a protected movie reference.</p>

        <form method="post" action="delete-movie.php" class="stack-form">
            <input type="hidden" name="id" value="<?php echo (int) $movie['id']; ?>">
            <button class="btn btn-danger" type="submit">Delete Movie</button>
            <a class="btn btn-outline" href="movies.php">Cancel</a>
        </form>
    </section>
</main>
