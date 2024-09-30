<?php
session_start();
require '../db/db.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lógica para editar postagens
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_post_id']) && isset($_POST['edit_content'])) {
    $post_id = $_POST['edit_post_id'];
    $edit_content = $_POST['edit_content'];
    
    // Atualiza a postagem se ela pertencer ao usuário logado
    $stmt = $pdo->prepare("UPDATE posts SET content = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$edit_content, $post_id, $_SESSION['user_id']]);
}

// Redirecionar de volta para a página anterior
header("Location: dashboard.php");
exit();
