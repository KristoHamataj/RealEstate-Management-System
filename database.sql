
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin','agent') DEFAULT 'agent',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id INT,
    title VARCHAR(255),
    description TEXT,
    price DECIMAL(12,2),
    location VARCHAR(255),
    image VARCHAR(255),
    status ENUM('available','sold','rented') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES users(id)
    );

INSERT INTO users(name,email,password,role)
VALUES(
'Admin',
'admin@phoenixrealestate.com',
'$2y$10$v.TkvBrziG/1ewYpaOQ.Iez0hKDF0nH5U233TrYt/GfzST8krTcBa',
'admin'
);