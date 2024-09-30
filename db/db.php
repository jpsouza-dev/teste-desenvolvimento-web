<?php
$host = 'localhost';
$db = 'social_network'; // Nome do seu banco de dados
$user = 'root'; // Usuário padrão do XAMPP
$pass = ''; // Senha padrão do XAMPP, deixe vazio se não houver

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>
