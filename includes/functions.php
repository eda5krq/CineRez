<?php
declare(strict_types=1);

function startAppSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function sanitizeInput($value): string
{
    return e(trim((string) $value));
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function setFlash(string $type, string $message): void
{
    startAppSession();
    $_SESSION['flash'][$type][] = $message;
}

function consumeFlashes(): array
{
    startAppSession();
    $flashes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);

    return $flashes;
}

function formatPrice($price): string
{
    return 'EUR ' . number_format((float) $price, 2);
}

function posterUrl(?string $poster, string $basePath = ''): string
{
    $poster = trim((string) $poster);
    $fallback = 'images/placeholder.svg';

    if ($poster === '') {
        return $basePath . $fallback;
    }

    if (filter_var($poster, FILTER_VALIDATE_URL)) {
        return $poster;
    }

    $poster = normalizePosterPath($poster);
    if ($poster === '') {
        return $basePath . $fallback;
    }

    $candidates = [];
    if (str_starts_with($poster, 'uploads/') || str_starts_with($poster, 'images/') || str_starts_with($poster, 'assets/')) {
        $candidates[] = $poster;
    } elseif (str_contains($poster, '/')) {
        $candidates[] = $poster;
    } else {
        $candidates[] = 'uploads/' . $poster;
        $candidates[] = 'images/' . $poster;
        $candidates[] = 'assets/' . $poster;
    }

    foreach (array_unique($candidates) as $candidate) {
        if (projectAssetExists($candidate)) {
            return $basePath . $candidate;
        }
    }

    return $basePath . $fallback;
}

function normalizePosterPath(string $poster): string
{
    $poster = str_replace('\\', '/', trim($poster));
    $poster = ltrim($poster, '/');
    $poster = preg_replace('#^(\./)+#', '', $poster) ?? '';

    if ($poster === '' || str_contains($poster, "\0")) {
        return '';
    }

    $segments = explode('/', $poster);
    if (in_array('..', $segments, true)) {
        return '';
    }

    return $poster;
}

function projectAssetExists(string $relativePath): bool
{
    $projectRoot = realpath(__DIR__ . '/..');
    $fullPath = realpath(__DIR__ . '/../' . $relativePath);

    if ($projectRoot === false || $fullPath === false) {
        return false;
    }

    return str_starts_with($fullPath, $projectRoot)
        && is_file($fullPath)
        && filesize($fullPath) > 0;
}

function uploadMoviePoster(array $file, string $uploadDirectory): array
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['success' => true, 'path' => null, 'message' => ''];
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return ['success' => false, 'path' => null, 'message' => 'Poster upload failed. Please try another image.'];
    }

    $maxBytes = 2 * 1024 * 1024;
    if (($file['size'] ?? 0) > $maxBytes) {
        return ['success' => false, 'path' => null, 'message' => 'Poster must be smaller than 2 MB.'];
    }

    $extension = strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($extension, $allowedExtensions, true)) {
        return ['success' => false, 'path' => null, 'message' => 'Poster must be a JPG, JPEG, PNG, or WEBP file.'];
    }

    $tmpName = (string) ($file['tmp_name'] ?? '');
    if (!is_uploaded_file($tmpName)) {
        return ['success' => false, 'path' => null, 'message' => 'Poster upload could not be verified.'];
    }

    if (@getimagesize($tmpName) === false) {
        return ['success' => false, 'path' => null, 'message' => 'Poster must be a valid image file.'];
    }

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0775, true);
    }

    $filename = 'poster_' . date('YmdHis') . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
    $destination = rtrim($uploadDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($tmpName, $destination)) {
        return ['success' => false, 'path' => null, 'message' => 'Poster could not be saved.'];
    }

    return ['success' => true, 'path' => 'uploads/' . $filename, 'message' => ''];
}

function sendContactEmail(string $name, string $email, string $subject, string $message): bool
{
    $to = 'info@cinerez.com';
    $safeName = str_replace(["\r", "\n"], ' ', $name);
    $safeEmail = str_replace(["\r", "\n"], '', $email);
    $safeSubject = str_replace(["\r", "\n"], ' ', $subject);
    $body = "Name: {$safeName}\nEmail: {$safeEmail}\nSubject: {$safeSubject}\n\n{$message}";
    $headers = "From: {$safeEmail}\r\nReply-To: {$safeEmail}\r\nContent-Type: text/plain; charset=UTF-8";
    $sent = false;

    // PHP mail() needs a configured local mail server or SMTP relay in XAMPP/Laragon/WAMP.
    // When that is not configured, CineRez stores the outgoing message in logs/contact_emails.log.
    if (function_exists('mail')) {
        try {
            $sent = @mail($to, $safeSubject, $body, $headers);
        } catch (Throwable $exception) {
            error_log('CineRez mail() failed: ' . $exception->getMessage());
        }
    }

    if ($sent) {
        return true;
    }

    $logDirectory = __DIR__ . '/../logs';
    if (!is_dir($logDirectory)) {
        mkdir($logDirectory, 0775, true);
    }

    $logEntry = "----- " . date('Y-m-d H:i:s') . " -----\n" . $body . "\n\n";
    file_put_contents($logDirectory . '/contact_emails.log', $logEntry, FILE_APPEND | LOCK_EX);

    return true;
}
