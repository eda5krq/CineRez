<section class="page-hero">
    <div class="container">
        <h1>Browse Movies</h1>
        <p class="section-subtitle">Find your next watch and reserve seats instantly.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (!empty($dbError)): ?>
            <div class="alert error"><?php echo e($dbError); ?></div>
        <?php endif; ?>

        <form method="get" action="movies.php" class="filter-bar glass">
            <input class="search-input" type="search" name="search" placeholder="Search by movie title..." value="<?php echo e($search); ?>">

            <select name="genre" class="search-input">
                <option value="All">All genres</option>
                <?php foreach ($genres as $genreOption): ?>
                    <option value="<?php echo e($genreOption); ?>" <?php echo $genre === $genreOption ? 'selected' : ''; ?>>
                        <?php echo e($genreOption); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="sort" class="search-input">
                <option value="">Newest first</option>
                <option value="title" <?php echo $sort === 'title' ? 'selected' : ''; ?>>Title A-Z</option>
                <option value="year" <?php echo $sort === 'year' ? 'selected' : ''; ?>>Release year</option>
                <option value="duration" <?php echo $sort === 'duration' ? 'selected' : ''; ?>>Shortest duration</option>
            </select>

            <button class="btn btn-primary" type="submit">Apply</button>
            <a class="btn btn-outline" href="movies.php">Reset</a>
        </form>

        <?php if (empty($movies)): ?>
            <div class="glass empty-state">
                <p>No movies found. Try another search or filter.</p>
            </div>
        <?php else: ?>
            <div class="movie-grid">
                <?php foreach ($movies as $movie): ?>
                    <article class="movie-card glass">
                        <div class="poster-placeholder">
                            <img src="<?php echo e(posterUrl($movie['poster'])); ?>" alt="<?php echo e($movie['title']); ?> poster">
                        </div>

                        <h3><?php echo e($movie['title']); ?></h3>
                        <p><?php echo e($movie['genre']); ?> | <?php echo (int) $movie['duration']; ?> min</p>
                        <p class="rating">Released: <?php echo (int) $movie['release_year']; ?></p>

                        <div class="card-actions">
                            <a class="btn btn-sm btn-outline" href="movie-details.php?id=<?php echo (int) $movie['id']; ?>">Details</a>
                            <a class="btn btn-sm btn-primary" href="booking.php?movie_id=<?php echo (int) $movie['id']; ?>">Book</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
