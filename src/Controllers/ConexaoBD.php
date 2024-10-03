<?php

namespace App;

use PDO;
use PDOException;

class ConexaoBD
{
    public static function createConnection(): PDO
    {
        try {
            $connection = new PDO(
                "mysql:host=localhost;dbname=controle_despesas",
                'root',
                '@Zodklin2701'
            );
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $connection;
        } catch (PDOException $e) {
            die('Erro ao conectar com o banco de dados' . $e->getMessage());
        }

        return false;
    }

    // public function executeSelectOnBD(string $query, array $binds)
    // {
    //     $conexao = $this->createConnection();
    //     try {
    //         $select = $query;
    //         $statement = $conexao->prepare($select);
    //         foreach($binds as $index => $bind){
    //             $statement->bindParam($index, $bind);
    //         }
    //     }
    //     catch (PDOException $e){

    //     }
    // }
}