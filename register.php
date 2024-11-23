<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<?php
require 'register-data-processing.php';
?>
<body>
    <h1>Регистрация</h1>
    <form method="POST" action="register.php">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" required>
        <br>

        <label for="phone">Телефон:</label>
        <input type="text" id="phone" name="phone" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <label for="confirm_password">Повтор пароля:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br>

        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>
