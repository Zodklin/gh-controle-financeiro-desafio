<?php 

namespace App\View;

use App\Controllers\Usuario;
use App\Controllers\Expense;
use App\Controllers\Categorias;

require '../../vendor/autoload.php';
require '../Controllers/Expense.php';
require '../Controllers/Categorias.php';
require '../Controllers/Usuario.php';

$rotasExpense = new Expense();
$rotasCategorias = new Categorias();
$user = new Usuario();

$uri = strtok($_SERVER['REQUEST_URI'], '?');
$page = rtrim($uri, '/') ?: '/';

switch ($page)
    {
        case "/logar":
            $user->logar();
            break;

        case "/login":
            $user->login();
            break;

        case "/logout":
            $user->logout();
            break;

        case "/criarConta":
            $user->criarConta();
            break;

        case "/salvarConta":
            $user->salvarConta();
            break;
            
        case "/dashboard":
            $rotasExpense->getTransacoes();
            break;

        case "/deletar":
            $rotasExpense->deletar();
            break;

        case "/criar":
            $rotasExpense->criar();
            break;

        case "/salvar":
            $rotasExpense->salvar();
            break;

        case "/editar":
            $rotasExpense->editar();
            break;

        case "/atualizar":
            $rotasExpense->atualizar();
            break;

        case "/filtrar":
            $rotasExpense->filtrar();
            break;

        case "/categorias";
            $rotasCategorias->listarCategorias();
            break;

        case "/deletarCat";
            $rotasCategorias->deletarCategoria();
            break;

        case "/editarCat";
            $rotasCategorias->getCategoriaById();
            break;

        case "/salvarCategoria";
            $rotasCategorias->atualizarCategoria();
            break;

        case "/criarCategoria";
            $rotasCategorias->criarCategoria();
            break;

        case "/adicionarCategoria";
                $rotasCategorias->adicionarCategoria();
                break;

        default: $user->login();
    }
?>