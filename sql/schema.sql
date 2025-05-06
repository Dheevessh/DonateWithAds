-- Database Schema for DonateWhileWatching

-- Charities Table
CREATE TABLE charities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    last_voted TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ads_watched INT DEFAULT 0
);

-- Votes Table
CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    charity_id INT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ad_watched BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (charity_id) REFERENCES charities(id)
);

-- Ad Tracking Table
CREATE TABLE ad_watches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Admin Users Table
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, password_hash) 
VALUES ('admin', '$2y$10$8tG7l/vY3s7FZC5qJm3s7.j8HkGk.8GJf0W7ZPKzS.eSZG5oCRYpi');

-- Insert some sample charities
INSERT INTO charities (name, description, image_url) VALUES
('Save the Ocean', 'Working to protect marine ecosystems worldwide', 'images/charity1.jpg'),
('Education for All', 'Providing educational resources to underprivileged communities', 'images/charity2.jpg'),
('Food Bank Network', 'Fighting hunger in local communities', 'images/charity3.jpg'),
('Animal Rescue Society', 'Rescuing and rehabilitating abandoned animals', 'images/charity4.jpg'),
('Climate Action Now', 'Working towards a sustainable future and combating climate change', 'images/charity5.jpg'); 