-- CREATE DATABASE PawsitiveID;

USE PawsitiveID;

CREATE TABLE FoundPet (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    animal_type ENUM('CAT', 'DOG', 'RABBIT', 'BIRD', 'OTHER'),
    description VARCHAR(6500),
    last_seen_date DATE,
    last_seen_long DECIMAL(9,6) ,
    last_seen_lat DECIMAL(9,6) ,
    found_by_name VARCHAR(255),
    found_by_phone VARCHAR(255),
    found_by_email VARCHAR(255),
    created_at TIMESTAMP DEFAULT now(),
    photo MEDIUMBLOB
);

CREATE TABLE LostPet (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    animal_type ENUM('CAT', 'DOG', 'RABBIT', 'BIRD', 'OTHER'),
    description VARCHAR(6500),
    last_seen_date DATE,
    last_seen_long DECIMAL(9,6) ,
    last_seen_lat DECIMAL(9,6) ,
    owner_name VARCHAR(255),
    owner_phone VARCHAR(255),
    owner_email VARCHAR(255),
    created_at TIMESTAMP DEFAULT now(),
    photo MEDIUMBLOB
);

CREATE TABLE Chat (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    message VARCHAR(65000),
    type ENUM('FOUND', 'LOST'),
    post_id INT,
    created_at TIMESTAMP DEFAULT now()
)
