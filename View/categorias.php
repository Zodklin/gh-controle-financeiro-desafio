<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <title>Categorias</title>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2><i><img src="./assets/img/icon.png" alt="icon" id="icone"></i></h2>
            <div class="icons">
                <a href="./criar"><i id="add" class="fa-solid fa-circle-plus fa-xl"></i></a>
                <a href="./dashboard"><i id="icon" class="fa-solid fa-house fa-xl" style="color: #007bff;"></i></a>
                <a href="/filtrar"><i id="icon" class="fa-solid fa-file-contract fa-xl"></i></a>
            </div>
        </aside>
        <main class="content-categorias">
            <div class="container-categorias">
                <div class="lista-categorias">
                <h1>Manutenção de categorias</h1>
                <?php foreach($categorias as $categoria): ?>
                    <div class="item-categoria">
                        <span style="text-shadow: 0px 0px 5px #000000;"><?= $categoria['nome_categoria'] ?></span>
                        <div class="deleteUpdate-categoria">
                            <a href="/deletarCat?id=<?= $categoria['id_categoria'] ?>" 
                            onclick="return confirm('Ao deletar a categoria, será deletado todas as transações atreladas a ela. Tem certeza que deseja continuar?')">
                            <i class="fa-solid fa-trash" style="color: white; text-shadow: 0px 0px 5px #000000;"></i>
                            </a>
                            <a href="/editarCat?id=<?= $categoria['id_categoria'] ?>"><i class="fa-solid fa-pen-to-square"  style="color: white; text-shadow: 0px 0px 5px #000000;"></i></a>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </main>
    </div>
</body>
</html>