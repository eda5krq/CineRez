# CineRez

CineRez is a web application for movie and ticket reservations.  
In Phase 1, the project focuses on PHP basics, OOP, RegEx, Sessions and Cookies.  
No database is used in this phase; all data is static/dummy.

---

## Phase 1 Requirements

- Static login/logout system
- User state handled with PHP sessions
- Two roles: `admin` and `user`
- OOP with domain classes
- RegEx server-side validation
- Cookies for personalization
- Dummy movie data using PHP arrays
- Movie sorting
- Reusable includes for header, footer and navigation

---
Për ta ekzekutuar projektin CineRez, vendoseni folderin e projektit brenda XAMPP htdocs, p.sh. C:\xampp_new\htdocs\CineRez. Pastaj startoni Apache nga XAMPP Control Panel dhe hapeni projektin në browser me http://localhost/CineRez/. Faqet mund të testohen veçmas, p.sh. http://localhost/CineRez_repo/CineRez/movies.php, http://localhost/CineRez_repo/CineRez/login.php ose http://localhost/CineRez_repo/CineRez/admin.php.
## Project Structure


```text
CineRez/
├── index.php
├── movies.php
├── booking.php
├── login.php
├── logout.php
├── dashboard.php
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── nav.php
│   ├── auth.php
│   ├── users.php
│   ├── data.php
│   └── validation.php
│
├── classes/
│   ├── Movie.php
│   ├── User.php
│   ├── Admin.php
│   └── Booking.php
│
└── assets/
    ├── css/
    ├── js/
    └── images/
```

# CineRez - Faza 2

CineRez është një aplikacion web për rezervimin e biletave të kinemasë. Projekti është zhvilluar me PHP, MySQL, HTML, CSS dhe JavaScript. Në Fazën 2, projekti është zgjeruar me databazë MySQL, operacione reale CRUD, siguri bazike, manipulim të file-ve, error handling dhe komunikim asinkron me AJAX.

## Qëllimi i Fazës 2

Qëllimi i Fazës 2 është zgjerimi i projektit me:

- databazë MySQL
- CRUD real për entitetet kryesore
- prepared statements për siguri ndaj SQL Injection
- sanitizim të output-it për mbrojtje ndaj XSS
- validim server-side të inputeve
- manipulim të file-ve
- error handling me try/catch
- komunikim asinkron me AJAX
- përdorim të Web API brenda projektit

## Teknologjitë e përdorura

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- AJAX
- OOP në PHP
- XAMPP / Apache
- phpMyAdmin

## Struktura e projekti
```text
CineRez/
│
├── admin/
│   ├── api-search.php
│   ├── create-movie.php
│   ├── delete-movie.php
│   ├── edit-movie.php
│   ├── index.php
│   └── movies.php
│
├── ajax/
│   └── delete-reservation.php
│
├── Classes/
│   ├── admin.php
│   ├── booking.php
│   ├── movie.php
│   ├── Ticket.php
│   └── user.php
│
├── config/
│   └── database.php
│
├── database/
│   └── schema.sql
│
├── includes/
│   ├── auth.php
│   ├── data.php
│   ├── footer.php
│   ├── functions.php
│   ├── header.php
│   ├── nav.php
│   ├── users.php
│   └── validation.php
│
├── views/
│   ├── admin/
│   ├── auth/
│   ├── contact/
│   ├── movies/
│   └── reservations/
│
├── css/
│   └── style.css
│
├── js/
│   └── main.js
│
├── images/
├── uploads/
├── logs/
│
├── index.php
├── movies.php
├── movie-details.php
├── booking.php
├── checkout.php
├── profile.php
├── login.php
├── register.php
├── logout.php
├── contact.php
├── admin.php
└── README.md
