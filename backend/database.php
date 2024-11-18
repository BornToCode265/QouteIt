<?php
try {
    // Connect to MySQL
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create Database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS QuoteItSystem");
    $pdo->exec("USE QuoteItSystem");

    // Create Users Table
    $pdo->exec("
        CREATE TABLE Users (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            email VARCHAR(100),
            password_hash VARCHAR(255),
            phone_number VARCHAR(15),
            role ENUM('manager', 'owner'),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // Create Shops Table
    $pdo->exec("
        CREATE TABLE Shops (
            shop_id INT AUTO_INCREMENT PRIMARY KEY,
            owner_id INT,
            shop_name VARCHAR(100),
            location_area VARCHAR(100),
            latitude DECIMAL(9,6),
            longitude DECIMAL(9,6),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (owner_id) REFERENCES Users(user_id)
        );
    ");

    // Create Products Table
    $pdo->exec("
        CREATE TABLE Products (
            product_id INT AUTO_INCREMENT PRIMARY KEY,
            shop_id INT,
            name VARCHAR(100),
            description TEXT,
            photo_url VARCHAR(255),
            price_per_unit DECIMAL(10,2),
            quantity INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (shop_id) REFERENCES Shops(shop_id)
        );
    ");

    // Create Requests Table
    $pdo->exec("
        CREATE TABLE Requests (
            request_id INT AUTO_INCREMENT PRIMARY KEY,
            manager_id INT,
            item_name VARCHAR(100),
            quantity INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (manager_id) REFERENCES Users(user_id)
        );
    ");

    // Create Quotations Table
    $pdo->exec("
        CREATE TABLE Quotations (
            quote_id INT AUTO_INCREMENT PRIMARY KEY,
            request_id INT,
            shop_id INT,
            product_id INT,
            price_per_unit DECIMAL(10,2),
            total_price DECIMAL(10,2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (request_id) REFERENCES Requests(request_id),
            FOREIGN KEY (shop_id) REFERENCES Shops(shop_id),
            FOREIGN KEY (product_id) REFERENCES Products(product_id)
        );
    ");

    // Create Payments Table
    $pdo->exec("
        CREATE TABLE Payments (
            payment_id INT AUTO_INCREMENT PRIMARY KEY,
            quote_id INT,
            amount DECIMAL(10,2),
            payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            receipt_url VARCHAR(255),
            FOREIGN KEY (quote_id) REFERENCES Quotations(quote_id)
        );
    ");

    // Insert Fake Data
    // Add Users
    $pdo->exec("
        INSERT INTO Users (name, email, password_hash, phone_number, role) VALUES
        ('Mr. Banda', 'mbanda@example.com', 'hashedpassword1', '0999999999', 'manager'),
        ('Shop Owner 1', 'owner1@example.com', 'hashedpassword2', '0888888888', 'owner'),
        ('Shop Owner 2', 'owner2@example.com', 'hashedpassword3', '0777777777', 'owner');
    ");

    // Add Shops
    $pdo->exec("
        INSERT INTO Shops (owner_id, shop_name, location_area, latitude, longitude) VALUES
        (2, 'Building Solutions', 'Lilongwe', -13.9834, 33.7741),
        (3, 'Hardware World', 'Blantyre', -15.7861, 35.0058);
    ");

    // Add Products
    $pdo->exec("
        INSERT INTO Products (shop_id, name, description, photo_url, price_per_unit, quantity) VALUES
        (1, 'Cement Bag', '50kg cement for construction', 'images/cement.jpg', 8000, 100),
        (1, 'Iron Rods', 'High-quality iron rods for reinforcement', 'images/iron_rods.jpg', 2000, 50),
        (2, 'Bricks', 'Kiln-fired bricks for durable construction', 'images/bricks.jpg', 100, 500),
        (2, 'Roofing Sheets', 'Durable corrugated iron sheets', 'images/roofing_sheets.jpg', 3000, 200);
    ");

    // Add Requests by Mr. Banda
    $pdo->exec("
        INSERT INTO Requests (manager_id, item_name, quantity) VALUES
        (1, 'Cement Bag', 10),
        (1, 'Bricks', 100),
        (1, 'Roofing Sheets', 20);
    ");

    // Add Quotations
    $pdo->exec("
        INSERT INTO Quotations (request_id, shop_id, product_id, price_per_unit, total_price) VALUES
        (1, 1, 1, 8000, 80000),
        (2, 2, 3, 100, 10000),
        (3, 2, 4, 3000, 60000);
    ");

    // Add Payments
    $pdo->exec("
        INSERT INTO Payments (quote_id, amount, receipt_url) VALUES
        (1, 80000, 'receipts/receipt1.pdf'),
        (2, 10000, 'receipts/receipt2.pdf'),
        (3, 60000, 'receipts/receipt3.pdf');
    ");

    echo "Database, tables, and sample data created successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
