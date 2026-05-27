<main class="container">
    <section class="glass page-head">
        <h1>Admin Dashboard</h1>
        <p>Manage movies, reservations, and external TVMaze lookup from one place.</p>
        <div class="admin-actions">
            <a class="btn btn-primary" href="movies.php">Manage Movies</a>
            <a class="btn btn-outline" href="api-search.php">TVMaze Search</a>
        </div>
    </section>

    <?php if (!empty($dbError)): ?>
        <div class="alert error"><?php echo e($dbError); ?></div>
    <?php endif; ?>

    <section class="stats-grid">
        <article class="glass stat-card">
            <h3>Total Movies</h3>
            <p><?php echo (int) ($stats['movies'] ?? 0); ?></p>
        </article>
        <article class="glass stat-card">
            <h3>Active Reservations</h3>
            <p><?php echo (int) ($stats['reservations'] ?? 0); ?></p>
        </article>
        <article class="glass stat-card">
            <h3>Users</h3>
            <p><?php echo (int) ($stats['users'] ?? 0); ?></p>
        </article>
        <article class="glass stat-card">
            <h3>Messages</h3>
            <p><?php echo (int) ($stats['messages'] ?? 0); ?></p>
        </article>
    </section>

    <section class="glass panel-card dashboard-table-card">
        <h2>Latest Reservations</h2>
        <?php if (empty($latestReservations)): ?>
            <p>No reservations yet.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Movie</th>
                            <th>Date</th>
                            <th>Seats</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($latestReservations as $reservation): ?>
                            <tr>
                                <td><?php echo e($reservation['user_name']); ?></td>
                                <td><?php echo e($reservation['title']); ?></td>
                                <td><?php echo e($reservation['reservation_date']); ?></td>
                                <td><?php echo (int) $reservation['seats']; ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo e($reservation['status']); ?>">
                                        <?php echo e(ucfirst($reservation['status'])); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>
