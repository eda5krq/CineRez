<main class="container">
    <section class="glass page-head">
        <h1>Contact CineRez</h1>
        <p>Questions, feedback, or support? Send us a message.</p>
    </section>

    <section class="checkout-grid">
        <article class="glass">
            <h2>Contact Form</h2>

            <?php if (!empty($contactErrors)): ?>
                <div class="alert error">
                    <?php foreach ($contactErrors as $error): ?>
                        <p><?php echo e($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($contactSuccess !== ''): ?>
                <div class="alert success">
                    <p><?php echo e($contactSuccess); ?></p>
                </div>
            <?php endif; ?>

            <form method="post" action="contact.php" class="stack-form">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo e($name); ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo e($email); ?>" required>

                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" value="<?php echo e($subject); ?>" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required><?php echo e($message); ?></textarea>

                <button class="btn btn-primary" type="submit">Send Message</button>
            </form>
        </article>

        <article class="glass">
            <h2>Cinema Info</h2>
            <p><strong>Address:</strong> Rr. Dardania 15, Prishtina</p>
            <p><strong>Phone:</strong> +38344123456</p>
            <p><strong>Email:</strong> info@cinerez.com</p>
            <p><strong>Opening Hours:</strong> 10:00 - 23:30</p>

            <div class="faq">
                <h3>FAQ</h3>
                <button class="faq-question" type="button">Can I cancel a reservation?</button>
                <div class="faq-answer"><p>Yes, active reservations can be cancelled from your profile.</p></div>

                <button class="faq-question" type="button">Do you support card payment online?</button>
                <div class="faq-answer"><p>Card payment is shown as a local demo option. Real payments need a payment provider.</p></div>

                <button class="faq-question" type="button">Why was no real email sent?</button>
                <div class="faq-answer"><p>Local XAMPP needs SMTP/mail server configuration. CineRez logs fallback email content locally.</p></div>
            </div>
        </article>
    </section>
</main>
