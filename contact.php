<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/validation.php';

$pageTitle = 'Contact';
$basePath = '';
$contactErrors = [];
$contactSuccess = '';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateRequired($name, 'Name', $contactErrors);
    validateLength($name, 'Name', 2, 100, $contactErrors);
    validateRequired($email, 'Email', $contactErrors);
    validateEmailAddress($email, $contactErrors);
    validateRequired($subject, 'Subject', $contactErrors);
    validateLength($subject, 'Subject', 3, 150, $contactErrors);
    validateRequired($message, 'Message', $contactErrors);
    validateLength($message, 'Message', 10, 1000, $contactErrors);

    if (empty($contactErrors)) {
        try {
            $pdo = getPDO();
            $statement = $pdo->prepare(
                'INSERT INTO contact_messages (name, email, subject, message)
                 VALUES (:name, :email, :subject, :message)'
            );
            $statement->execute([
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
            ]);

            sendContactEmail($name, $email, $subject, $message);
            $contactSuccess = 'Message sent successfully. If local email is not configured, a copy was written to logs/contact_emails.log.';
            $name = $email = $subject = $message = '';
        } catch (Throwable $exception) {
            $contactErrors[] = 'Message could not be saved. Please try again.';
            error_log('CineRez contact form failed: ' . $exception->getMessage());
        }
    }
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/views/contact/form.php';
include __DIR__ . '/includes/footer.php';
