<?php

namespace App;

class Expense
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::createConnection(); //faz a conexão com o banco
    }


    public function listar()
    {
    $mesAtual = date('m'); //passo o mes atual pra variavel
    $anoAtual = date('Y'); // passo o ano atual pra variavel
    $select = "SELECT T.ID_TRANSACAO AS id_transacao, T.TIPO as tipo, T.DESCRICAO as descricao, T.VALOR as valor, DATE_FORMAT(T.DATA_TRANSACAO, '%d/%m/%Y') AS data_transacao, C.NOME_CATEGORIA as categoria_id FROM TRANSACOES T INNER JOIN CATEGORIAS C ON C.ID_CATEGORIA = T.CATEGORIA_ID WHERE MONTH(data_transacao) = :mes AND YEAR(data_transacao) = :ano ORDER BY data_transacao"; //faço um select com 2 variaveis que irei bindar o valor do mes e ano atual
    $statement = $this->conexao->prepare($select); //preparo a exec
    $statement->bindParam(':mes', $mesAtual); // bindo o mes atual ao mes que irei procurar no banco
    $statement->bindParam(':ano', $anoAtual); // bindo o ano atual ao ano que irei procurar no banco
    $statement->execute(); //executo
    $transacoes = $statement->fetchAll(\PDO::FETCH_ASSOC); //trago o resultado pra query transformando em um array associativo e coloco esse array na variavel

    return $transacoes; //retorno o array
    }
    
    

    public function criar() 
    {
        require '../View/formulario.php'; //chamo o formulario
    }

    public function salvar()
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

    public function editar()
    {
        $id = $_GET['id']; //pego o id da url do item atual
        $select = "SELECT id_transacao, tipo, descricao, valor, data_transacao, categoria_id FROM transacoes WHERE id_transacao = $id"; //faço o select do item atual passando o id 
        $statement = $this->conexao->query($select); //executo a query
        $transacao = $statement->fetchAll(\PDO::FETCH_ASSOC); //passo o resultado pra um array associativo
        $transacaoSelecionada = $transacao[0]; //passo a transação na posição 0 (pois só tem ela) para variavel pra ser exibida
        require '../View/formulario.php'; //exibo o formulario 
    }
    
    public function atualizar()
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

    public function deletar()
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
        $mesAtual = date('m'); 
        $anoAtual = date('Y');
        $getReceita = "SELECT SUM(VALOR) FROM TRANSACOES WHERE TIPO = 'receita' AND MONTH(data_transacao) = :mes AND YEAR(data_transacao) = :ano";
        $statement = $this->conexao->prepare($getReceita);
        $statement->bindParam(':mes', $mesAtual);
        $statement->bindParam(':ano', $anoAtual);
        $statement->execute();
        $receita = $statement->fetchColumn();
        if ($receita == NULL){
            $receita = 0;
        }
        return $receita;
    }

    public function getDespesa()
    { //mesma situacao da função list linha 15, pego apenas a despesa do mes/ano atual
        $mesAtual = date('m');
        $anoAtual = date('Y');
        $getDespesa = "SELECT sum(valor) FROM transacoes WHERE tipo = 'despesa' AND MONTH(data_transacao) = :mes AND YEAR(data_transacao) = :ano";
        $statement = $this->conexao->prepare($getDespesa);
        $statement->bindParam(':mes', $mesAtual);
        $statement->bindParam(':ano', $anoAtual);
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



    public function getTransacoes()
    { //junto todas as transações em uma função e chamo uma vez só 
        $saldo = $this->getSaldo();
        $receita = $this->getReceita();
        $despesa = $this->getDespesa();
        $transacoes = $this->listar();
        require '../View/home.php'; 
    }

    public function filtrar()
    {
        $filtro = $_POST; //pego os dados do filtro no post
        if($filtro != NULL){ //faço uma validação pra rodar a consulta 
            $select = "SELECT t.id_transacao AS id_transacao, t.tipo AS tipo, t.descricao AS descricao, t.valor AS valor, DATE_FORMAT(data_transacao, '%d/%m/%Y') AS data_transacao, c.nome_categoria AS categoria_id FROM transacoes t INNER JOIN categorias c ON c.id_categoria = t.categoria_id WHERE data_transacao BETWEEN ? AND ? AND categoria_id = ?";
            $statement = $this->conexao->prepare($select);
            $statement->bindValue(1, $filtro['data-inicio']);
            $statement->bindValue(2, $filtro['data-fim']);
            $statement->bindValue(3, $filtro['categoria']);
            $statement->execute(); // executo a query que fiz, pegando a data inicial e final e a categoria, e pesquisando essas datas no banco pra trazer o periodo
            $filtrados = $statement->fetchAll(\PDO::FETCH_ASSOC); //passo a consulta pra um array associativo e exibo no front iterando sobre o array com um foreach
            $receita = "SELECT sum(valor) FROM transacoes WHERE tipo = 'Receita' AND data_transacao between ? AND ?";
            $statement = $this->conexao->prepare($receita);
            $statement->bindValue(1, $filtro['data-inicio']);
            $statement->bindValue(2, $filtro['data-fim']);
            // $statement->bindValue(3, $filtro['categoria']);
            $statement->execute(); //mesma coisa porem pra trazer a soma da receita
            $filterReceita = $statement->fetchColumn();
            if($filterReceita == NULL){
                $filterReceita = 0;
            }
            $despesa = "SELECT sum(valor) FROM transacoes WHERE tipo = 'Despesa' AND data_transacao between ? AND ? AND  categoria_id = ?";
            $statement = $this->conexao->prepare($despesa);
            $statement->bindValue(1, $filtro['data-inicio']);
            $statement->bindValue(2, $filtro['data-fim']);
            $statement->bindValue(3, $filtro['categoria']);
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
    }

    public function categorias()
    {
        $categorias = $this->getCategoria();
        require '../View/categorias.php';
    }

    public function getCategoria()
    {
        $select = "SELECT * FROM categorias";
        $statement = $this->conexao->query($select);
        $categorias = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $categorias;
    }

    public function deletarCategoria()
    {
        $id = $_GET['id'];

        $deleteTransacoes = "DELETE FROM transacoes WHERE categoria_id = ?";
        $statementTransacoes = $this->conexao->prepare($deleteTransacoes);
        $statementTransacoes->bindValue(1, $id);
        $statementTransacoes->execute();

        $deleteCategoria = "DELETE FROM categorias WHERE id_categoria = ?";
        $statementCategoria = $this->conexao->prepare($deleteCategoria);
        $statementCategoria->bindValue(1, $id);
        $statementCategoria->execute();

        header('Location: /dashboard');
    }


}