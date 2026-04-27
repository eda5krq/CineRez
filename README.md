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
Për ta ekzekutuar projektin CineRez, vendoseni folderin e projektit brenda XAMPP htdocs, p.sh. C:\xampp_new\htdocs\CineRez. Pastaj startoni Apache nga XAMPP Control Panel dhe hapeni projektin në browser me http://localhost/CineRez/. Faqet mund të testohen veçmas, p.sh. http://localhost/CineRez/movies.php, http://localhost/CineRez/login.php ose http://localhost/CineRez/admin.php.
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
