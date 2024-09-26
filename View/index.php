<?php 

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
            
        default:
            echo "Página não encontrada";
    }
?>