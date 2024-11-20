<?php
include 'db.php';

$mensagem = "";

// Verificação de sessão do usuário
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>
            alert('Para acessar o perfil, faça login.');
            window.location.href = 'login.php';
            </script>";
    exit;
}

// Obter dados do usuário
$usuario_id = $_SESSION['usuario_id'];

// Buscar informações do usuário
$sql = "SELECT nome, email, telefone, foto_perfil FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($nome, $email, $telefone, $foto_perfil);
$stmt->fetch();
$stmt->close();

// Atualizar perfil (telefone e foto de perfil)
if (isset($_POST['telefone']) || isset($_FILES['foto_perfil'])) {
    $telefone = $_POST['telefone'];
    $foto_perfil = null;

    if (!empty($_FILES['foto_perfil']['tmp_name'])) {
        $foto_perfil = 'donwloads/' . basename($_FILES['foto_perfil']['name']);
        move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);
    }

    $sql = "UPDATE usuarios SET telefone = ?, foto_perfil = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $telefone, $foto_perfil, $usuario_id);

    if ($stmt->execute()) {
        $msg_perfil = "Perfil atualizado com sucesso!";
    } else {
        $msg_perfil = "Erro ao atualizar perfil: " . $stmt->error;
    }

    $stmt->close();
}

// Registrar veículo
if (isset($_POST['placa']) && isset($_POST['marca']) && isset($_POST['cor']) && isset($_POST['tipo'])) {
    $placa = $_POST['placa'];
    $marca = $_POST['marca'];
    $cor = $_POST['cor'];
    $tipo = $_POST['tipo'];

    $sql = "INSERT INTO veiculos (usuario_id, placa, marca, cor, tipo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $usuario_id, $placa, $marca, $cor, $tipo);

    if ($stmt->execute()) {
        $msg_veiculo = "Veículo registrado com sucesso!";
    } else {
        $msg_veiculo = "Erro ao registrar veículo: " . $stmt->error;
    }

    $stmt->close();
}

// Obter os veículos registrados pelo usuário
$sql_veiculos = "SELECT id, placa, marca, cor, tipo FROM veiculos WHERE usuario_id = ?";
$stmt_veiculos = $conn->prepare($sql_veiculos);
$stmt_veiculos->bind_param("i", $usuario_id);
$stmt_veiculos->execute();
$result_veiculos = $stmt_veiculos->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Sistema de Estacionamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="inicio.php">Início</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="perfil">
            <h2>Perfil do Usuário</h2>
            <div id="dados-usuario">
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Telefone:</strong> <?php echo htmlspecialchars($telefone); ?></p>
                <?php if ($foto_perfil): ?>
                    <img src="<?php echo htmlspecialchars($foto_perfil); ?>" alt="Foto de Perfil">
                <?php endif; ?>
            </div>

            <!-- Exibir mensagens de sucesso/erro -->
            <?php if (isset($msg_perfil)) echo "<p>$msg_perfil</p>"; ?>
            <?php if (isset($msg_veiculo)) echo "<p>$msg_veiculo</p>"; ?>

            <!-- Formulário para editar perfil -->
            <h3>Editar Perfil</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>">

                <label for="foto_perfil">Foto de Perfil:</label>
                <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">

                <button type="submit">Salvar Alterações</button>
            </form>

            <!-- Formulário de registro de veículo -->
            <section class="registrar-veiculo">
                <h3>Registrar Veículo</h3>
                <form action="" method="POST">
                    <input type="text" name="placa" placeholder="Placa" required>
                    <input type="text" name="marca" placeholder="Marca" required>
                    <input type="text" name="cor" placeholder="Cor" required>
                    <select name="tipo" required>
                        <option value="carro">Carro</option>
                        <option value="moto">Moto</option>
                    </select>
                    <button type="submit">Registrar Veículo</button>
                </form>
            </section>

            <!-- Exibir veículos cadastrados -->
            <h3>Meus Veículos</h3>
            <table>
                <tr>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Cor</th>
                    <th>Tipo</th>
                </tr>
                <?php while ($veiculo = $result_veiculos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $veiculo['placa']; ?></td>
                        <td><?php echo $veiculo['marca']; ?></td>
                        <td><?php echo $veiculo['cor']; ?></td>
                        <td><?php echo $veiculo['tipo']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </section>
    </main>

    <footer>
        <p>© 2024 Sistema de Estacionamento. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
