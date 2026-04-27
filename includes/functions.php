<?php

function sanitizeInput($value)
{
    return htmlspecialchars(trim((string) $value), ENT_QUOTES, 'UTF-8');
}

function getMovieById($movies, $id)
{
    foreach ($movies as $movie) {
        if ((int) $movie['id'] === (int) $id) {
            return $movie;
        }
    }

    return null;
}

function formatPrice($price)
{
    return 'EUR ' . number_format((float) $price, 2);
}