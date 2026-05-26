# CineRez

CineRez is a PHP/MySQL cinema reservation app for local XAMPP, Laragon, or WAMP development.

## Local URL

```text
http://localhost/CineRez_repo/CineRez/
```

The repository root is the project root. Do not place the app inside a nested `cinerez` folder.

## Database

Database name:

```text
cinerez_db
```

Import the schema from:

```text
database/schema.sql
```

The schema creates:

- `users`
- `movies`
- `reservations`
- `contact_messages`

It also inserts demo movies plus these accounts:

```text
Admin: admin@cinerez.local / Admin123
User:  user@cinerez.local / User123
```

The current local test database uses `admin@cinerez.local / Admin123`.

Re-importing `database/schema.sql` will drop and recreate the CineRez app tables
(`users`, `movies`, `reservations`, `contact_messages`). That resets demo
accounts, movies, reservations, and contact messages.

## Setup With XAMPP

1. Put this repo at `C:\xampp\htdocs\CineRez_repo\CineRez`.
2. Start Apache and MySQL from XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin/`.
4. Choose the Import tab.
5. Select `C:\xampp\htdocs\CineRez_repo\CineRez\database\schema.sql`.
6. Click Go.
7. Visit `http://localhost/CineRez_repo/CineRez/`.

## Main Features

- PDO database connection with prepared statements.
- Session authentication with user and admin roles.
- Admin movie CRUD with poster upload to `uploads/`.
- Public movie list and movie details from MySQL.
- User reservation create, read, update, and AJAX cancel.
- Contact messages saved to MySQL.
- Contact email fallback log at `logs/contact_emails.log` when local mail is not configured.
- Admin TVMaze API search without saving external results locally.
