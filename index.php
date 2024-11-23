<?php
require 'db.php';

if ($pdo) {
    echo "Подключение к базе данных успешно!";
}

session_start();
if (isset($_SESSION['user_id'])) {
    echo "Вы уже авторизованы. <a href='profile.php'>Перейти в профиль</a>";
} else {
    echo "Добро пожаловать! Пожалуйста, <a href='login.php'>авторизуйтесь</a> или <a href='register.php'>зарегистрируйтесь</a>.";
}


?>
