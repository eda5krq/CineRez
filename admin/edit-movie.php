<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/validation.php';

requireAdmin();

$pageTitle = 'Edit Movie';
$basePath = '../';
$errors = [];
$movieId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if (!$movieId) {
    setFlash('error', 'Please choose a valid movie.');
    redirect('movies.php');
}

try {
    $pdo = getPDO();
    $statement = $pdo->prepare('SELECT id, title, description, genre, duration, release_year, poster FROM movies WHERE id = :id');
    $statement->execute(['id' => $movieId]);
    $movieData = $statement->fetch();

    if (!$movieData) {
        setFlash('error', 'Movie not found.');
        redirect('movies.php');
    }
} catch (Throwable $exception) {
    setFlash('error', $exception->getMessage());
    redirect('movies.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieData['title'] = trim($_POST['title'] ?? '');
    $movieData['description'] = trim($_POST['description'] ?? '');
    $movieData['genre'] = trim($_POST['genre'] ?? '');
    $movieData['duration'] = trim($_POST['duration'] ?? '');
    $movieData['release_year'] = trim($_POST['release_year'] ?? '');

    validateRequired($movieData['title'], 'Title', $errors);
    validateLength($movieData['title'], 'Title', 2, 150, $errors);
    validateRequired($movieData['description'], 'Description', $errors);
    validateLength($movieData['description'], 'Description', 10, 5000, $errors);
    validateRequired($movieData['genre'], 'Genre', $errors);
    validateLength($movieData['genre'], 'Genre', 2, 100, $errors);
    validatePositiveInt($movieData['duration'], 'Duration', $errors);
    validatePositiveInt($movieData['release_year'], 'Release year', $errors);

    $posterPath = $movieData['poster'];
    $posterUpload = uploadMoviePoster($_FILES['poster'] ?? [], __DIR__ . '/../uploads');
    if (!$posterUpload['success']) {
        $errors[] = $posterUpload['message'];
    } elseif ($posterUpload['path']) {
        $posterPath = $posterUpload['path'];
    }

    if (empty($errors)) {
        try {
            $update = $pdo->prepare(
                'UPDATE movies
                 SET title = :title, description = :description, genre = :genre, duration = :duration, release_year = :release_year, poster = :poster
                 WHERE id = :id'
            );
            $update->execute([
                'title' => $movieData['title'],
                'description' => $movieData['description'],
                'genre' => $movieData['genre'],
                'duration' => (int) $movieData['duration'],
                'release_year' => (int) $movieData['release_year'],
                'poster' => $posterPath,
                'id' => $movieId,
            ]);

            setFlash('success', 'Movie updated successfully.');
            redirect('movies.php');
        } catch (Throwable $exception) {
            $errors[] = 'Movie could not be updated.';
            error_log('CineRez movie update failed: ' . $exception->getMessage());
        }
    }
}

$formTitle = 'Edit Movie';
$formSubtitle = 'Update local movie details and optionally replace the poster.';
$formAction = 'edit-movie.php?id=' . (int) $movieId;
$submitLabel = 'Save Changes';

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../views/admin/movie-form.php';
include __DIR__ . '/../includes/footer.php';
