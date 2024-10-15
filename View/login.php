<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <form action="/logar" method="POST">
        <p>
            <label for="email">E-mail</label>
            <input type="text" name="email">
        </p>
        <p>
            <label for="senha">Senha</label>
            <input type="password" name="senha">
        </p>
        <button type="submit">Entrar</button>
        <a href="/criarConta">Criar conta</a>
    </form>
</body>
</html>