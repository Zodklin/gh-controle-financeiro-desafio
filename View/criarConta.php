<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta</title>
</head>
<body>
    <form action="/salvarConta" method="POST">
        <p>
            <label for="email">Email</label>
            <input type="text" name="email" required>
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
    </form>
</body>
</html>