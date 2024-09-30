<?php
session_start();
require '../db/db.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lógica para criar postagens
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content'])) {
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
    $stmt->execute([$user_id, $content]);
}

// Lógica para buscar postagens
$stmt = $pdo->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
$stmt->execute();
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <a href="logout.php" class="btn btn-danger">Sair</a>
    </div>

    <form action="" method="POST" class="mt-3">
        <div class="form-group">
            <textarea class="form-control" name="content" rows="3" required placeholder="O que você está pensando?"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Postar</button>
    </form>

    <h3 class="mt-4">Postagens Recentes</h3>
    <div class="list-group">
        <?php foreach ($posts as $post): ?>
            <div class="list-group-item">
                <h5><?php echo htmlspecialchars($post['username']); ?></h5>
                <p><?php echo htmlspecialchars($post['content']); ?></p>
                <small class="text-muted"><?php echo $post['created_at']; ?></small>
                
                <!-- Botões de ação -->
                <div class="mt-2">
                    <form action="edit_post.php" method="POST" class="d-inline">
                        <input type="hidden" name="edit_post_id" value="<?php echo $post['id']; ?>">
                        <input type="text" name="edit_content" placeholder="Editar conteúdo" required>
                        <button type="submit" class="btn btn-warning btn-sm">Editar</button>
                    </form>
                    <form action="delete_post.php" method="POST" class="d-inline">
                        <input type="hidden" name="delete_post_id" value="<?php echo $post['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="text-center mt-4">
    <p>© <?php echo date("Y"); ?> Minha Rede Social</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
