<?php
// Подключаем базу данных
require 'db.php';

$errors = []; // Массив для хранения ошибок

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Проверка на пустые поля
    if (empty($name)) {
        $errors[] = "Имя обязательно для заполнения.";
    }

    if (empty($phone)) {
        $errors[] = "Телефон обязателен для заполнения.";
    }

    if (empty($email)) {
        $errors[] = "Email обязателен для заполнения.";
    }

    if (empty($password)) {
        $errors[] = "Пароль обязателен для заполнения.";
    }

    if (empty($confirm_password)) {
        $errors[] = "Подтверждение пароля обязательно.";
    }

    // Проверка совпадения паролей
    if ($password !== $confirm_password) {
        $errors[] = "Пароли не совпадают.";
    }

    // Проверка уникальности email и телефона
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR phone = :phone");
    $stmt->execute(['email' => $email, 'phone' => $phone]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Пользователь с таким email или телефоном уже существует.";
    }

    // Валидация email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный формат email.";
    }

    // Валидация телефона (пример: проверка формата +7xxxxxxxxxx)
    if (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        $errors[] = "Некорректный формат телефона.";
    }

    // Валидация пароля
    if (strlen($password) < 8) {
        $errors[] = "Пароль должен быть минимум 8 символов.";
    }

    // Если есть ошибки, выводим их
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        // Хэширование пароля
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Сохранение данных в базу
        $stmt = $pdo->prepare("INSERT INTO users (name, phone, email, password) VALUES (:name, :phone, :email, :password)");
        try {
            $stmt->execute([
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'password' => $hashed_password
            ]);
            echo "<p style='color: green;'>Регистрация прошла успешно!</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>Ошибка при регистрации: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}
?>
