<?php

namespace App\Controllers;
use App\Model\ConexaoBD;
use PDOException;

session_start();

class Expense
{
    private $Categoria;
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::createConnection(); //faz a conexão com o banco
        $this->Categoria = new Categorias(); //Faz conexão com a classe de categorias
    }


    private function listar()
    {
        try{
            $mesAtual = date('m'); //passo o mes atual pra variavel
            $anoAtual = date('Y'); // passo o ano atual pra variavel
            $select = "SELECT T.ID_TRANSACAO AS id_transacao, T.TIPO as tipo, T.DESCRICAO as descricao, T.VALOR as valor, DATE_FORMAT(T.DATA_TRANSACAO, '%d/%m/%Y') AS data_transacao, C.NOME_CATEGORIA as categoria_id FROM TRANSACOES T INNER JOIN CATEGORIAS C ON C.ID_CATEGORIA = T.CATEGORIA_ID WHERE MONTH(data_transacao) = :mes AND YEAR(data_transacao) = :ano AND T.USUARIO_ID = :usuario ORDER BY data_transacao"; //faço um select com 2 variaveis que irei bindar o valor do mes e ano atual
            $statement = $this->conexao->prepare($select); //preparo a exec
            $statement->bindParam(':mes', $mesAtual); // bindo o mes atual ao mes que irei procurar no banco
            $statement->bindParam(':ano', $anoAtual); // bindo o ano atual ao ano que irei procurar no banco
            $statement->bindParam(':usuario', $_SESSION['user']);
            $statement->execute(); //executo
            $transacoes = $statement->fetchAll(\PDO::FETCH_ASSOC); //trago o resultado pra query transformando em um array associativo e coloco esse array na variavel
    
            return $transacoes; //retorno o array
        }catch (PDOException $e){
            $_SESSION['msgErro'] = "Ocorreu um erro listar: " . $e->getMessage();
            header('Location: /dashboard');
        }
    }

    public function criar() 
    {
        if(isset($_SESSION['name'])){
        $categorias = $this->Categoria->getCategorias();
        $categoriasPadrao = $this->Categoria->getCategoriasPadrao();
        require '../View/formulario.php';//chamo o formulario
        } else {
            die(header("Location: /login"));
        }
    }

    public function salvar()
    {
        try{
            $dados = $_POST; //pego os dados que vieram no post do formulario
        
            // Verifica se a categoria é padrão ou do usuário
            if ($dados['categoria_padrao']) {
                $insert = "INSERT INTO transacoes (tipo, descricao, valor, data_transacao, categoria_padrao_id, usuario_id) VALUES (?,?,?,?,?,?)";
                $statement = $this->conexao->prepare($insert);
                $statement->bindValue(5, $dados['categoria_padrao']);
            } else {
                $insert = "INSERT INTO transacoes (tipo, descricao, valor, data_transacao, categoria_id, usuario_id) VALUES (?,?,?,?,?,?)";
                $statement = $this->conexao->prepare($insert);
                $statement->bindValue(5, $dados['categoria']);
            }
        
            $statement->bindValue(1, $dados['tipo']); //bindo os valores
            $statement->bindValue(2, $dados['descricao']);
            $statement->bindValue(3, $dados['valor']);
            $statement->bindValue(4, $dados['data']);
            $statement->bindValue(6, $_SESSION['user']);
            $statement->execute(); //executo o insert
            
            header('Location: /dashboard'); //volto pra dashboard page
        } catch (PDOException $e){
            $_SESSION['msgErro'] = "Ocorreu um erro ao salvar: " . $e->getMessage();
            header('Location: /dashboard');
        }

    }

    public function editar()
    {
        try{
            if(isset($_SESSION['name'])){
                $id = $_GET['id']; //pego o id da url do item atual
                $user = $_SESSION['user'];
                $select = "SELECT id_transacao, tipo, descricao, valor, data_transacao, categoria_id FROM transacoes WHERE id_transacao = $id AND usuario_id = $user"; //faço o select do item atual passando o id 
                $statement = $this->conexao->query($select); //executo a query
                $transacao = $statement->fetchAll(\PDO::FETCH_ASSOC); //passo o resultado pra um array associativo
                $transacaoSelecionada = $transacao[0]; //passo a transação na posição 0 (pois só tem ela) para variavel pra ser exibida
                $categorias = $this->Categoria->getCategorias();
                $categoriasPadrao = $this->Categoria->getCategoriasPadrao();
        
                require '../View/formulario.php'; //exibo o formulario 
            } else {
                die(header("Location: /login"));
            }
        } catch (PDOException $e){
            $_SESSION['msgErro'] = "Ocorreu um erro ao chamar o formulario: " . $e->getMessage();
            header('Location: /dashboard');
        }


    }
    
    public function atualizar()
    {
        try{
            $id = $_GET['id']; //pego o id da url
            $dados = $_POST; // pego as respostas do formulario e salvo na variavel via post
            $update = "UPDATE transacoes SET tipo = ?, descricao = ?, valor = ?, data_transacao = ?, categoria_id = ? WHERE id_transacao = ? and usuario_id = ?"; //preparo a query sem passar valores pois irei bindar
            $statement = $this->conexao->prepare($update); //preparo o exec
            $statement->bindValue(1, $dados['tipo']); //coloco o resultado na sua respectiva posição conforme passado na query
            $statement->bindValue(2, $dados['descricao']);
            $statement->bindValue(3, $dados['valor']);
            $statement->bindValue(4, $dados['data']);
            $statement->bindValue(5, $dados['categoria']);
            $statement->bindValue(6, $id); //uso esse pra passar o valor do id no where
            $statement->bindValue(7, $_SESSION['user']);
            $statement->execute(); //executo 
    
            header('Location: /dashboard');
        }catch (PDOException $e){
            $_SESSION['msgErro'] = "Ocorreu um erro ao editar: " . $e->getMessage();
            header('Location: /dashboard');
        }

    }

    public function deletar()
    {
        try{
            $id = $_GET['id']; //pego o id da url
            $delete = "DELETE FROM transacoes WHERE id_transacao = ? and usuario_id = ?"; //faço a query sem passar o id pois irei bindar
            $statement = $this->conexao->prepare($delete); //preparo o delete
            $statement->bindValue(1, $id); //bindo o valor do id que irei deletar
            $statement->bindValue(2, $_SESSION['user']);
            $statement->execute(); //executo o delete
    
            header('Location: /dashboard'); //volto pra dashboard page 
        } catch (PDOException $e){
            $_SESSION['msgErro'] = "Ocorreu um erro ao deletar: " . $e->getMessage();
            header('Location: /dashboard');
        }

    }

    private function getReceita()
    { //mesma situacao da função list linha 15, pego apenas a receita do mes/ano atual
        $mesAtual = date('m'); 
        $anoAtual = date('Y');
        $getReceita = "SELECT SUM(VALOR) FROM TRANSACOES WHERE TIPO = 'receita' AND MONTH(data_transacao) = :mes AND YEAR(data_transacao) = :ano AND usuario_id = :usuario";
        $statement = $this->conexao->prepare($getReceita);
        $statement->bindParam(':mes', $mesAtual);
        $statement->bindParam(':ano', $anoAtual);
        $statement->bindParam(':usuario', $_SESSION['user']);
        $statement->execute();
        $receita = $statement->fetchColumn();
        if ($receita == NULL){
            $receita = 0;
        }
        return $receita;
    }

    private function getDespesa()
    { //mesma situacao da função list linha 15, pego apenas a despesa do mes/ano atual
        $mesAtual = date('m');
        $anoAtual = date('Y');
        $getDespesa = "SELECT sum(valor) FROM transacoes WHERE tipo = 'despesa' AND MONTH(data_transacao) = :mes AND YEAR(data_transacao) = :ano AND usuario_id = :usuario";
        $statement = $this->conexao->prepare($getDespesa);
        $statement->bindParam(':mes', $mesAtual);
        $statement->bindParam(':ano', $anoAtual);
        $statement->bindParam(':usuario', $_SESSION['user']);
        $statement->execute();
        $despesa = $statement->fetchColumn();
        if ($despesa == NULL){
            $despesa = 0;
        }
        return $despesa;
    }

    private function getSaldo()
    { //faço a subtração da receita com a despesa pra resultar no saldo 
        $saldo = $this->getReceita() - $this->getDespesa();
        return $saldo;
    }

    public function getTransacoes()
    { //junto todas as transações em uma função e chamo uma vez só
        if(isset($_SESSION['name'])){
            $saldo = $this->getSaldo();
            $receita = $this->getReceita();
            $despesa = $this->getDespesa();
            $transacoes = $this->listar();
            require '../View/home.php';
        } else {
            die(header("Location: /login"));
        }

    }

    public function filtrar() //Acho que essa função ficou mt grande... 
    {
        try{
            if(isset($_SESSION['name'])){
                $categorias = $this->Categoria->getCategorias();
            $categoriasPadrao = $this->Categoria->getCategoriasPadrao();
            $filtro = $_POST; //pego os dados do filtro no post
            if($filtro != NULL){ //faço uma validação pra rodar a consulta 
                $select = "SELECT t.id_transacao AS id_transacao, t.tipo AS tipo, t.descricao AS descricao, t.valor AS valor, DATE_FORMAT(data_transacao, '%d/%m/%Y') AS data_transacao, c.nome_categoria AS categoria_id FROM transacoes t INNER JOIN categorias c ON c.id_categoria = t.categoria_id WHERE data_transacao BETWEEN ? AND ? AND categoria_id = ? and t.usuario_id = ?";
                $statement = $this->conexao->prepare($select);
                $statement->bindValue(1, $filtro['data-inicio']);
                $statement->bindValue(2, $filtro['data-fim']);
                $statement->bindValue(3, $filtro['categoria']);
                $statement->bindValue(4, $_SESSION['user']);
                $statement->execute(); // executo a query que fiz, pegando a data inicial e final e a categoria, e pesquisando essas datas no banco pra trazer o periodo
                $filtrados = $statement->fetchAll(\PDO::FETCH_ASSOC); //passo a consulta pra um array associativo e exibo no front iterando sobre o array com um foreach
                
                $receita = "SELECT sum(valor) FROM transacoes WHERE tipo = 'Receita' AND data_transacao between ? AND ? and usuario_id = ?";
                $statement = $this->conexao->prepare($receita);
                $statement->bindValue(1, $filtro['data-inicio']);
                $statement->bindValue(2, $filtro['data-fim']);
                $statement->bindValue(3, $_SESSION['user']);
                $statement->execute(); //mesma coisa porem pra trazer a soma da receita
    
                $filterReceita = $statement->fetchColumn();
                if($filterReceita == NULL){
                    $filterReceita = 0;
                }
    
                $despesa = "SELECT sum(valor) FROM transacoes WHERE tipo = 'Despesa' AND data_transacao between ? AND ? AND usuario_id = ?";
                $statement = $this->conexao->prepare($despesa);
                $statement->bindValue(1, $filtro['data-inicio']);
                $statement->bindValue(2, $filtro['data-fim']);
                $statement->bindValue(3, $_SESSION['user']);
                $statement->execute(); //mesma coisa porem pra trazer a soma da despesa
                $filterDespesa = $statement->fetchColumn();
    
                if($filterDespesa == NULL){
                    $filterDespesa = 0;
                }
    
                $diferenca = $filterReceita - $filterDespesa; //calculo de diferença da receita do periodo pela despesa
                require '../View/filtrar.php';
            } else {
                $diferenca = 0;
                $filterDespesa = 0;
                $filterReceita = 0;
                $filtrados = [];
                require '../View/filtrar.php';}
            }else {
                die(header("Location: /login"));
            }
        } catch (PDOException $e){
            $_SESSION['msgErro'] = "Ocorreu um erro ao filtrar: " . $e->getMessage();
            header('Location: /filtrar');
        }
    }
}