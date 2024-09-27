<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2><i><img src="./assets/img/icon.png" alt="icon" id="icone"></i></h2>
            <div class="icons">
                <a href="./create"><i id="add" class="fa-solid fa-circle-plus fa-xl"></i></a>
                <a href="./home"><i id="icon" class="fa-solid fa-house fa-xl"></i></a>
                <a href="/filter"><i id="icon" class="fa-solid fa-file-contract fa-xl" style="color: #007bff;"></i></a>
            </div>
        </aside>
        <main class="content">
            <div class="content-backgroud">
                <h1 class="dash-title">Dashboard</h1>
                <form action="/filter" method="POST" class="filter-form">
                <div class="filter-item">
                    <label for="filter-month" class="filter-label">Selecione o mês:</label>
                    <input type="month" id="filter-month" name="mes" class="filter-month-input" required>
                </div>
                <div class="filter-item">
                    <label for="filter-category" class="filter-label">Selecione a categoria:</label>
                    <select id="filter-category" name="categoria" class="filter-category-select" required>
                        <option value="" disabled selected>Escolha uma categoria</option>
                        <option value="1">Alimentação</option>
                        <option value="2">Transporte</option>
                        <option value="3">Moradia</option>
                        <option value="4">Lazer</option>
                        <option value="4">Outros</option>
                    </select>
                </div>
                <button class="filter-button">Filtrar</button>
            </form>
                <div class="content-cards">
                    <div class="card-saldo">
                        <div class="card-info">
                            <h3 class="card-h3-title">Difenreça: </h2>
                            <h1 class="card-h1-value">R$ <?= $diferenca ?></h1>
                        </div>
                        <div class="card-icon">
                            <i class="fa-solid fa-circle-minus" style="color: orange;"></i>
                        </div>
                        </div>
                    <div class="card-receita">
                        <div>
                            <h3 class="card-h3-title">Receita: </h2>
                            <h1 class="card-h1-value">R$ <?= $filterReceita ?></h1>
                        </div>
                        <div class="card-icon">
                            <i class="fa-solid fa-circle-arrow-up" style="color: #007bff;"></i>
                        </div>
                        </div>
                    <div class="card-despesa">
                        <div>
                            <h3 class="card-h3-title">Despesas:</h2>
                            <h1 class="card-h1-value">R$ <?= $filterDespesa ?></h1>
                        </div>             
                        <div class="card-icon">
                        <i class="fa-solid fa-circle-arrow-down" style="color: #dc3545; "></i>
                        </div>
                        </div>
                </div>
            </div>
            <div class="list-container">
                <div class="transictions-tittles">
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
                <?php if($filtrado['tipo'] == 'despesa'){?>
                    <div class="list" style="background-color: #ffe6e6;">
                <?php } elseif($filtrado['tipo'] == 'receita'){ ?>
                    <div class="list" style="background-color: #daecff;">
                <?php } ?>
                    <div class="transictions">
                        <div class="tipo">
                        <?php if ($filtrado['tipo'] == 'despesa') { ?>
                            <span style="color: red;"><?= $filtrado['tipo'] ?></span>
                        <?php } elseif ($filtrado['tipo'] == 'receita') { ?>
                            <span style="color: blue;"><?= $filtrado['tipo'] ?></span>
                        <?php } ?>
                        </div>
                        <div class="descricao">
                            <span><?=$filtrado['descricao']?></span> 
                        </div>
                        <div class="valor">
                            <span>R$ <?=$filtrado['valor']?></span> 
                        </div>
                        <div class="data">
                            <span><?=$filtrado['data_transacao']?></span>
                        </div>
                        <div class="categoria">
                            <span><?=$filtrado['categoria_id']?></span> 
                        </div>
                        <div class="deleteUpdate">
                            <a href="/deletar?id=<?= $filtrado['id_transacao']?>"><i class="fa-solid fa-trash" style="color: #007bff;"></i></a>
                            <a href="/editar?id=<?= $filtrado['id_transacao']?>"><i class="fa-solid fa-pen-to-square"  style="color: #007bff;"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>

        </main>
    </div>
</body>
</html>