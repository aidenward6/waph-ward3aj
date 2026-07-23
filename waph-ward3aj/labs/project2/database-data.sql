-- resetting usrers table
USE waph;

drop table if exists users;

CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

-- test logins, plaintext passwords are down here if u forget them
-- admin -> Password123!  aiden -> Aiden123!
INSERT INTO users (username, password, name, email) VALUES
('admin', '$2y$12$gwWSJkDiupFq8wl6cPHS8uJeJUKv7D2iCC0drfchr6TTt1hTXjlQ.', 'Admin User', 'admin@example.com'),
('aiden', '$2y$12$HiDK3kYbhWwlsu0FGJ7nm.92m9QxCGHMgIofw8BKD2WTDH59t9WUG', 'Aiden Ward', 'ward3aj@mail.uc.edu');
