<?php
require_once __DIR__ . '/includes/functions.php';

if (!isset($movie) || !is_array($movie)) {
    redirect('movies.php');
}

require __DIR__ . '/views/movies/details.php';
