<?php
class Expense
{
    public function list()
    {
        // Faço a conexão com o banco, mas tem que melhorar pra nao precisar ficar chamando em todos os metodos
        $pdo = new \PDO('mysql:host=localhost;dbname=controle_despesas', 'root', '@Zodklin2701');
        // Passo a query pra variavel
        $select = "SELECT
                    *
                FROM
                    transacoes";
        //Chamo o statment passando a conexao com o banco e chamando a query que fiz 
        $statement = $pdo->query($select);
        //passo um array associativo para transictions do resultado da query
        $transictions = $statement->fetchAll(\PDO::FETCH_ASSOC);

    }
    
    

    public function create() 
    {
        //Chamar o formulario de criação
    }

    public function save()
    {
        //Pego os dados do formulario e passo para uma variavel 
        $dados = $_POST;
        $pdo = new \PDO('mysql:host=localhost;dbname=controle_despesas', 'root', '@Zodklin2701');
        $insert = "INSERT INTO transacoes (tipo, descricao, valor, data_transacao, categoria_id) VALUES (?,?,?,?,?)";
        $statement = $pdo->prepare($insert);
        //preciso corrigir os values conforme o que receber no post (front ainda nao esta pronto)
        $statement->bindValue(1, "teste");
        $statement->bindValue(2, "teste2");
        $statement->bindValue(3, 123.30);
        $statement->bindValue(4, "24-09-03");
        $statement->bindValue(5, "2");
        $statement->execute();
    }

    public function edit()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=controle_despesas', 'root', '@Zodklin2701');
        //implementar função ao clicar no botão editar
    }
    
    public function update()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=controle_despesas', 'root', '@Zodklin2701');
        //implementar função ao clicar no botão de atualizar
    }

    public function delete()
    {
        $id = $_GET['id'];
        $pdo = new \PDO('mysql:host=localhost;dbname=controle_despesas', 'root', '@Zodklin2701');
        $delete = "DELETE FROM transacoes WHERE id_transacao = ?";
        $statement = $pdo->prepare($delete);
        $statement->bindValue(1, $id);
        $statement->execute();
    }

    public function getReceita(){
        $pdo = new \PDO('mysql:host=localhost;dbname=controle_despesas', 'root', '@Zodklin2701');
        $getReceita = "SELECT SUM(VALOR) FROM TRANSACOES WHERE TIPO = 'receita'";
        $statement = $pdo->query($getReceita);
        $receita = $statement->fetchColumn();
        return $receita;
    }

    public function getSaldo(){
        $pdo = new \PDO('mysql:host=localhost;dbname=controle_despesas', 'root', '@Zodklin2701');
        $getSaldo = "SELECT DISTINCT
    (SELECT SUM(valor) FROM transacoes WHERE tipo = 'receita') - 
    (SELECT SUM(valor) FROM transacoes WHERE tipo = 'despesa') AS saldo_final
from
	transacoes";
    $statement = $pdo->query($getSaldo);
    $saldo = $statement->fetchColumn();
    return $saldo;
    }

    public function getDespesa(){
        $pdo = new \PDO('mysql:host=localhost;dbname=controle_despesas', 'root', '@Zodklin2701');
        $getDespesa = "SELECT
                            sum(valor)
                        FROM
                            transacoes
                        WHERE
                            tipo = 'despesa'";
        $statement = $pdo->query($getDespesa);
        $despesa = $statement->fetchColumn();
        return $despesa;
    }

    public function getTransactions(){
        $saldo = $this->getSaldo();
        $receita = $this->getReceita();
        $despesa = $this->getDespesa();
        require '../View/home.php'; 
    }

}