<?php if (!empty($dbError)): ?>
    <div class="alert error"><?php echo e($dbError); ?></div>
<?php endif; ?>

<?php if (empty($featuredMovies)): ?>
    <div class="glass empty-state">
        <p>No featured movies are available yet.</p>
    </div>
<?php else: ?>
    <div class="movie-grid">
        <?php foreach ($featuredMovies as $movie): ?>
            <article class="movie-card glass">
                <div class="poster-placeholder">
                    <img src="<?php echo e(posterUrl($movie['poster'], $basePath)); ?>" alt="<?php echo e($movie['title']); ?> poster">
                </div>
                <h3><?php echo e($movie['title']); ?></h3>
                <p><?php echo e($movie['genre']); ?> | <?php echo (int) $movie['duration']; ?> min</p>
                <p class="rating">Released: <?php echo (int) $movie['release_year']; ?></p>
                <div class="card-actions">
                    <a class="btn btn-sm" href="<?php echo e($basePath); ?>movie-details.php?id=<?php echo (int) $movie['id']; ?>">View Details</a>
                    <a class="btn btn-sm btn-outline" href="<?php echo e($basePath); ?>booking.php?movie_id=<?php echo (int) $movie['id']; ?>">Book</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
