Sistema de Controle Financeiro
Este é um sistema de controle financeiro desenvolvido em PHP e MySQL. O projeto permite gerenciar transações, categorias, calcular receitas, despesas e saldo.

Requisitos
Antes de rodar o projeto, certifique-se de ter os seguintes softwares instalados em sua máquina:
PHP (versão 7.4 ou superior)
Composer (para gerenciamento de dependências)
MySQL (para o banco de dados)
Extensão PHP MySQL (para conexão com o banco de dados)
Instalação
Clonar o repositório

Clone este repositório em sua máquina local usando o seguinte comando:
git clone https://github.com/Zodklin/gh-controle-financeiro-desafio.git

Instalar dependências
Navegue até o diretório do projeto e execute o comando abaixo para instalar as dependências via Composer:
composer install

Configuração do banco de dados
Certifique-se de que o MySQL está rodando em sua máquina. Em seguida, crie um banco de dados no MySQL que será utilizado pela aplicação.
Após criar o banco, edite o arquivo src/ConexaoBD.php e altere as informações de conexão com o banco de dados para refletir suas configurações:
No arquivo src/ConexaoBD.php, configure:
host como 'localhost' (ou o endereço do servidor MySQL)
db como o nome do seu banco de dados
user como o seu usuário MySQL
pass como a sua senha do MySQL
Executar o projeto

Agora que todas as dependências estão instaladas e o banco de dados está configurado, você pode iniciar o servidor PHP embutido para rodar o projeto:
php -S localhost:8000 -t public
Abra o navegador e acesse http://localhost:8000 para visualizar o sistema.
Rodar migrações do banco de dados
Se necessário, crie as tabelas e estrutura do banco de dados de acordo com as definições usadas no projeto.

Funcionalidades:
Gerenciamento de transações financeiras (receitas e despesas)
Categorização de transações
Cálculo automático de saldo

Tecnologias Utilizadas:
PHP
MySQL
Composer (Autoload)
HTML, CSS

