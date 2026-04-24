<?php
include 'includes/auth.php';
requireLogin(); // Ensure the user is logged in

// If logged in, load the profile UI:
include 'profile.html'; 
?>