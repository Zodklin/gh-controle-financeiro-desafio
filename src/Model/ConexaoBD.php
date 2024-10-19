<?php

namespace App\Model;

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
            die('Erro ao conectar com o banco de dados: ' . $e->getMessage());
        }

        return false;
    }
}

class Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = ConexaoBD::createConnection();
        if ($this->pdo) {
            $this->criarTabelas();
        }
    }

    private function criarTabelas()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS usuario (
                id_usuario INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL UNIQUE,
                senha VARCHAR(32) NOT NULL,
                nome VARCHAR(255) NOT NULL
            );

            INSERT IGNORE INTO usuario (email, senha, nome) VALUES ('admin', 'admin', 'admin');

            CREATE TABLE IF NOT EXISTS categorias (
                id_categoria INT AUTO_INCREMENT PRIMARY KEY,
                nome_categoria VARCHAR(255) NOT NULL,
                usuario_id INT,
                categoria_padrao VARCHAR(3),
                FOREIGN KEY (usuario_id) REFERENCES usuario(id_usuario)
                    ON DELETE SET NULL
                    ON UPDATE CASCADE,
                CONSTRAINT unique_categoria_usuario UNIQUE (nome_categoria, usuario_id)
            );

            INSERT IGNORE INTO categorias (nome_categoria, categoria_padrao, usuario_id)
            VALUES ('Alimentação' , 'SIM', 1), ('Transporte', 'SIM', 1), ('Lazer', 'SIM', 1), ('Receita', 'SIM', 1);
            
            CREATE TABLE IF NOT EXISTS transacoes (
                id_transacao INT AUTO_INCREMENT PRIMARY KEY,
                tipo ENUM('Receita', 'Despesa') NOT NULL,
                descricao VARCHAR(255) NOT NULL,
                valor DECIMAL(10, 2) NOT NULL,
                data_transacao DATE NOT NULL,
                categoria_id INT,
                usuario_id INT,
                FOREIGN KEY (categoria_id) REFERENCES categorias(id_categoria)
                    ON DELETE SET NULL
                    ON UPDATE CASCADE,
                FOREIGN KEY (usuario_id) REFERENCES usuario(id_usuario)
                    ON DELETE SET NULL
                    ON UPDATE CASCADE
            );
        ";

        try {
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            echo 'Erro ao criar as tabelas: ' . $e->getMessage();
        }
    }
}

try {
    $db = new Database();
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
