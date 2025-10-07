<?php
include 'conexao.php';

$erro = '';
$sucesso = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = 'Preencha todos os campos.';
    } else {
        $check = $conexao->prepare("SELECT * FROM usuarios WHERE email_usuario = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $resultado = $check->get_result();

        if ($resultado->num_rows > 0) {
            $erro = 'E-mail já cadastrado. Tente outro e-mail.';
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $conexao->prepare("INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario) VALUES (?, ?, ?)");
            $stmt->bind_param("ss", $email, $senha_hash);

            if ($stmt->execute()) {
                $sucesso = 'Cadastro realizado! Você já pode fazer login.';
            } else {
                $erro = 'Erro no cadastro. Tente novamente.';
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>Cadastro</h2>

        <?php if (!empty($erro)): ?>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos vazios ou E-mail já cadastrado',
                    text: '<?php echo htmlspecialchars($erro); ?>',
                    confirmButtonColor: '#305F49'
                });
            </script>
        <?php endif; ?>

        <?php if (!empty($sucesso)): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Cadastro realizado!',
                    text: '<?php echo htmlspecialchars($sucesso); ?>',
                    confirmButtonColor: '#305F49'
                }).then(() => {
                    window.location.href = 'cadastro.php';
                });
            </script>
        <?php endif; ?>

        <form method="POST" action="">
            <input id="email" type="email" name="email" placeholder="Email" required><br>
            <input id="senha" type="password" name="senha" placeholder="Senha" required><br>
            <button id="btn-login" type="submit">Cadastrar</button>
        </form>
        <p>Já tem uma conta? <a href="index.php">Fazer login</a></p>
    </div>
</body>
</html>
