<?php
session_start();
require '../db/db.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lógica para excluir postagens
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_post_id'])) {
    $post_id = $_POST['delete_post_id'];
    
    // Exclui a postagem se ela pertencer ao usuário logado
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $stmt->execute([$post_id, $_SESSION['user_id']]);
}

// Redirecionar de volta para a página anterior
header("Location: dashboard.php");
exit();
