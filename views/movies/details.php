<main class="container">
    <section class="movie-details glass">
        <div class="details-poster poster-placeholder large">
            <img src="<?php echo e(posterUrl($movie['poster'], $basePath ?? '')); ?>" alt="<?php echo e($movie['title']); ?> poster">
        </div>

        <div class="details-content">
            <h1><?php echo e($movie['title']); ?></h1>

            <p class="small-muted">
                <?php echo e($movie['genre']); ?> |
                <?php echo (int) $movie['duration']; ?> min |
                <?php echo (int) $movie['release_year']; ?>
            </p>

            <p><?php echo e($movie['description']); ?></p>
            <p><strong>Genre:</strong> <?php echo e($movie['genre']); ?></p>
            <p><strong>Duration:</strong> <?php echo (int) $movie['duration']; ?> min</p>
            <p><strong>Release Year:</strong> <?php echo (int) $movie['release_year']; ?></p>

            <div class="showtimes">
                <h3>Showtimes</h3>
                <span>16:00</span>
                <span>18:30</span>
                <span>21:00</span>
            </div>

            <a class="btn btn-primary" href="booking.php?movie_id=<?php echo (int) $movie['id']; ?>">Reserve Tickets</a>
        </div>
    </section>
</main>
