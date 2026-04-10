CREATE DATABASE IF NOT EXISTS campus_trade_hub DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE campus_trade_hub;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255) DEFAULT 'assets/uploads/default.png',
    status ENUM('available', 'sold') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Insert dữ liệu mẫu
INSERT INTO users (username, email, password) VALUES 
('nguyenvana', 'nva@student.edu.vn', 'hash_pass_1'),
('lethib', 'ltb@student.edu.vn', 'hash_pass_2');

INSERT INTO categories (category_name) VALUES 
('Đại cương'), ('Chuyên ngành IT'), ('Ngoại ngữ');

INSERT INTO posts (user_id, category_id, title, description, price, image_url, status) VALUES 
(1, 2, 'Giáo trình C++ và Lập trình Hướng đối tượng', 'Sách còn mới 90%, không ghi chú, giá rẻ cho ae khóa dưới.', 85000, 'assets/uploads/cpp.jpg', 'available'),
(2, 1, 'Triết học Mác - Lênin (Bản chuẩn)', 'Sách có highlight nhẹ vài chương đầu, đọc kỹ bao qua môn.', 40000, 'assets/uploads/triethoc.jpg', 'available'),
(1, 3, 'Combo IELTS Cambridge 15-18', 'Sạch sẽ, tặng kèm file nghe PDF và flashcard từ vựng.', 350000, 'assets/uploads/ielts.jpg', 'sold');
