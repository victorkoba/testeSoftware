<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($email) || empty($senha)) {
        echo "<script src='assets/js/sweetalert2.all.min.js'></script>";
        echo "<script>Swal.fire('Campos vazios', 'Por favor, preencha todos os campos.', 'warning');</script>";
    } else {
        // Protege contra SQL Injection
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email_usuario = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();

            // Verifica senha (ideal usar password_hash no cadastro)
            if (password_verify($senha, $usuario['senha_usuario'])) {
                echo "<script src='assets/js/sweetalert2.all.min.js'></script>";
                echo "<script>Swal.fire('Login realizado!', 'Bem-vindo, {$usuario['nome_usuario']}!', 'success');</script>";
            } else {
                echo "<script src='assets/js/sweetalert2.all.min.js'></script>";
                echo "<script>Swal.fire('Erro', 'Senha incorreta.', 'error');</script>";
            }
        } else {
            echo "<script src='assets/js/sweetalert2.all.min.js'></script>";
            echo "<script>Swal.fire('Erro', 'Usuário não encontrado.', 'error');</script>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="senha" placeholder="Senha" required><br>
            <button type="submit">Entrar</button>
        </form>
        <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
    </div>
</body>
</html>