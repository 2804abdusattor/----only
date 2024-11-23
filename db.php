<?php
// Параметры подключения
$host = 'localhost'; // Хост базы данных
$dbname = 'db-webpage-only'; // Имя базы данных
$username = 'root'; // Имя пользователя
$password = ''; // Пароль пользователя

try {
    // Создание подключения
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Устанавливаем режим обработки ошибок
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Обработка ошибки подключения
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>
<!-- CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 -->