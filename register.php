<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/validation.php';

$pageTitle = 'Register';
$basePath = '';
$errors = [];
$name = trim($_POST['name'] ?? $_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');

if (isLoggedIn()) {
    redirect('profile.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = (string) ($_POST['password'] ?? '');
    $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

    validateRequired($name, 'Full name', $errors);
    validateLength($name, 'Full name', 2, 100, $errors);
    validateRequired($email, 'Email', $errors);
    validateEmailAddress($email, $errors);
    validateLength($password, 'Password', 6, 72, $errors);

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        try {
            $pdo = getPDO();
            $statement = $pdo->prepare(
                'INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)'
            );
            $statement->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'user',
            ]);

            setFlash('success', 'Account created successfully. You can log in now.');
            redirect('login.php');
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                $errors[] = 'An account with this email already exists.';
            } else {
                $errors[] = 'Registration failed. Please try again.';
                error_log('CineRez registration failed: ' . $exception->getMessage());
            }
        } catch (Throwable $exception) {
            $errors[] = $exception->getMessage();
        }
    }
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/views/auth/register-form.php';
include __DIR__ . '/includes/footer.php';
