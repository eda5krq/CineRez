<section class="glass panel-card recent-activity-card">
    <h2>My Reservations</h2>

    <div id="ajaxMessage" class="ajax-message" aria-live="polite"></div>

    <?php if (empty($reservations)): ?>
        <p>No reservations yet.</p>
        <a class="btn btn-primary" href="movies.php">Browse Movies</a>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Movie</th>
                        <th>Date</th>
                        <th>Seats</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr id="reservation-row-<?php echo (int) $reservation['id']; ?>" class="<?php echo $reservation['status'] === 'cancelled' ? 'reservation-cancelled' : ''; ?>">
                            <td><?php echo e($reservation['title']); ?></td>
                            <td><?php echo e($reservation['reservation_date']); ?></td>
                            <td><?php echo (int) $reservation['seats']; ?></td>
                            <td class="js-reservation-status">
                                <span class="status-badge status-<?php echo e($reservation['status']); ?>">
                                    <?php echo e(ucfirst($reservation['status'])); ?>
                                </span>
                            </td>
                            <td><?php echo e($reservation['created_at']); ?></td>
                            <td class="table-actions">
                                <?php if ($reservation['status'] === 'active'): ?>
                                    <a class="btn btn-sm btn-outline" href="edit-reservation.php?id=<?php echo (int) $reservation['id']; ?>">Edit</a>
                                    <button class="btn btn-sm btn-danger js-cancel-reservation" type="button" data-reservation-id="<?php echo (int) $reservation['id']; ?>" data-endpoint="ajax/delete-reservation.php">Cancel</button>
                                <?php else: ?>
                                    <span class="small-muted">No actions</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
