<?php 

namespace App;

require '../vendor/autoload.php';
require '../src/Controllers/Expense.php';

$rotas = new Expense();

$uri = strtok($_SERVER['REQUEST_URI'], '?');
$page = rtrim($uri, '/') ?: '/';

switch ($page)
    {
        case "/home":
            $rotas->getTransactions();
            break;

        case "/deletar":
            $rotas->delete();
            break;

        case "/create":
            $rotas->create();
            break;

        case "/save":
            $rotas->save();
            break;

        case "/editar":
            $rotas->edit();
            break;

        case "/update":
            $rotas->update();
            break;

        case "/filter":
            $rotas->filter();
            break;

        default:
            echo "Página não encontrada";
    }
?>