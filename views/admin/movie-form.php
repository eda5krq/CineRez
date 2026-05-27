<main class="container">
    <section class="glass page-head">
        <h1><?php echo e($formTitle); ?></h1>
        <p><?php echo e($formSubtitle); ?></p>
    </section>

    <section class="glass auth-card">
        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo e($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo e($formAction); ?>" class="stack-form" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo e($movieData['title'] ?? ''); ?>" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" required><?php echo e($movieData['description'] ?? ''); ?></textarea>

            <div class="form-grid">
                <div>
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="genre" value="<?php echo e($movieData['genre'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="duration">Duration</label>
                    <input type="number" id="duration" name="duration" min="1" value="<?php echo e($movieData['duration'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="release_year">Release Year</label>
                    <input type="number" id="release_year" name="release_year" min="1888" max="2100" value="<?php echo e($movieData['release_year'] ?? date('Y')); ?>" required>
                </div>
            </div>

            <?php if (!empty($movieData['poster'])): ?>
                <div>
                    <p class="small-muted">Current poster</p>
                    <img class="poster-thumb large-thumb" src="<?php echo e(posterUrl($movieData['poster'], '../')); ?>" alt="Current poster">
                </div>
            <?php endif; ?>

            <label for="poster">Poster Upload</label>
            <input type="file" id="poster" name="poster" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
            <p class="small-muted">Allowed: JPG, JPEG, PNG, WEBP. Maximum size: 2 MB.</p>

            <button class="btn btn-primary" type="submit"><?php echo e($submitLabel); ?></button>
            <a class="btn btn-outline" href="movies.php">Cancel</a>
        </form>
    </section>
</main>
