<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/validation.php';

$pageTitle = 'Login';
$basePath = '';
$errors = [];
$email = trim($_POST['email'] ?? '');

if (isLoggedIn()) {
    redirect('profile.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = (string) ($_POST['password'] ?? '');

    validateRequired($email, 'Email', $errors);
    validateEmailAddress($email, $errors);
    validateRequired($password, 'Password', $errors);

    if (empty($errors)) {
        try {
            $pdo = getPDO();
            $statement = $pdo->prepare('SELECT id, name, email, password, role FROM users WHERE email = :email LIMIT 1');
            $statement->execute(['email' => $email]);
            $user = $statement->fetch();

            if ($user && password_verify($password, $user['password'])) {
                loginUser($user);
                redirect($user['role'] === 'admin' ? 'admin/index.php' : 'profile.php');
            }

            $errors[] = 'Invalid email or password.';
        } catch (Throwable $exception) {
            $errors[] = $exception->getMessage();
        }
    }
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/views/auth/login-form.php';
include __DIR__ . '/includes/footer.php';
