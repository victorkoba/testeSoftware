<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($nome) || empty($email) || empty($senha)) {
        echo "<script src='assets/js/sweetalert2.all.min.js'></script>";
        echo "<script>Swal.fire('Campos vazios', 'Por favor, preencha todos os campos.', 'warning');</script>";
    } else {
        // Verifica se já existe o e-mail
        $check = $conn->prepare("SELECT * FROM usuarios WHERE email_usuario = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $resultado = $check->get_result();

        if ($resultado->num_rows > 0) {
            echo "<script src='assets/js/sweetalert2.all.min.js'></script>";
            echo "<script>Swal.fire('Erro', 'E-mail já cadastrado.', 'error');</script>";
        } else {
            // Criptografa a senha
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            // Insere novo usuário
            $stmt = $conn->prepare("INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $email, $senha_hash);

            if ($stmt->execute()) {
                echo "<script src='assets/js/sweetalert2.all.min.js'></script>";
                echo "<script>Swal.fire('Sucesso!', 'Cadastro realizado com sucesso.', 'success');</script>";
            } else {
                echo "<script src='assets/js/sweetalert2.all.min.js'></script>";
                echo "<script>Swal.fire('Erro', 'Não foi possível cadastrar.', 'error');</script>";
            }

            $stmt->close();
        }
        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro</h2>
        <form method="POST" action="">
            <input type="text" name="nome" placeholder="Nome completo" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="senha" placeholder="Senha" required><br>
            <button type="submit">Cadastrar</button>
        </form>
        <p>Já tem uma conta? <a href="index.php">Fazer login</a></p>
    </div>
</body>
</html>