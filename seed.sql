-- CREATE DATABASE PawsitiveID;

USE PawsitiveID;

CREATE TABLE FoundPet (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    animal_type ENUM('CAT', 'DOG', 'RABBIT', 'OTHER'),
    description VARCHAR(6500),
    last_seen_date DATE,
    last_seen_long DECIMAL(9,6) ,
    last_seen_lat DECIMAL(9,6) ,
    found_by_name VARCHAR(255),
    found_by_phone VARCHAR(255),
    found_by_email VARCHAR(255)
);

CREATE TABLE LostPet (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    animal_type ENUM('CAT', 'DOG', 'RABBIT', 'OTHER'),
    description VARCHAR(6500),
    last_seen_date DATE,
    last_seen_long DECIMAL(9,6) ,
    last_seen_lat DECIMAL(9,6) ,
    owner_name VARCHAR(255),
    owner_phone VARCHAR(255),
    owner_email VARCHAR(255)
);