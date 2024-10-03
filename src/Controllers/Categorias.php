<?php 

namespace App;

class Categorias
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::createConnection(); //faz a conexão com o banco
    }

    public function getCategorias()
    {
        $select = "SELECT * FROM categorias";
        $statement = $this->conexao->query($select);
        $categorias = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $categorias;
    }

        public function listarCategorias()
    {
        $categorias = $this->getCategorias();
        require '../View/categorias.php';
    }

    public function criarCategoria()
    {
        require '../View/formularioCategoria.php';
    }

    public function adicionarCategoria()
    {
        $nomeCategoria = $_POST['editar-categoria'];

        $adicionarCategoria = "INSERT INTO categorias (nome_Categoria) VALUES (?)";
        $statement = $this->conexao->prepare($adicionarCategoria);
        $statement->bindValue(1, $nomeCategoria);
        $statement->execute();

        header('Location: /categorias');
    }

    public function deletarCategoria()
    {
        $id = $_GET['id'];

        $deleteTransacoes = "DELETE FROM transacoes WHERE categoria_id = ?";
        $statement = $this->conexao->prepare($deleteTransacoes);
        $statement->bindValue(1, $id);
        $statement->execute();

        $deleteCategoria = "DELETE FROM categorias WHERE id_categoria = ?";
        $statement = $this->conexao->prepare($deleteCategoria);
        $statement->bindValue(1, $id);
        $statement->execute();

        header('Location: /categorias');
    }

    public function getCategoriaById()
    {
        $id = $_GET['id'];

        $select = "SELECT * FROM categorias WHERE id_categoria = $id";
        $statement = $this->conexao->query($select);
        $categoria = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $categoriaSelecionada = $categoria[0];
        
        require '../View/formularioCategoria.php';
    }

    public function atualizarCategoria()
    {
        $id = $_GET['id'];
        $nomeCategoria = $_POST['editar-categoria'];

        $updateCategoria = "UPDATE categorias SET nome_categoria = ? WHERE id_categoria = ?";
        $statement = $this->conexao->prepare($updateCategoria);
        $statement->bindValue(1, $nomeCategoria);
        $statement->bindValue(2, $id);
        $statement->execute();

        header('Location: /categorias');
    }

}

