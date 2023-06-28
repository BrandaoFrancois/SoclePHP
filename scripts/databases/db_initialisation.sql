--
--
-- Script of initialisation of the database
-- Version: 1.0
--
--

-- Example of database creation
CREATE DATABASE IF NOT EXISTS MY_DATABASE;

-- Example of user database creation
-- CREATE USER 'new_user'@'localhost' IDENTIFIED BY 'password';
-- GRANT ALL PRIVILEGES ON * . * TO 'new_user'@'localhost';
-- FLUSH PRIVILEGES;

-- Creation of the tables
CREATE TABLE USER {
       user_id INT PRIMARY KEY NOT NULL,
       user_email VARCHAR(255) NOT NULL,
       user_password VARCHAR(255) NOT NULL,
       user_type INT NOT NULL,
       user_recover VARCHAR(16),
       UNIQUE(user_recover)
}

-- Example of data insertion
-- INSERT INTO USER(user_email, user_password, user_type) VALUES ('example@gmail.com', '', 0);

-- Example of data updating
-- UPDATE USER SET user_password = '' WHERE user_id = ;

-- Example of data recovering
-- SELECT user_id, user_email, user_type FROM USER WHERE user_email = '' AND user_password = '';
