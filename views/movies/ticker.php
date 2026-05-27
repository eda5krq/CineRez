<?php if (!empty($tickerMovies)): ?>
    <div class="ticker">
        <?php foreach ($tickerMovies as $movie): ?>
            <span><?php echo e($movie['title']); ?></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
