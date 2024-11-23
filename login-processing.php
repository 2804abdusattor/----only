<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier']);
    $password = $_POST['password'];
    $recaptchaToken = $_POST['recaptcha_token'];

    $recaptchaSecretKey = '6LckA4gqAAAAAIM8Im008X1Vi3gpS0gHqRlHN1s1';

    // Отправление токен для проверки в Google API
    $recaptchaResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecretKey&response=$recaptchaToken");
    $recaptchaResult = json_decode($recaptchaResponse, true);

    // Проверка результата
    if (!$recaptchaResult['success'] || $recaptchaResult['score'] < 0.5) {
        var_dump($recaptchaResult); // Для отладки
        die("Ошибка reCAPTCHA. Попробуйте снова.");
    }

    // Ищем пользователя в базе данных
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :identifier OR phone = :identifier");
    $stmt->execute(['identifier' => $identifier]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Проверяем пароль
    if ($user && password_verify($password, $user['password'])) {
        // Генерируем новый уникальный идентификатор сессии
        session_regenerate_id(true);

        // Сохраняем новый идентификатор сессии в базе данных
        $session_id = session_id();
        $updateStmt = $pdo->prepare("UPDATE users SET session_id = :session_id WHERE id = :user_id");
        $updateStmt->execute(['session_id' => $session_id, 'user_id' => $user['id']]);

        // Сохраняем идентификатор пользователя в сессии
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['session_id'] = $session_id; // Сохраняем идентификатор сессии

        header("Location: profile.php");
        exit;
    } else {
        echo "Неверные email/телефон или пароль.";
    }
}
?>
