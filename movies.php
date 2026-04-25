<?php
require_once __DIR__ . '/Classes/Movie.php';

$movies = [
    [
        "object" => new Movie(1, "The Super Mario Galaxy Movie", "Animation", 98, 7.1, 5.50),
        "poster" => "movie1.jpg",
        "ageRating" => "PG"
    ],
    [
        "object" => new Movie(2, "Project Hail Mary", "Sci-Fi", 156, 8.0, 6.50),
        "poster" => "movie2.jpg",
        "ageRating" => "PG-13"
    ],
    [
        "object" => new Movie(3, "Lee Cronin's The Mummy", "Horror", 134, 6.3, 5.50),
        "poster" => "movie3.jpg",
        "ageRating" => "R"
    ],
    [
        "object" => new Movie(4, "The Drama", "Drama", 105, 6.8, 5.50),
        "poster" => "movie4.jpg",
        "ageRating" => "R"
    ],
    [
        "object" => new Movie(5, "You, Me & Tuscany", "Romance", 105, 6.4, 4.00),
        "poster" => "movie5.jpg",
        "ageRating" => "PG-13"
    ],
    [
        "object" => new Movie(6, "Hoppers", "Animation", 104, 7.3, 6.50),
        "poster" => "movie6.jpg",
        "ageRating" => "PG"
    ]
];

$search = $_GET["search"] ?? "";
$genre = $_GET["genre"] ?? "All";
$sort = $_GET["sort"] ?? "";

$filteredMovies = $movies;

if ($genre !== "All") {
    $filteredMovies = array_filter($filteredMovies, function ($movieItem) use ($genre) {
        return $movieItem["object"]->getGenre() === $genre;
    });
}

if ($search !== "") {
    $filteredMovies = array_filter($filteredMovies, function ($movieItem) use ($search) {
        return stripos($movieItem["object"]->getTitle(), $search) !== false;
    });
}

if ($sort === "title") {
    usort($filteredMovies, function ($a, $b) {
        return strcmp($a["object"]->getTitle(), $b["object"]->getTitle());
    });
} elseif ($sort === "rating") {
    usort($filteredMovies, function ($a, $b) {
        return $b["object"]->getRating() <=> $a["object"]->getRating();
    });
} elseif ($sort === "price") {
    usort($filteredMovies, function ($a, $b) {
        return $a["object"]->getPrice() <=> $b["object"]->getPrice();
    });
}

function cleanText($value)
{
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}

function formatPrice($price)
{
    return "EUR " . number_format($price, 2);
}

$genres = ["All", "Animation", "Drama", "Horror", "Romance", "Sci-Fi"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CineRez | Movies</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<header class="header">
    <div class="container navbar">
        <a class="logo" href="index.php">Cine<span>Rez</span></a>

        <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false" data-nav-toggle>
            &#9776;
        </button>

        <ul class="nav-menu" data-nav-menu>
            <li><a class="nav-link" href="index.php">Home</a></li>
            <li><a class="nav-link" href="movies.php">Movies</a></li>
            <li><a class="nav-link" href="booking.php">Booking</a></li>
            <li><a class="nav-link" href="contact.php">Contact</a></li>
            <li><a class="nav-link" href="login.php">Login</a></li>
        </ul>
    </div>
</header>

<main>
    <section class="page-hero">
        <div class="container">
            <h1>Browse Movies</h1>
            <p class="section-subtitle">Find your next watch and reserve seats instantly.</p>
        </div>
    </section>

    <section class="section" style="padding-top: 1rem;">
        <div class="container">
            <form method="get" action="movies.php" class="filter-bar">
                <input
                    class="search-input"
                    type="search"
                    name="search"
                    placeholder="Search by movie title..."
                    value="<?php echo cleanText($search); ?>"
                />

                <div class="filter-buttons">
                    <?php foreach ($genres as $genreOption): ?>
                        <button
                            class="filter-btn <?php echo $genre === $genreOption ? 'active' : ''; ?>"
                            type="submit"
                            name="genre"
                            value="<?php echo cleanText($genreOption); ?>"
                        >
                            <?php echo cleanText($genreOption); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <select name="sort" class="search-input">
                    <option value="">Sort</option>
                    <option value="title" <?php echo $sort === "title" ? "selected" : ""; ?>>Title A-Z</option>
                    <option value="rating" <?php echo $sort === "rating" ? "selected" : ""; ?>>Top Rating</option>
                    <option value="price" <?php echo $sort === "price" ? "selected" : ""; ?>>Lowest Price</option>
                </select>

                <button class="btn btn-primary" type="submit">Apply</button>
                <a class="btn btn-outline" href="movies.php">Reset</a>
            </form>

            <?php if (empty($filteredMovies)): ?>
                <p class="empty-state">No movies found. Try another search or filter.</p>
            <?php else: ?>
                <div class="card-grid">
                    <?php foreach ($filteredMovies as $movieItem): ?>
                        <?php
                        $movie = $movieItem["object"];
                        $poster = $movieItem["poster"];
                        $ageRating = $movieItem["ageRating"];
                        ?>

                        <article class="movie-card">
                            <div class="poster-placeholder">
                                <img
                                    src="images/<?php echo cleanText($poster); ?>"
                                    alt="<?php echo cleanText($movie->getTitle()); ?> poster"
                                />
                            </div>

                            <h3><?php echo cleanText($movie->getTitle()); ?></h3>

                            <p>
                                <?php echo cleanText($movie->getGenre()); ?>
                                |
                                <?php echo (int) $movie->getDuration(); ?> min
                            </p>

                            <p class="rating">
                                Rating: <?php echo cleanText($movie->getRating()); ?>
                                |
                                <?php echo cleanText($ageRating); ?>
                            </p>

                            <p class="price">
                                <?php echo formatPrice($movie->getPrice()); ?>
                            </p>

                            <p class="small-note">
                                <?php echo cleanText($movie->getShortInfo()); ?>
                            </p>

                            <div class="card-actions">
                                <a class="btn btn-sm" href="movie-details.php?id=<?php echo (int) $movie->getId(); ?>">
                                    View Details
                                </a>

                                <a class="btn btn-sm btn-outline" href="booking.php?movie_id=<?php echo (int) $movie->getId(); ?>">
                                    Book
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="glass">
                <h2>OOP Movie Class Demo</h2>
                <p>
                    This page uses the <strong>Movie</strong> class.
                    Each movie is created as a PHP object with <code>new Movie(...)</code>
                    and displayed using getter methods.
                </p>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="container footer-grid">
        <div>
            <a class="logo" href="index.php">Cine<span>Rez</span></a>
            <p class="small-note">Discover every genre in one place.</p>
        </div>

        <div>
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="booking.php">Booking</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>

        <div>
            <h4>Social</h4>
            <ul>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">YouTube</a></li>
            </ul>
        </div>
    </div>

    <div class="container footer-bottom">
        &copy; 2026 CineRez. All rights reserved.
    </div>
</footer>

<script src="js/main.js"></script>
</body>
</html>