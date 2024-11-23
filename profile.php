<?php
require 'db.php';
require 'auth_check.php'; // Проверка авторизации

// Загрузка данных пользователя
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, phone, email FROM users WHERE id = :id");
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Ошибка: пользователь не найден.";
    exit;
}

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Проверка уникальности email и телефона
    $stmt = $pdo->prepare("SELECT id FROM users WHERE (email = :email OR phone = :phone) AND id != :id");
    $stmt->execute(['email' => $email, 'phone' => $phone, 'id' => $userId]);
    if ($stmt->fetch()) {
        echo "Ошибка: телефон или email уже используются.";
        exit;
    }

    // Если введен новый пароль, хэшируем его
    $passwordHash = null;
    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    }

    // Обновление данных пользователя
    $updateQuery = "UPDATE users SET name = :name, phone = :phone, email = :email";
    if ($passwordHash) {
        $updateQuery .= ", password = :password";
    }
    $updateQuery .= " WHERE id = :id";

    $stmt = $pdo->prepare($updateQuery);
    $params = ['name' => $name, 'phone' => $phone, 'email' => $email, 'id' => $userId];
    if ($passwordHash) {
        $params['password'] = $passwordHash;
    }

    if ($stmt->execute($params)) {
        echo "Данные успешно обновлены.";
    } else {
        echo "Ошибка при обновлении данных.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
</head>
<body>
    <h1>Редактирование профиля</h1>
    <form method="POST" action="profile.php">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        <br>

        <label for="phone">Телефон:</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <br>

        <label for="password">Новый пароль (необязательно):</label>
        <input type="password" id="password" name="password">
        <br>

        <button type="submit">Сохранить изменения</button>
    </form>
    <a href="logout.php">Выйти</a>
</body>
</html>
