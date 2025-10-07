<?php
session_start();
include 'conexao.php';

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos.";
    } else {
        $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE email_usuario = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            if (password_verify($senha, $usuario['senha_usuario'])) {
                $_SESSION['id_usuario'] = $usuario['id_usuario'];

                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                      <script>
                        Swal.fire({
                          icon: 'success',
                          title: 'Login efetuado!',
                          text: 'Bem-vindo!',
                          confirmButtonColor: '#305F49'
                        }).then(() => { window.location.href = 'pagina-inicial.php'; });
                      </script>";
                exit;
            } else {
                $erro = 'Senha incorreta. Tente novamente.';
            }
        } else {    
            $erro = 'Usuário não encontrado. Verifique seu e-mail.';
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
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <?php if (!empty($erro)): ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro no login',
                    text: '<?php echo htmlspecialchars($erro); ?>',
                    confirmButtonColor: '#305F49'
                });
            </script>
        <?php endif; ?>

        <form method="POST" action="">
            <input id="email" type="email" name="email" placeholder="Email" required><br>
            <input id="senha" type="password" name="senha" placeholder="Senha" required><br>
            <button id="btn-login" type="submit">Entrar</button>
        </form>
        <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
    </div>
</body>
</html>
