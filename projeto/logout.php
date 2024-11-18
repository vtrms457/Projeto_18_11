<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (isset($_SESSION['usuario_id'])) {
    // O usuário está logado, então podemos proceder com o logout
    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destrói a sessão
    echo "<script>
            alert('Sessão encerrada.');
            window.location.href = 'index.php';
            </script>";
} else {
    // O usuário não está logado
    echo "<script>
            alert('Sessão não iniciada.');
            window.location.href = 'index.php';
            </script>";
}
exit;
?>
