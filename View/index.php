<?php 

namespace App;

require '../vendor/autoload.php';
require '../src/Controllers/Expense.php';

$rotas = new Expense();

$uri = strtok($_SERVER['REQUEST_URI'], '?');
$page = rtrim($uri, '/') ?: '/';

switch ($page)
    {
        case "/dashboard":
            $rotas->getTransacoes();
            break;

        case "/deletar":
            $rotas->deletar();
            break;

        case "/criar":
            $rotas->criar();
            break;

        case "/salvar":
            $rotas->salvar();
            break;

        case "/editar":
            $rotas->editar();
            break;

        case "/atualizar":
            $rotas->atualizar();
            break;

        case "/filtrar":
            $rotas->filtrar();
            break;

        case "/categorias";
            $rotas->categorias();
            break;

        case "/deletarCat";
            $rotas->deletarCategoria();
            break;

        default:
            echo "Página não encontrada";
    }
?>