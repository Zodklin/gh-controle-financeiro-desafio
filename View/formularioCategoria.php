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
                    <a href="./dashboard"><i id="icon" class="fa-solid fa-house fa-xl"></i></a>
                    <p>Dashboard</p>
                </div>
                <div>
                    <a href="/filtrar"><i id="icon" class="fa-solid fa-file-contract fa-xl"></i></a>
                    <p>Filtrar</p>
                </div>
                <div>
                    <a href="/categorias"><i id="icon" class="fa-solid fa-gears" style="color: #007bff;"></i></a>
                    <p>Categorias</p>
                </div>
                <div>
                <a href="/logout"><i id="logout" class="fa-solid fa-right-from-bracket"></i></a>
                    <p>Sair</p>
                </div>
            </div>
        </aside>
        <main class="content-categorias">
            <div class="content-formulario-categoria">
                <div class="voltar-categoria">
                    <a href="/categorias"><i class="fa-solid fa-arrow-left fa-xl"></i></a>
                </div>
                <form action="<?php echo isset($categoriaSelecionada) ? "/salvarCategoria?id" . $categoriaSelecionada['id_categoria'] : "/adicionarCategoria"; ?>" method="POST" class="formulario-categorias">
                    <div class="categoria-input-container">
                        <label for="editar-categoria" class="label-formulario-categoria">Digite o nome da categoria:</label>
                            <input type="text" name="editar-categoria" value="<?php echo isset($categoriaSelecionada) ?  $categoriaSelecionada['nome_categoria'] : "";?>">
                    </div>
                    <div class="categorias-botoes">
                        <button><?php  echo isset($categoriaSelecionada) ? "Atualizar" : "Criar"; ?></button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>