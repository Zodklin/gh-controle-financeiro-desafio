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
                $_SESSION['mensagem'] = 'Preencha seu email!';
                header('Location: /login');;
            } else if(strlen($credenciais['senha']) == NULL){
                $_SESSION['mensagem'] = 'Preencha sua senha!';
                header('Location: /login');
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
                    $_SESSION['mensagem'] = 'Falha ao logar, email ou senha incorretos!';
                    header('Location: /login');
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
            $_SESSION['mensagem'] = 'Email já em uso.';
            header('Location: /login');
            exit;
        }else {
            $salvar = "INSERT INTO usuario (email, nome, senha) values (?,?,?)";
            $statement = $this->conexao->prepare($salvar);
            $statement->bindValue(1, $dados['email']);
            $statement->bindValue(2, $dados['nome']);
            $statement->bindValue(3, $dados['senha']);
            $statement->execute();
            
            $_SESSION['mensagem'] = 'Usuário criado com sucesso!';
            header('Location: /login');
            exit;
        }
        
    }
}