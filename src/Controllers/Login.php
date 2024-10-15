<?php 

namespace App;

class Usuario
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::createConnection(); //faz a conexão com o banco
    }

    public function login()
    {
        require '../View/login.php';
    }

    public function logar()
    {
        $credenciais = $_POST;
        if (isset($credenciais['email']) || isset($credenciais['senha'])) {

            if(strlen($credenciais['email']) == NULL) {
                echo "Preencha seu email";
            } else if(strlen($credenciais['senha']) == NULL){
                echo "Preencha sua senha";
            } else {
                $verificarLogin = "SELECT nome, id_usuario FROM usuario WHERE email = ? AND senha = ?";
                $statement = $this->conexao->prepare($verificarLogin);
                $statement->bindValue(1, $credenciais['email']);
                $statement->bindValue(2, $credenciais['senha']);
                $statement->execute();
                $usuario = $statement->fetchAll(\PDO::FETCH_ASSOC);
                if($usuario != NULL){
                    if(!isset($_SESSION)){
                        session_start();
                    }
                    $_SESSION['user'] = $usuario[0]['id_usuario'];
                    $_SESSION['name'] = $usuario[0]['nome'];
                    header("Location: /dashboard");
                }else {
                    echo "Falha ao logar, e-mail ou senha incorretos!";
                }
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
    }

    public function criarConta()
    {
        require '../view/criarConta.php';
    }

    public function salvarConta()
    {
        $dados = $_POST;
        $email = $dados['email'];

        $verificarUsuario = "SELECT email FROM usuario WHERE email = ?";
        $statement = $this->conexao->prepare($verificarUsuario);
        $statement->bindValue(1, $email);
        $statement->execute();
        $usuarioExiste = $statement->fetchColumn();

        if($usuarioExiste == $dados['email']){
            echo "Email já em uso.";
        }else {
            $salvar = "INSERT INTO usuario (email, nome, senha) values (?,?,?)";
            $statement = $this->conexao->prepare($salvar);
            $statement->bindValue(1, $dados['email']);
            $statement->bindValue(2, $dados['nome']);
            $statement->bindValue(3, $dados['senha']);
            $statement->execute();
            echo "Usuario criado com sucesso!";
        }
        
    }
}