<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon">
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
    <aside class="sidebar">
            <h2><i><img src="./assets/img/icon.png" alt="icon" id="icone"></i></h2>
            <div class="icons">
                <div>
                    <a href="./criar"><i id="add" class="fa-solid fa-circle-plus fa-xl"></i></a>
                    <p id="addText" >Adicionar</p>
                </div>
                <div>
                    <a href="./dashboard"><i id="icon" class="fa-solid fa-house fa-xl"></i></a>
                    <p>Dashboard</p>
                </div>
                <div>
                    <a href="/filtrar"><i id="icon" class="fa-solid fa-file-contract fa-xl" style="color: #007bff;"></i></a>
                    <p >Filtrar</p>
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
        <main class="content">
            <div class="content-backgroud">
                <h1 class="dash-title">Dashboard</h1>
                <?php 
                if (isset($_SESSION['msgErro'])) {
                    echo '<p style="color: red ;">' . $_SESSION['msgErro'] . '</p>';
                    unset($_SESSION['msgErro']);
                }
                ?>
                <form action="/filtrar" method="POST" class="filter-form">
                    <div class="filter-item">
                        <label for="filter-date" class="filter-label">Inicio: </label>
                        <input type="date" id="filter-date-start" name="data-inicio" class="filter-date-input" required>
                    </div>
                    <div class="filter-item">
                        <label for="filter-date" class="filter-label">Fim:</label>
                        <input type="date" id="filter-date-end" name="data-fim" class="filter-date-input" required>
                    </div>
                    <div class="filter-item">
                        <label for="filter-category" class="filter-label">Selecione a categoria:</label>
                        <select id="filter-category" name="categoria" class="filter-category-select" required>
                            <option value="" disabled selected>Escolha uma categoria</option>
                            <?php foreach($categoriasPadrao as $categoriaPadrao): ?>
                                <option value="<?=$categoriaPadrao['id_categoria']?>" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["categoria_id"] == $categoriaPadrao['id_categoria'] ? 'selected' : ""; ?>><?= $categoriaPadrao['nome_categoria']?></option>
                            <?php endforeach?>
                            <?php foreach($categorias as $categoria): ?>
                                <option value="<?=$categoria['id_categoria']?>" <?php echo isset($transacaoSelecionada) && $transacaoSelecionada["categoria_id"] == $categoria['id_categoria'] ? 'selected' : ""; ?>><?= $categoria['nome_categoria']?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                    <button class="filter-button">Filtrar</button>
                </form>
                <div class="content-cards">
                    <div class="card-saldo">
                        <div class="card-info">
                            <h3 class="card-h3-titulo">Difenreça: </h2>
                            <h1 class="card-h1-valor">R$ <?= $diferenca ?></h1>
                        </div>
                        <div class="card-icon">
                            <i class="fa-solid fa-circle-minus" style="color: orange;"></i>
                        </div>
                        </div>
                    <div class="card-receita">
                        <div>
                            <h3 class="card-h3-titulo">Receita do período: </h2>
                            <h1 class="card-h1-valor">R$ <?= $filterReceita ?></h1>
                        </div>
                        <div class="card-icon">
                            <i class="fa-solid fa-circle-arrow-up" style="color: #007bff;"></i>
                        </div>
                        </div>
                    <div class="card-despesa">
                        <div>
                            <h3 class="card-h3-titulo">Despesas:</h2>
                            <h1 class="card-h1-valor">R$ <?= $filterDespesa ?></h1>
                        </div>             
                        <div class="card-icon">
                        <i class="fa-solid fa-circle-arrow-down" style="color: #dc3545; "></i>
                        </div>
                        </div>
                </div>
            </div>
            <div class="list-container">
                <div class="transacoes-titulos">
                    <div class="tipo">
                        <h3>Tipo</h3> 
                    </div>
                    <div class="descricao">
                        <h3>Descrição</h3> 
                    </div>
                    <div class="valor">
                        <h3>Valor</h3> 
                    </div>
                    <div class="data">
                        <h3>Data</h3> 
                    </div>
                    <div class="categoria">
                        <h3>Categoria</h3> 
                    </div>
                </div>
                <?php foreach($filtrados as $filtrado): ?>
                <?php if($filtrado['tipo'] == 'Despesa'){?>
                    <div class="list" style="background-color: #8b0000 ;">
                <?php } elseif($filtrado['tipo'] == 'Receita'){ ?>
                    <div class="list" style="background-color: #4a6fa5 ;">
                <?php } ?>
                    <div class="transictions">
                        <div class="tipo">
                            <span style="text-shadow: 0px 0px 5px #000000;"><?= $filtrado['tipo'] ?></span>
                        </div>
                        <div class="descricao">
                            <span style="text-shadow: 0px 0px 5px #000000;"><?=$filtrado['descricao']?></span> 
                        </div>
                        <div class="valor">
                            <span style="text-shadow: 0px 0px 5px #000000;">R$ <?=$filtrado['valor']?></span> 
                        </div>
                        <div class="data">
                            <span style="text-shadow: 0px 0px 5px #000000;"><?=$filtrado['data_transacao']?></span>
                        </div>
                        <div class="categoria">
                            <span style="text-shadow: 0px 0px 5px #000000;"><?=$filtrado['categoria_id']?></span> 
                        </div>
                        <div class="deleteUpdate">
                            <a href="/deletar?id=<?= $filtrado['id_transacao']?>"><i class="fa-solid fa-trash" style="color: white; text-shadow: 0px 0px 5px #000000;"></i></a>
                            <a href="/editar?id=<?= $filtrado['id_transacao']?>"><i class="fa-solid fa-pen-to-square"  style="color: white; text-shadow: 0px 0px 5px #000000;"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>

        </main>
    </div>
</body>
</html>