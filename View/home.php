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
                <a href="#"><i id="add" class="fa-solid fa-circle-plus fa-xl"></i></a>
                <a href="#"><i id="icon" class="fa-solid fa-house fa-xl"></i></a>
                <a href="#"><i id="icon" class="fa-solid fa-chart-line fa-xl"></i></a>
            </div>
        </aside>
        <main class="content">
            <div class="content-backgroud">
                <h1 class="dash-title">Dashboard</h1>
                <div class="content-cards">
                    <div class="card-saldo">
                        <div class="card-info">
                            <h3 class="card-h3-title">Saldo atual: </h2>
                            <h1 class="card-h1-value">R$ <?=$saldo?></h1>
                        </div>
                        <div class="card-icon">
                            <i class="fa-solid fa-circle-minus" style="color: #e0b0fa;"></i>
                        </div>
                        </div>
                    <div class="card-receita">
                        <div>
                            <h3 class="card-h3-title">Receita: </h2>
                            <h1 class="card-h1-value">R$ <?=$receita?></h1>
                        </div>
                        <div class="card-icon">
                            <i class="fa-solid fa-circle-arrow-up" style="color: #AD49E1;"></i>
                        </div>
                        </div>
                    <div class="card-despesa">
                        <div>
                            <h3 class="card-h3-title">Despesas:</h2>
                            <h1 class="card-h1-value">R$ <?= $despesa ?></h1>
                        </div>             
                        <div class="card-icon">
                        <i class="fa-solid fa-circle-arrow-down" style="color: #2E073F;"></i>
                        </div>
                        </div>
                </div>
            </div>
            <div class="em-baixo"></div>
        </main>
    </div>
</body>
</html>