-- Create the database
CREATE DATABASE IF NOT EXISTS fixer_upper_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE fixer_upper_shop;

-- Table: users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: products
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg'
);

-- Table: orders
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table: order_items
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, description, price, image) VALUES
('Smart Washing Machine', 'Energy-efficient front-load washing machine with Wi-Fi connectivity.', 549.99, 'smart_washing_machine.png'),
('Turbo Dryer 5000', 'High-capacity tumble dryer with advanced moisture sensors.', 429.00, 'turbo_dryer_5000.jpg'),
('Mini Fridge', 'Compact mini fridge perfect for dorm rooms and offices.', 199.50, 'mini_fridge.jpg'),
('Stainless Steel Microwave', '1000W microwave oven with multiple presets and stainless finish.', 149.95, 'stainless_steel_microwave.png'),
('Deluxe Dishwasher', 'Silent and powerful dishwasher with adjustable racks.', 599.99, 'deluxe_dishwasher.jpg'),
('Gas Cooker Pro', 'Five-burner gas cooker with built-in ignition system.', 699.00, 'gas_cooker_pro.png'),
('Electric Kettle Max', 'Fast-boiling electric kettle with auto shut-off.', 49.99, 'electric_kettle_max.jpg'),
('Air Purifier Plus', 'HEPA filter air purifier for large rooms.', 299.00, 'air_purifier_plus.png'),
('Ceiling Fan Breeze', 'Modern ceiling fan with remote control and LED light.', 179.99, 'ceiling_fan_breeze.png'),
('Portable Heater Compact', 'Safe and efficient portable room heater.', 89.95, 'portable_heater_compact.png');
