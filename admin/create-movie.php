<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/validation.php';

requireAdmin();

$pageTitle = 'Create Movie';
$basePath = '../';
$errors = [];
$movieData = [
    'title' => trim($_POST['title'] ?? ''),
    'description' => trim($_POST['description'] ?? ''),
    'genre' => trim($_POST['genre'] ?? ''),
    'duration' => trim($_POST['duration'] ?? ''),
    'release_year' => trim($_POST['release_year'] ?? date('Y')),
    'poster' => '',
];
$formTitle = 'Create Movie';
$formSubtitle = 'Add a movie to the local CineRez database.';
$formAction = 'create-movie.php';
$submitLabel = 'Create Movie';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateRequired($movieData['title'], 'Title', $errors);
    validateLength($movieData['title'], 'Title', 2, 150, $errors);
    validateRequired($movieData['description'], 'Description', $errors);
    validateLength($movieData['description'], 'Description', 10, 5000, $errors);
    validateRequired($movieData['genre'], 'Genre', $errors);
    validateLength($movieData['genre'], 'Genre', 2, 100, $errors);
    validatePositiveInt($movieData['duration'], 'Duration', $errors);
    validatePositiveInt($movieData['release_year'], 'Release year', $errors);

    $posterUpload = uploadMoviePoster($_FILES['poster'] ?? [], __DIR__ . '/../uploads');
    if (!$posterUpload['success']) {
        $errors[] = $posterUpload['message'];
    }

    if (empty($errors)) {
        try {
            $pdo = getPDO();
            $statement = $pdo->prepare(
                'INSERT INTO movies (title, description, genre, duration, release_year, poster)
                 VALUES (:title, :description, :genre, :duration, :release_year, :poster)'
            );
            $statement->execute([
                'title' => $movieData['title'],
                'description' => $movieData['description'],
                'genre' => $movieData['genre'],
                'duration' => (int) $movieData['duration'],
                'release_year' => (int) $movieData['release_year'],
                'poster' => $posterUpload['path'] ?: 'placeholder.svg',
            ]);

            setFlash('success', 'Movie created successfully.');
            redirect('movies.php');
        } catch (Throwable $exception) {
            $errors[] = 'Movie could not be created.';
            error_log('CineRez movie create failed: ' . $exception->getMessage());
        }
    }
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../views/admin/movie-form.php';
include __DIR__ . '/../includes/footer.php';
