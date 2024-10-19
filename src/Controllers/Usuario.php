<?php 

namespace App\Controllers;
use App\Model\ConexaoBD;
use PDOException;

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
        try{
            $email = $_POST['email'];
            $senha = md5($_POST['senha']);
            if (isset($email) || isset($senha)) {
    
                if(strlen($email) == NULL) {
                    $_SESSION['mensagem'] = 'Preencha seu email!';
                    header('Location: /login');;
                } else if(strlen($senha) == NULL){
                    $_SESSION['mensagem'] = 'Preencha sua senha!';
                    header('Location: /login');
                } else {
                    $verificarLogin = "SELECT nome, id_usuario FROM usuario WHERE email = ? AND senha = ?";
                    $statement = $this->conexao->prepare($verificarLogin);
                    $statement->bindValue(1, $email);
                    $statement->bindValue(2, $senha);
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
        } catch (PDOException $e){
            $_SESSION['msgErro'] = "Ocorreu um erro ao logar: " . $e->getMessage();
            header('Location: /login');
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

        try{
            $dados = $_POST;
            $email = $dados['email'];
            $senha = md5($dados['senha']);
    
            $verificarUsuario = "SELECT email FROM usuario WHERE email = ?";
            $statement = $this->conexao->prepare($verificarUsuario);
            $statement->bindValue(1, $email);
            $statement->execute();
            $usuarioExiste = $statement->fetchColumn();
            
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                if($usuarioExiste == $dados['email']){
                    $_SESSION['mensagem'] = 'Email já em uso.';
                    header('Location: /login');
                    exit;
                }elseif(strlen($dados['email']) == NULL || (strlen($dados['email'])) < 4) {
                    $_SESSION['mensagem'] = 'Email invalido';
                    header('Location: /login');
                }elseif(strlen($dados['nome']) == NULL || (strlen($dados['nome'])) < 2){
                    $_SESSION['mensagem'] = 'Seu nome precisa ter pelo menos 3 caracteres';
                    header('Location: /login');
                }elseif(strlen($dados['senha']) == NULL || (strlen($dados['senha'])) < 4){
                    $_SESSION['mensagem'] = 'Sua senha precisa ter ao menos 5 digitos';
                    header('Location: /login');
                }else{
                    $salvar = "INSERT INTO usuario (email, nome, senha) values (?,?,?)";
                    $statement = $this->conexao->prepare($salvar);
                    $statement->bindValue(1, $dados['email']);
                    $statement->bindValue(2, $dados['nome']);
                    $statement->bindValue(3, $senha);
                    $statement->execute();
                    
                    $_SESSION['mensagem'] = 'Usuário criado com sucesso!';
                    header('Location: /login');
                    exit;
                }
            } else {
                $_SESSION['mensagem'] = 'Por favor, insira um email valido';
                    header('Location: /login');
                    exit;
            }
        } catch (PDOException $e){
            $_SESSION['mensagem'] = "Ocorreu um erro ao criar conta: " . $e->getMessage();
            header('Location: /login');
        }    
    }
}