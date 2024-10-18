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
                <div>
                    <a href="./criar"><i id="add" class="fa-solid fa-circle-plus fa-xl"></i></a>
                    <p id="addText" >Adicionar</p>
                </div>
                <div>
                    <a href="./dashboard"><i id="icon" class="fa-solid fa-house fa-xl" style="color: #007bff;"></i></a>
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
        <main class="content">
            <div class="content-backgroud">
                <div class="content-header">
                    <h1 class="titulo-dashboard">Dashboard</h1><br>
                </div>
                <h2 style="margin-left: 10px;">Olá, <?= $_SESSION['name'];?></h2><br>
                <div class="content-cards">
                    <div class="card-saldo">
                        <div class="card-info">
                            <h3 class="card-h3-titulo">Saldo atual: </h2>
                            <h1 class="card-h1-valor">R$ <?=$saldo?></h1>
                        </div>
                        <div class="card-icon">
                            <i class="fa-solid fa-circle-minus" style="color: #28a745;"></i>
                        </div>
                        </div>
                    <div class="card-receita">
                        <div>
                            <h3 class="card-h3-titulo">Receita: </h2>
                            <h1 class="card-h1-valor">R$ <?=$receita?></h1>
                        </div>
                        <div class="card-icon">
                            <i class="fa-solid fa-circle-arrow-up" style="color: #007bff;"></i>
                        </div>
                        </div>
                    <div class="card-despesa">
                        <div>
                            <h3 class="card-h3-titulo">Despesas:</h2>
                            <h1 class="card-h1-valor">R$ <?= $despesa ?></h1>
                        </div>             
                        <div class="card-icon">
                        <i class="fa-solid fa-circle-arrow-down" style="color: #dc3545; "></i>
                        </div>
                        </div>
                </div>
            </div>
            <div class="container-listas">
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
                <?php foreach($transacoes as $transiction): ?>
                <?php if($transiction['tipo'] == 'Despesa'){?>
                    <div class="list" style="background-color: #8b0000 ;">
                <?php } elseif($transiction['tipo'] == 'Receita'){ ?>
                    <div class="list" style="background-color: #4a6fa5 ;">
                <?php } ?>
                    <div class="transictions">
                        <div class="tipo">
                            <span style="text-shadow: 0px 0px 5px #000000;"><?= $transiction['tipo'] ?></span>
                        </div>
                        <div class="descricao">
                            <span style="text-shadow: 0px 0px 5px #000000;"><?=$transiction['descricao']?></span> 
                        </div>
                        <div class="valor">
                            <span style="text-shadow: 0px 0px 5px #000000;">R$ <?=$transiction['valor']?></span> 
                        </div>
                        <div class="data">
                            <span style="text-shadow: 0px 0px 5px #000000;"><?=$transiction['data_transacao']?></span>
                        </div>
                        <div class="categoria">
                            <span style="text-shadow: 0px 0px 5px #000000;"><?=$transiction['categoria_id']?></span> 
                        </div>
                        <div class="deleteUpdate">
                            <a href="/deletar?id=<?= $transiction['id_transacao']?>"><i class="fa-solid fa-trash" style="color: white; text-shadow: 0px 0px 5px #000000;"></i></a>
                            <a href="/editar?id=<?= $transiction['id_transacao']?>"><i class="fa-solid fa-pen-to-square"  style="color: white; text-shadow: 0px 0px 5px #000000;"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </main>
    </div>
</body>
</html>