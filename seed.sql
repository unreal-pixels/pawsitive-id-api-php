-- CREATE DATABASE PawsitiveID;

USE PawsitiveID;

CREATE TABLE Pet (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    post_type ENUM('FOUND', 'LOST'),
    animal_type ENUM('CAT', 'DOG', 'RABBIT', 'BIRD', 'OTHER'),
    description VARCHAR(6500),
    last_seen_date DATE,
    last_seen_long DECIMAL(9,6) ,
    last_seen_lat DECIMAL(9,6) ,
    post_by_name VARCHAR(255),
    post_by_phone VARCHAR(255),
    post_by_email VARCHAR(255),
    created_at TIMESTAMP DEFAULT now(),
    reunited BOOLEAN DEFAULT false,
    image_data LONGBLOB NOT NULL,
    reunited_description VARCHAR(6500),
    reunited_date DATE,
    reunited_image_data LONGBLOB
);

CREATE TABLE Chat (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    message VARCHAR(65000),
    post_id INT,
    created_at TIMESTAMP DEFAULT now()
)
