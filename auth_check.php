<?php
session_start(); // Старт сессии

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Перенаправление на главную страницу
    exit; // Завершение выполнения скрипта
}
?>
