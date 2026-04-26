<?php
// 1. MUST start the session at the very top before any HTML!
session_start();

require_once __DIR__ . '/Classes/Movie.php';
require_once __DIR__ . '/includes/functions.php';

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

$genres = ["All", "Animation", "Drama", "Horror", "Romance", "Sci-Fi"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movies | CineRez</title>
    <link rel="stylesheet" href="css/style.css" />
    <noscript><style>body{opacity:1!important;transform:none!important;}</style></noscript>
    <script defer src="js/main.js"></script>
</head>
<body>
<div class="background-overlay"></div>

<header class="site-header glass">
    <div class="container nav-wrap">
        <a class="logo" href="index.php"><img src="images/cinerez-logo.svg" alt="CineRez logo"><span>CineRez</span></a>
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">Menu</button>
        <?php include 'nav.php'; ?>
    </div>
</header>

<main>
    <section class="page-hero">
        <div class="container">
            <h1 style="color: white; margin-bottom: 10px;">Browse Movies</h1>
            <p class="section-subtitle" style="color: #ccc;">Find your next watch and reserve seats instantly.</p>
        </div>
    </section>

    <section class="section" style="padding-top: 1rem;">
        <div class="container">
            <form method="get" action="movies.php" class="filter-bar glass" style="padding: 15px; margin-bottom: 30px; display: flex; gap: 10px; flex-wrap: wrap;">
                <input
                    class="search-input"
                    type="search"
                    name="search"
                    placeholder="Search by movie title..."
                    value="<?php echo htmlspecialchars($search); ?>"
                    style="flex-grow: 1; padding: 10px;"
                />

                <div class="filter-buttons" style="display: flex; gap: 5px;">
                    <?php foreach ($genres as $genreOption): ?>
                        <button
                            class="filter-btn btn <?php echo $genre === $genreOption ? 'btn-primary' : 'btn-outline'; ?>"
                            type="submit"
                            name="genre"
                            value="<?php echo htmlspecialchars($genreOption); ?>"
                        >
                            <?php echo htmlspecialchars($genreOption); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <select name="sort" class="search-input" style="padding: 10px;">
                    <option value="">Sort By</option>
                    <option value="title" <?php echo $sort === "title" ? "selected" : ""; ?>>Title A-Z</option>
                    <option value="rating" <?php echo $sort === "rating" ? "selected" : ""; ?>>Top Rating</option>
                    <option value="price" <?php echo $sort === "price" ? "selected" : ""; ?>>Lowest Price</option>
                </select>

                <button class="btn btn-primary" type="submit">Apply</button>
                <a class="btn btn-outline" href="movies.php">Reset</a>
            </form>

            <?php if (empty($filteredMovies)): ?>
                <div class="glass" style="padding: 30px; text-align: center; color: white;">
                    <p class="empty-state">No movies found. Try another search or filter.</p>
                </div>
            <?php else: ?>
                <div class="card-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
                    <?php foreach ($filteredMovies as $movieItem): ?>
                        <?php
                        $movie = $movieItem["object"];
                        $poster = $movieItem["poster"];
                        $ageRating = $movieItem["ageRating"];
                        ?>

                        <article class="movie-card glass" style="padding: 15px; display: flex; flex-direction: column;">
                            <div class="poster-placeholder" style="margin-bottom: 15px; text-align: center;">
                                <img
                                    src="images/<?php echo htmlspecialchars($poster); ?>"
                                    alt="<?php echo htmlspecialchars($movie->getTitle()); ?> poster"
                                    style="max-width: 100%; border-radius: 8px;"
                                    onerror="this.src='images/placeholder.png';"
                                />
                            </div>

                            <h3 style="color: white; margin-bottom: 10px; font-size: 1.2rem;"><?php echo htmlspecialchars($movie->getTitle()); ?></h3>

                            <p style="color: #ccc; font-size: 0.9rem; margin-bottom: 5px;">
                                <?php echo htmlspecialchars($movie->getGenre()); ?> | <?php echo (int) $movie->getDuration(); ?> min
                            </p>

                            <p class="rating" style="color: #ffc107; font-size: 0.9rem; margin-bottom: 5px;">
                                ★ <?php echo htmlspecialchars($movie->getRating()); ?> | <?php echo htmlspecialchars($ageRating); ?>
                            </p>

                            <p class="price" style="color: white; font-weight: bold; margin-bottom: 15px;">
                                <?php echo formatPrice($movie->getPrice()); ?>
                            </p>

                            <div class="card-actions" style="margin-top: auto; display: flex; gap: 10px;">
                                <a class="btn btn-sm btn-outline" href="movie-details.php?id=<?php echo (int) $movie->getId(); ?>" style="flex: 1; text-align: center;">
                                    Details
                                </a>
                                <a class="btn btn-sm btn-primary" href="booking.php?movie_id=<?php echo (int) $movie->getId(); ?>" style="flex: 1; text-align: center;">
                                    Book
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container footer-inner">
        <p>&copy; 2026 CineRez. All rights reserved.</p>
        <p>Frontend-only static demo version.</p>
    </div>
</footer>
</body>
</html>