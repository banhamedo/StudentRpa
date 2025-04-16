USE form_db;

CREATE TABLE responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    Logic DECIMAL(5,2) DEFAULT NULL,
    machine_learning DECIMAL(5,2) DEFAULT NULL,  -- Stores degree for Machine Learning
    smart_robot DECIMAL(5,2) DEFAULT NULL,      -- Stores degree for Smart Robot
    hacking DECIMAL(5,2) DEFAULT NULL,          -- Stores degree for Hacking
    monitoring_control DECIMAL(5,2) DEFAULT NULL,  -- Stores degree for Monitoring and Control
    leadership DECIMAL(5,2) DEFAULT NULL,       -- Stores degree for Leadership
    statistics DECIMAL(5,2) DEFAULT NULL        -- Stores degree for Statistics
);
USE form_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);