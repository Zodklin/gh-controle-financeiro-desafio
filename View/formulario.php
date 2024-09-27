<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <title>Formulário</title>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2><i><img src="./assets/img/icon.png" alt="icon" id="icone"></i></h2>
            <div class="icons">
                <a href="./formulario.php"><i id="add" class="fa-solid fa-circle-plus fa-xl" style="color: #007bff;"></i></a>
                <a href="./home"><i id="icon" class="fa-solid fa-house fa-xl"></i></a>
                <a href="/filter"><i id="icon" class="fa-solid fa-file-contract fa-xl"></i></a>
            </div>
        </aside>
        <main class="content-formulario">
            <div class="container-formulario">
            <form action="<?php echo isset($transacaoSelecionada) ? "/update?id=" . $transacaoSelecionada['id_transacao'] : "/save"?>" method="POST">
                <label for="valor">Valor:</label>
                <input type="number" id="valor" name="valor" step="0.01" placeholder="Insira o valor" value="<?php echo isset($transacaoSelecionada) ? $transacaoSelecionada['valor'] : ""; ?>" required>
                <br><br>
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" placeholder="Insira uma descrição" value="<?php echo isset($transacaoSelecionada) ? $transacaoSelecionada['descricao'] : ""; ?>" required>
                <br><br>
                <label for="data">Data:</label>
                <input type="date" id="data" name="data" value="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($transacaoSelecionada) ? $transacaoSelecionada['data_transacao'] : ""; ?>" required>
                <br><br>
                <label for="categoria">Categoria:</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecione a categoria</option>
                    <option value="1" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["categoria_id"] == 1 ? 'selected' : ""; ?>>Alimentação</option>
                    <option value="2" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["categoria_id"] == 2 ? 'selected' : ""; ?>>Transporte</option>
                    <option value="3" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["categoria_id"] == 3 ? 'selected' : ""; ?>>Lazer</option>
                    <option value="4" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["categoria_id"] == 4 ? 'selected' : ""; ?>>Outros</option>
                </select>
                <br><br>
                <label>Tipo de transação:</label>
                <label>
                    <input type="radio" name="tipo" value="despesa" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["tipo"] == 'despesa' ? 'checked' : ""; ?> required> Despesa
                </label>
                <label>
                    <input type="radio" name="tipo" value="receita" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["tipo"] == 'receita' ? 'checked' : ""; ?> required> Receita
                </label>
                <br><br>
                <button type="">Salvar</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
