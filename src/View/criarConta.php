<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon">
    <title>Criar conta</title>
</head>
<body>
    <div class="container-login">
        <div class="container-form-login">
            <div class="form-login">
                <form action="/salvarConta" method="POST">
                <h1>Criar conta</h1>
                <p>
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </p>
                <p>
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" required>
                </p>
                <p>
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" required>
                </p>
                <button type="submit">Criar</button>
                <span>
                        <a href="/login">Voltar</a>
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