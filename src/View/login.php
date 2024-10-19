<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon">
    <title>Login</title>
</head>
<body>
    <div class="container-login">
        <div class="container-form-login">
            <div class="form-login">
                <form action="/logar" method="POST">
                <?php
                if (isset($_SESSION['mensagem'])) {
                    echo '<p style="color: #007bff ;">' . $_SESSION['mensagem'] . '</p>';
                    unset($_SESSION['mensagem']);
                } elseif (isset($_SESSION['mensagem'])) {
                    echo '<p style="color: #007bff ;">' . $_SESSION['msgErro'] . '</p>';
                    unset($_SESSION['mensagem']);
                }
                ?>
                    <h1>Login</h1><br><br>
                    <p>
                        <label for="email">E-mail</label>
                        <input type="text" name="email">
                    </p>
                    <p>
                        <label for="senha">Senha</label>
                        <input type="password" name="senha">
                    </p>
                    <span>
                        <button type="submit">Entrar</button>
                    </span>
                    <span>
                        <a href="/criarConta">Criar conta</a>
                    </span>
                </form>    
            </div>
            <div class="img-login">
                <img src="assets/img/icon.png" alt="logo.png">
            </div>
        </div>
    </div>
</body>
</html>