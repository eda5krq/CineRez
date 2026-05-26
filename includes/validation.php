<?php
declare(strict_types=1);

function validateRequired(string $value, string $label, array &$errors): void
{
    if (trim($value) === '') {
        $errors[] = $label . ' is required.';
    }
}

function validateEmailAddress(string $email, array &$errors): void
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
}

function validateLength(string $value, string $label, int $min, int $max, array &$errors): void
{
    $length = strlen(trim($value));

    if ($length < $min || $length > $max) {
        $errors[] = $label . " must be between {$min} and {$max} characters.";
    }
}

function validatePositiveInt($value, string $label, array &$errors): void
{
    if (filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
        $errors[] = $label . ' must be a positive number.';
    }
}
