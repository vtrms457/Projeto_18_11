<?php

include 'db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Verifica o tipo de usuário e redireciona
$tipo_usuario = $_SESSION['tipo_usuario'];

if ($tipo_usuario === 'aluno') {
    header("Location: aluno_dashboard.php"); // Página do aluno
    exit;
} elseif ($tipo_usuario === 'administrador') {
    header("Location: admin_dashboard.php"); // Página do administrador
    exit;
} else {
    // Caso o tipo de usuário seja inválido ou não reconhecido
    echo "Erro: Tipo de usuário não reconhecido.";
}
?>
