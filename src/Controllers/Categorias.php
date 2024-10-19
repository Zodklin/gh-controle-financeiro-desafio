<?php 

namespace App\Controllers;

use App\Model\ConexaoBD;
use PDOException;

class Categorias
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::createConnection();
    }

    public function getCategorias()
    {
        $idUser = $_SESSION['user'];

        $select = "SELECT * FROM categorias WHERE usuario_id = $idUser";
        $statement = $this->conexao->query($select);
        $categorias = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $categorias;
    }

    public function getCategoriasPadrao()
    {
        $select = "SELECT * FROM categorias WHERE categoria_padrao = 'SIM'";
        $statement = $this->conexao->query($select);
        $categoriasPadrao = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $categoriasPadrao;
    }

        public function listarCategorias()
    {
        try{
            if(isset($_SESSION['name'])){
                $categorias = $this->getCategorias();
                $categoriasPadrao = $this->getCategoriasPadrao();
                require '../View/categorias.php';
            } else {
                die(header("Location: /login"));
            }
        } catch(PDOException $e){
            $_SESSION['msgErro'] = "Ocorreu um erro ao listar as categorias: " . $e->getMessage();
            header('Location: /dashboard');
        }

    }

    public function criarCategoria()
    {
        if(isset($_SESSION['name'])){
            require '../View/formularioCategoria.php';
            } else {
                die(header("Location: /login"));
            }

    }

    public function adicionarCategoria()
    {
        try{
            $nomeCategoria = $_POST['editar-categoria'];
            $idUser = $_SESSION['user'];
    
            $adicionarCategoria = "INSERT INTO categorias (nome_Categoria, usuario_id)  VALUES (?,?)";
            $statement = $this->conexao->prepare($adicionarCategoria);
            $statement->bindValue(1, $nomeCategoria);
            $statement->bindValue(2, $idUser);
            $statement->execute();
    
            header('Location: /categorias');
        } catch (PDOException $e){
            $_SESSION['msgErro'] = "Ocorreu um erro ao adicionar uma nova categoria: " . $e->getMessage();
            header('Location: /categorias');
        }
    }

    public function deletarCategoria()
    {
        try{
            $id = $_GET['id'];
            $idUser = $_SESSION['user'];
    
            $deleteTransacoes = "DELETE FROM transacoes WHERE categoria_id = ? AND usuario_id = ?";
            $statement = $this->conexao->prepare($deleteTransacoes);
            $statement->bindValue(1, $id);
            $statement->bindValue(2, $idUser);
            $statement->execute();
    
            $deleteCategoria = "DELETE FROM categorias WHERE id_categoria = ? AND usuario_id = ?";
            $statement = $this->conexao->prepare($deleteCategoria);
            $statement->bindValue(1, $id);
            $statement->bindValue(2, $idUser);
            $statement->execute();
    
            header('Location: /categorias');
        } catch (PDOException $e){
            $_SESSION['msgErro'] = "Ocorreu um erro deletar a categoria: " . $e->getMessage();
            header('Location: /categorias');
        }

    }

    public function getCategoriaById()
    {
        if(isset($_SESSION['name'])){
            $id = $_GET['id'];
            $idUser = $_SESSION['user'];
    
            $select = "SELECT * FROM categorias WHERE id_categoria = $id AND usuario_id = $idUser";
            $statement = $this->conexao->query($select);
            $categoria = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $categoriaSelecionada = $categoria[0];
            
            require '../View/formularioCategoria.php';
            } else {
                die(header("Location: /login"));
            }



    }

    public function atualizarCategoria()
    {
        try{
            $id = $_GET['id'];
            $nomeCategoria = $_POST['editar-categoria'];
            $idUser = $_SESSION['user'];
    
            $updateCategoria = "UPDATE categorias SET nome_categoria = ? WHERE id_categoria = ? and usuario_id = ?";
            $statement = $this->conexao->prepare($updateCategoria);
            $statement->bindValue(1, $nomeCategoria);
            $statement->bindValue(2, $id);
            $statement->bindValue(3, $idUser);
            $statement->execute();
    
            header('Location: /categorias');
        }catch (PDOException $e){
            $_SESSION['msgErro'] = "Ocorreu um erro atualizar a categoria: " . $e->getMessage();
            header('Location: /categorias');
        }
    }

}

