CREATE DATABASE IF NOT EXISTS cinerez_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cinerez_db;


SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    genre VARCHAR(100) NOT NULL,
    duration INT NOT NULL,
    release_year INT NOT NULL,
    poster VARCHAR(255) DEFAULT 'placeholder.svg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    reservation_date DATE NOT NULL,
    seats INT NOT NULL,
    status ENUM('active', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reservations_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_reservations_movie
        FOREIGN KEY (movie_id) REFERENCES movies(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@cinerez.local', '$2y$10$O9BgLQ7VENllGE6HwSAEfuqB0901uMtY7JRQ0y8lEfb0bILR1tTpG', 'admin'),
('Demo User', 'user@cinerez.local', '$2y$10$UEowV/giJosDIlaLntqYkeuWQLptdvbcVhsLA7ZqhVg1qgfciF8NS', 'user');

INSERT INTO movies (title, description, genre, duration, release_year, poster) VALUES
('The Super Mario Galaxy Movie', 'Mario, Luigi, and friends head into space to stop Bowser and Bowser Jr. from unleashing chaos across the galaxy.', 'Animation', 98, 2026, 'movie1.jpg'),
('Project Hail Mary', 'An astronaut awakens alone on a mission to save Earth and forms an unlikely interstellar alliance.', 'Sci-Fi', 156, 2026, 'movie2.jpg'),
('Lee Cronin''s The Mummy', 'A family is reunited with their long-missing daughter, only to discover the return carries a terrifying curse.', 'Horror', 134, 2026, 'movie3.jpg'),
('The Drama', 'An engaged couple''s final week before their wedding unravels after an unexpected revelation.', 'Drama', 105, 2026, 'movie4.jpg'),
('You, Me & Tuscany', 'A young chef travels to Tuscany and gets pulled into a fake engagement that turns real.', 'Romance', 105, 2026, 'movie5.jpg'),
('Hoppers', 'A college student uses mind-transfer tech to communicate with animals and protect their habitat.', 'Animation', 104, 2026, 'movie6.jpg'),
('Reminders of Him', 'A woman returning from prison seeks redemption and a second chance with her daughter.', 'Drama', 114, 2026, 'movie7.jpg'),
('A Great Awakening', 'The friendship between George Whitefield and Benjamin Franklin shapes a pivotal chapter in American history.', 'Drama', 129, 2026, 'movie8.jpg');

INSERT INTO reservations (user_id, movie_id, reservation_date, seats, status) VALUES
(2, 2, '2026-06-03', 2, 'active'),
(2, 6, '2026-06-05', 3, 'active');
