<?php
session_start();
ini_set('display_errors', 0);
// класс для работы с пользователем
require_once 'classes/User.php';
User::logout();
header("Location: /index.php");