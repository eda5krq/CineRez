<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';

function isLoggedIn(): bool
{
    startAppSession();
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool
{
    startAppSession();
    return isLoggedIn() && ($_SESSION['user_role'] ?? '') === 'admin';
}

function currentUserId(): ?int
{
    startAppSession();
    return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
}

function requireLogin(string $loginPath = 'login.php'): void
{
    if (!isLoggedIn()) {
        setFlash('error', 'Please log in to continue.');
        redirect($loginPath);
    }
}

function requireAdmin(string $loginPath = '../login.php', string $fallbackPath = '../index.php'): void
{
    if (!isLoggedIn()) {
        setFlash('error', 'Please log in with an admin account.');
        redirect($loginPath);
    }

    if (!isAdmin()) {
        setFlash('error', 'You do not have permission to access the admin area.');
        redirect($fallbackPath);
    }
}

function requireRole(string $role): void
{
    if ($role === 'admin') {
        requireAdmin();
        return;
    }

    requireLogin();
}

function loginUser(array $user): void
{
    startAppSession();
    session_regenerate_id(true);

    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role'] = $user['role'];

    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['username'] = $user['name'];
    $_SESSION['full_name'] = $user['name'];
}
