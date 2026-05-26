<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Movies';
$basePath = '';
$movies = [];
$genres = [];
$dbError = '';

$search = trim($_GET['search'] ?? '');
$genre = trim($_GET['genre'] ?? 'All');
$sort = trim($_GET['sort'] ?? '');

$sortOptions = [
    '' => 'created_at DESC',
    'title' => 'title ASC',
    'year' => 'release_year DESC',
    'duration' => 'duration ASC',
];
$orderBy = $sortOptions[$sort] ?? $sortOptions[''];

try {
    $pdo = getPDO();

    $genreStatement = $pdo->query('SELECT DISTINCT genre FROM movies ORDER BY genre ASC');
    $genres = array_column($genreStatement->fetchAll(), 'genre');

    $where = [];
    $params = [];

    if ($search !== '') {
        $where[] = 'title LIKE :search';
        $params['search'] = '%' . $search . '%';
    }

    if ($genre !== '' && $genre !== 'All') {
        $where[] = 'genre = :genre';
        $params['genre'] = $genre;
    }

    $sql = 'SELECT id, title, description, genre, duration, release_year, poster FROM movies';
    if (!empty($where)) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }
    $sql .= ' ORDER BY ' . $orderBy;

    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    $movies = $statement->fetchAll();
} catch (Throwable $exception) {
    $dbError = $exception->getMessage();
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/views/movies/list.php';
include __DIR__ . '/includes/footer.php';
