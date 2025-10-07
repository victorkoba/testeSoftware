<?php
include 'conexao.php';

$erro = ""; // Mensagem de erro
$sucesso = ""; // Mensagem de sucesso

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos.";
    } else {
        // Verifica se já existe o e-mail
        $check = $conexao->prepare("SELECT * FROM usuarios WHERE email_usuario = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $resultado = $check->get_result();

        if ($resultado->num_rows > 0) {
            $erro = "E-mail já cadastrado.";
        } else {
            // Criptografa a senha
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            // Insere novo usuário
            $stmt = $conexao->prepare("INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $email, $senha_hash);

            if ($stmt->execute()) {
                $sucesso = "Cadastro realizado com sucesso!";
            } else {
                $erro = "Não foi possível cadastrar. Tente novamente.";
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

        <?php if (!empty($erro)): ?>
            <div style="color: red; margin-bottom: 10px;">
                <?php echo htmlspecialchars($erro); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($sucesso)): ?>
            <div style="color: green; margin-bottom: 10px;">
                <?php echo htmlspecialchars($sucesso); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="nome" placeholder="Nome completo" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="senha" placeholder="Senha" required><br>
            <button type="submit">Cadastrar</button>
        </form>
        <p>Já tem uma conta? <a href="login.php">Fazer login</a></p>
    </div>
</body>
</html>