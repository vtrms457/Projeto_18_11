<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $data_cadastro = date('Y-m-d H:i:s');

    // Verificar se o e-mail é de aluno ou administrador
    if (preg_match('/@aluno\.com$/', $email)) {
        $tipo = 'aluno';
    } elseif (preg_match('/@admin\.com$/', $email)) {
        $tipo = 'administrador';
    } else {
        header("Location: registro.php?error=Email inválido para cadastro.");
        exit;
    }

    // Verifica se o email já está cadastrado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: registro.php?error=Este email já está cadastrado.");
        exit;
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo, data_cadastro) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nome, $email, $senha, $tipo, $data_cadastro);

        if ($stmt->execute()) {
            header("Location: login.php?success=Conta criada com sucesso.");
            exit;
        } else {
            header("Location: registro.php?error=Erro ao criar conta.");
            exit;
        }
    }
    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Sistema de Estacionamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="inicio.php">Início</a></li>
                <li><a href="login.php">Login</a></li> <!-- Certifique-se que esta página é login.php -->
            </ul>
        </nav>
    </header>

    <main>
        <section class="registro">
            <h2>Criar Conta</h2>
            <form action="" method="POST">
                <input type="text" name="nome" placeholder="Nome Completo" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Registrar</button>
            </form>
            <p class="error-message" style="color: red;">
                <?php 
                    if (isset($_GET['error'])) {
                        echo htmlspecialchars($_GET['error']);
                    }
                ?>
            </p>
            <p class="success-message" style="color: green;">
                <?php 
                    if (isset($_GET['success'])) {
                        echo htmlspecialchars($_GET['success']);
                    }
                ?>
            </p>
        </section>
    </main>

    <footer>
        <p>© 2024 Sistema de Estacionamento. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
