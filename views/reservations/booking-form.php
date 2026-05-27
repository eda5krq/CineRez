<main class="container">
    <section class="glass page-head">
        <h1>Reserve Seats</h1>
        <p><?php echo e($movie['title']); ?> | <?php echo e($movie['genre']); ?> | <?php echo (int) $movie['duration']; ?> min</p>
    </section>

    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <section class="booking-layout">
        <form class="glass stack-form" method="post" action="booking.php" id="bookingForm" data-adult-price="5" data-student-price="3.5" data-child-price="2.5">
            <input type="hidden" name="movie_id" value="<?php echo (int) $movie['id']; ?>">
            <input type="hidden" name="selected_seats" id="selectedSeats" value="<?php echo e($formData['selected_seats'] ?? ''); ?>">

            <label for="reservation_date">Date</label>
            <input type="date" id="reservation_date" name="reservation_date" min="<?php echo e(date('Y-m-d')); ?>" value="<?php echo e($formData['reservation_date'] ?? ''); ?>" required>

            <label for="showtime">Time</label>
            <select id="showtime" name="showtime" required>
                <option value="">Select showtime</option>
                <?php foreach ($showtimes as $showtime): ?>
                    <option value="<?php echo e($showtime); ?>" <?php echo ($formData['showtime'] ?? '') === $showtime ? 'selected' : ''; ?>>
                        <?php echo e($showtime); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="ticket-grid">
                <div>
                    <label for="adultTickets">Adult Tickets (EUR 5.00)</label>
                    <input type="number" min="0" max="10" name="adult_tickets" id="adultTickets" value="<?php echo (int) ($formData['adult_tickets'] ?? 0); ?>" required>
                </div>
                <div>
                    <label for="studentTickets">Student Tickets (EUR 3.50)</label>
                    <input type="number" min="0" max="10" name="student_tickets" id="studentTickets" value="<?php echo (int) ($formData['student_tickets'] ?? 0); ?>" required>
                </div>
                <div>
                    <label for="childTickets">Child Tickets (EUR 2.50)</label>
                    <input type="number" min="0" max="10" name="child_tickets" id="childTickets" value="<?php echo (int) ($formData['child_tickets'] ?? 0); ?>" required>
                </div>
            </div>

            <p class="small-muted">Selected seats: <span id="selectedSeatsPreview">None</span></p>
            <p class="small-muted">Ticket total: <span id="ticketTotalPreview">EUR 0.00</span></p>
            <button class="btn btn-primary" type="submit">Continue to Checkout</button>
        </form>

        <section class="glass seat-panel">
            <h2>Choose Seats</h2>
            <div class="screen-arc">Screen</div>
            <div class="seat-map" id="seatMap">
                <?php foreach (range('A', 'H') as $row): ?>
                    <div class="seat-row">
                        <span class="row-label"><?php echo e($row); ?></span>
                        <?php for ($seat = 1; $seat <= 10; $seat++): ?>
                            <?php
                            $seatCode = $row . $seat;
                            $occupied = in_array($seatCode, $occupiedSeats, true);
                            ?>
                            <button type="button" class="seat <?php echo $occupied ? 'occupied' : 'available'; ?>" data-seat="<?php echo e($seatCode); ?>" <?php echo $occupied ? 'disabled' : ''; ?>>
                                <?php echo $seat; ?>
                            </button>
                        <?php endfor; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="legend">
                <span><i class="seat-dot available"></i> Available</span>
                <span><i class="seat-dot occupied"></i> Reserved</span>
                <span><i class="seat-dot selected"></i> Selected</span>
            </div>
        </section>
    </section>
</main>
