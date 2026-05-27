<main class="container">
    <section class="glass page-head">
        <h1>Movies</h1>
        <p>Create, update, and delete local CineRez movie records.</p>
        <div class="admin-actions">
            <a class="btn btn-primary" href="create-movie.php">Create Movie</a>
            <a class="btn btn-outline" href="index.php">Dashboard</a>
        </div>
    </section>

    <?php if (!empty($dbError)): ?>
        <div class="alert error"><?php echo e($dbError); ?></div>
    <?php endif; ?>

    <section class="glass panel-card">
        <?php if (empty($movies)): ?>
            <p>No movies found.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Poster</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Duration</th>
                            <th>Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movies as $movie): ?>
                            <tr>
                                <td><img class="poster-thumb" src="<?php echo e(posterUrl($movie['poster'], '../')); ?>" alt="<?php echo e($movie['title']); ?> poster"></td>
                                <td><?php echo e($movie['title']); ?></td>
                                <td><?php echo e($movie['genre']); ?></td>
                                <td><?php echo (int) $movie['duration']; ?> min</td>
                                <td><?php echo (int) $movie['release_year']; ?></td>
                                <td class="table-actions">
                                    <a class="btn btn-sm btn-outline" href="edit-movie.php?id=<?php echo (int) $movie['id']; ?>">Edit</a>
                                    <a class="btn btn-sm btn-danger" href="delete-movie.php?id=<?php echo (int) $movie['id']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>
