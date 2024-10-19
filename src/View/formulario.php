<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon">
    <title>Formulário</title>
</head>
<body>
    <div class="container">
    <aside class="sidebar">
            <h2><i><img src="./assets/img/icon.png" alt="icon" id="icone"></i></h2>
            <div class="icons">
                <div>
                    <a href="./criar"><i id="add" class="fa-solid fa-circle-plus fa-xl"  style="color: #007bff;"></i></a>
                    <p id="addText" >Adicionar</p>
                </div>
                <div>
                    <a href="./dashboard"><i id="icon" class="fa-solid fa-house fa-xl"></i></a>
                    <p>Dashboard</p>
                </div>
                <div>
                    <a href="/filtrar"><i id="icon" class="fa-solid fa-file-contract fa-xl"></i></a>
                    <p>Filtrar</p>
                </div>
                <div>
                    <a href="/categorias"><i id="icon" class="fa-solid fa-gears"></i></a>
                    <p>Categorias</p>
                </div>
                <div>
                <a href="/logout"><i id="logout" class="fa-solid fa-right-from-bracket"></i></a>
                    <p>Sair</p>
                </div>
            </div>
        </aside>
        <main class="content-formulario">
            <div class="container-formulario">
                <form action="<?php echo isset($transacaoSelecionada) ? "/atualizar?id=" . $transacaoSelecionada['id_transacao'] : "/salvar"?>" method="POST" class="formulario-add">
                <h1><?php echo isset($transacaoSelecionada) ? "Editar" : "Adicionar" ?></h1>
                    <label for="valor" >Valor:</label>
                        <input type="number" class="valor-add" name="valor" step="0.01" value="<?php echo isset($transacaoSelecionada) ? $transacaoSelecionada['valor'] : ""; ?>" required>
                    <br><br>
                    <label for="descricao">Descrição:</label>
                        <input type="text" class="descricao-add" name="descricao" value="<?php echo isset($transacaoSelecionada) ? $transacaoSelecionada['descricao'] : ""; ?>" required>
                    <br><br>
                    <label for="data">Data:</label>
                        <input type="date" class="data-add" name="data" value="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($transacaoSelecionada) ? $transacaoSelecionada['data_transacao'] : ""; ?>" required>
                    <br><br>
                    <label>Tipo de transação:</label>
                    <div class="tipo-add">
                        <label>
                            <input type="radio" name="tipo" value="Despesa" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["tipo"] = 'Despesa' ? 'checked' : ""; ?> required> Despesa
                        </label>
                        <label>
                            <input type="radio"  name="tipo" value="Receita" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["tipo"] = 'Receita' ? 'checked' : ""; ?> required> Receita
                        </label>
                    </div>
                    <br>
                    <label for="categoria">Categoria:</label>
                        <select id="categoria" name="categoria" required>
                            <option value="">Selecione a categoria</option>
                            <?php foreach($categoriasPadrao as $categoriaPadrao): ?>
                                <option value="<?=$categoriaPadrao['id_categoria']?>" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["categoria_id"] == $categoriaPadrao['id_categoria'] ? 'selected' : ""; ?>><?= $categoriaPadrao['nome_categoria']?></option>
                            <?php endforeach?>
                            <?php foreach($categorias as $categoria): ?>
                                <option value="<?=$categoria['id_categoria']?>" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["categoria_id"] == $categoria['id_categoria'] ? 'selected' : ""; ?>><?= $categoria['nome_categoria']?></option>
                            <?php endforeach?>
                        </select>
                    <button class="botao-add" type="">Salvar</button>
                    </form>
            </div>
        </main>
    </div>
</body>
</html>
