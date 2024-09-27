<?php

namespace App;

class Expense
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::createConnection(); //faz a conexão com o banco
    }


    public function list()
    {
    $currentMonth = date('m'); //passo o mes atual pra variavel
    $currentYear = date('Y'); // passo o ano atual pra variavel
    $select = "SELECT T.ID_TRANSACAO AS id_transacao, T.TIPO as tipo, T.DESCRICAO as descricao, T.VALOR as valor, DATE_FORMAT(T.DATA_TRANSACAO, '%d/%m/%Y') AS data_transacao, C.NOME_CATEGORIA as categoria_id FROM TRANSACOES T INNER JOIN CATEGORIAS C ON C.ID_CATEGORIA = T.CATEGORIA_ID WHERE MONTH(data_transacao) = :mes AND YEAR(data_transacao) = :ano"; //faço um select com 2 variaveis que irei bindar o valor do mes e ano atual
    $statement = $this->conexao->prepare($select); //preparo a exec
    $statement->bindParam(':mes', $currentMonth); // bindo o mes atual ao mes que irei procurar no banco
    $statement->bindParam(':ano', $currentYear); // bindo o ano atual ao ano que irei procurar no banco
    $statement->execute(); //executo
    $transictions = $statement->fetchAll(\PDO::FETCH_ASSOC); //trago o resultado pra query transformando em um array associativo e coloco esse array na variavel

    return $transictions; //retorno o array
    }
    
    

    public function create() 
    {
        require '../View/formulario.php'; //chamo o formulario
    }

    public function save()
    {
        $dados = $_POST; //pego os dados que vieram no post do formulario
        $insert = "INSERT INTO transacoes (tipo, descricao, valor, data_transacao, categoria_id) VALUES (?,?,?,?,?)"; //faço a query do insert, sem passar values pois irei bindar depois do prepare
        $statement = $this->conexao->prepare($insert); //preparo a exec
        $statement->bindValue(1, $dados['tipo']); //bindo os valores
        $statement->bindValue(2, $dados['descricao']);
        $statement->bindValue(3, $dados['valor']);
        $statement->bindValue(4, $dados['data']);
        $statement->bindValue(5, $dados['categoria']);
        $statement->execute(); //executo o insert
        header('Location: /home'); //volto pra home page
    }

    public function edit()
    {
        $id = $_GET['id']; //pego o id da url do item atual
        $select = "SELECT id_transacao, tipo, descricao, valor, data_transacao, categoria_id FROM transacoes WHERE id_transacao = $id"; //faço o select do item atual passando o id 
        $statement = $this->conexao->query($select); //executo a query
        $transacao = $statement->fetchAll(\PDO::FETCH_ASSOC); //passo o resultado pra um array associativo
        $transacaoSelecionada = $transacao[0]; //passo a transação na posição 0 (pois só tem ela) para variavel pra ser exibida
        require '../View/formulario.php'; //exibo o formulario 
    }
    
    public function update()
    {
        $id = $_GET['id']; //pego o id da url
        $dados = $_POST; // pego as respostas do formulario e salvo na variavel via post
        $update = "UPDATE transacoes SET tipo = ?, descricao = ?, valor = ?, data_transacao = ?, categoria_id = ? WHERE id_transacao = ?"; //preparo a query sem passar valores pois irei bindar
        $statement = $this->conexao->prepare($update); //preparo o exec
        $statement->bindValue(1, $dados['tipo']); //coloco o resultado na sua respectiva posição conforme passado na query
        $statement->bindValue(2, $dados['descricao']);
        $statement->bindValue(3, $dados['valor']);
        $statement->bindValue(4, $dados['data']);
        $statement->bindValue(5, $dados['categoria']);
        $statement->bindValue(6, $id); //uso esse pra passar o valor do id no where
        $statement->execute(); //executo 

        header('Location: /home');
    }

    public function delete()
    {
        $id = $_GET['id']; //pego o id da url
        $delete = "DELETE FROM transacoes WHERE id_transacao = ?"; //faço a query sem passar o id pois irei bindar
        $statement = $this->conexao->prepare($delete); //preparo o delete
        $statement->bindValue(1, $id); //bindo o valor do id que irei deletar
        $statement->execute(); //executo o delete
        header('Location: /home'); //volto pra home page 
    }

    public function getReceita()
    { //mesma situacao da função list linha 15, pego apenas a receita do mes/ano atual
        $currentMonth = date('m'); 
        $currentYear = date('Y');
        $getReceita = "SELECT SUM(VALOR) FROM TRANSACOES WHERE TIPO = 'receita' AND MONTH(data_transacao) = :mes AND YEAR(data_transacao) = :ano";
        $statement = $this->conexao->prepare($getReceita);
        $statement->bindParam(':mes', $currentMonth);
        $statement->bindParam(':ano', $currentYear);
        $statement->execute();
        $receita = $statement->fetchColumn();
        if ($receita == NULL){
            $receita = 0;
        }
        return $receita;
    }

    public function getDespesa()
    { //mesma situacao da função list linha 15, pego apenas a despesa do mes/ano atual
        $currentMonth = date('m');
        $currentYear = date('Y');
        $getDespesa = "SELECT sum(valor) FROM transacoes WHERE tipo = 'despesa' AND MONTH(data_transacao) = :mes AND YEAR(data_transacao) = :ano";
        $statement = $this->conexao->prepare($getDespesa);
        $statement->bindParam(':mes', $currentMonth);
        $statement->bindParam(':ano', $currentYear);
        $statement->execute();
        $despesa = $statement->fetchColumn();
        if ($despesa == NULL){
            $despesa = 0;
        }
        return $despesa;
    }


    public function getSaldo()
    { //faço a subtração da receita com a despesa pra resultar no saldo 
        $saldo = $this->getReceita() - $this->getDespesa();
    return $saldo;
    }



    public function getTransactions()
    { //junto todas as transações em uma função e chamo uma vez só 
        $saldo = $this->getSaldo();
        $receita = $this->getReceita();
        $despesa = $this->getDespesa();
        $transacoes = $this->list();
        require '../View/home.php'; 
    }

    public function filter()
    {
        $filtro = $_POST;
        if($filtro != NULL){
            $select = "SELECT * FROM transacoes WHERE MONTH(data_transacao) = ? AND categoria_id = ?";
            $statement = $this->conexao->prepare($select);
            $statement->bindValue(1, $filtro['data']);
            $statement->bindValue(2, $filtro['categoria']);
            $statement->execute();
            $filtrados = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $receita = "SELECT sum(valor) FROM transacoes WHERE tipo = 'receita' AND MONTH(data_transacao) = ? AND categoria_id = ?";
            $statement = $this->conexao->prepare($receita);
            $statement->bindValue(1, $filtro['data']);
            $statement->bindValue(2, $filtro['categoria']);
            $statement->execute();
            $filterReceita = $statement->fetchColumn();
            if($filterReceita == NULL){
                $filterReceita = 0;
            }
            $despesa = "SELECT sum(valor) FROM transacoes WHERE tipo = 'despesa' AND MONTH(data_transacao) = ? AND categoria_id = ?";
            $statement = $this->conexao->prepare($despesa);
            $statement->bindValue(1, $filtro['data']);
            $statement->bindValue(2, $filtro['categoria']);
            $statement->execute();
            $filterDespesa = $statement->fetchColumn();
            if($filterDespesa == NULL){
                $filterDespesa = 0;
            }
            $diferenca = $filterReceita - $filterDespesa;
            require '../View/filtrar.php';
        } else {
            $diferenca = 0;
            $filterDespesa = 0;
            $filterReceita = 0;
            $filtrados = [];
            require '../View/filtrar.php';}
    }

    public function setFilter()
    {

    }

}