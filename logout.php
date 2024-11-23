<?php
session_start();
session_destroy(); // Удаление всех данных сессии
header('Location: index.php'); // Перенаправление на главную
exit;
?>
