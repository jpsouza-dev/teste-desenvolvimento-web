<?php
require '../db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Verifique se o email existe
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Aqui você enviaria um email com o link de recuperação (simplificado)
        echo "Um link de recuperação foi enviado para o seu email.";
    } else {
        echo "Email não encontrado.";
    }
}
?>
