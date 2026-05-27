<main class="container">
    <section class="glass page-head">
        <h1>TVMaze Search</h1>
        <p>Search external show data without changing the local CineRez database.</p>
        <div class="admin-actions">
            <a class="btn btn-outline" href="index.php">Dashboard</a>
            <a class="btn btn-outline" href="movies.php">Local Movies</a>
        </div>
    </section>

    <section class="glass panel-card">
        <form id="tvmazeSearchForm" class="filter-bar">
            <input id="tvmazeSearchInput" type="search" placeholder="Search TVMaze shows..." required>
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
        <div id="tvmazeSearchStatus" class="small-muted api-status"></div>
        <div id="tvmazeResults" class="api-results"></div>
    </section>
</main>
