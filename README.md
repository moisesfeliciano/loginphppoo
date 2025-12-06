## Sistema de autenticação e gerenciamento de usuários em PHP orientado a objetos, implementando operações CRUD (Create, Read, Update, Delete) por meio de classes responsáveis por conexão, manipulação de dados e controle de fluxo. O sistema utiliza práticas de encapsulamento, reutilização de código e tratamento de exceções, além de aplicar hashing de senhas para segurança. A interface web é construída com HTML semântico, estilizada com CSS e aprimorada com componentes responsivos do Bootstrap.


## A estrutura 📂 de sistema de login se começa criando todos arquivos necessários:

## Cria-se uma pasta-raiz dentro do diretório do localhost, com o nome do projeto (loginphppoo).

```

/loginphppoo
│
├── assets/
│   ├── dist/
│   │   └── css/
│   │       ├── bootstrap.min.css  (Framework de estilo principal).
│   │       ├── custom.css         (Estilos personalizados globais).
│   │       └── sign.css           (Estilos específicos para a tela de login).
│   │
│   └── brand/
│       └── user.jpg             (Imagem usada na tela de login).
│
├── php/
│   └── Usuarios.php             (Classe principal com toda a lógica de back-end).
│
├── index.html                   (Página inicial de boas-vindas).
├── login.php                    (Página com o formulário de login).
├── pagina-protegida.php         (Menu principal após o login).
├── cadastrar.php                (Formulário para adicionar novos usuários).
├── lista-usuario.php            (Página que lista todos os usuários).
├── editar.php                   (Formulário para editar um usuário existente).
├── delete.php                   (Script que processa a exclusão de um usuário).
├── logout.php                   (Script que encerra a sessão do usuário).

```


## Pastas Principais:

* **assets/:** 
  * Esta pasta contém todos os recursos estáticos, como folhas de estilo (CSS), 
  * imagens e, potencialmente, JavaScript.

* **dist/css/:** 
  * Armazena os arquivos CSS. Você tem o bootstrap.min.css que é a base do design, 
  * o custom.css para suas personalizações e o sign.css para estilizar a página de login.

* **php/ É o coração do seu back-end:**

  * Usuarios.php: Este arquivo é uma classe PHP que gerencia todas as operações relacionadas 
  * aos usuários: conexão com o banco de dados, validação de login, proteção de páginas, cadastro, listagem, edição e exclusão de usuários.


## Arquivos na Raiz do Projeto:

* **index.html:** 
  * A primeira página que o usuário vê. É uma página de apresentação simples com um botão para acessar a área de login.
* **login.php:**
  * Contém o formulário para o usuário inserir suas credenciais (usuário e senha) e também inclui a lógica que chama o método login() da classe Usuarios.php para validar o acesso.
* **pagina-protegida:**
  * Uma página restrita que só pode ser acessada após o login. Ela funciona como um painel de controle ou menu principal, oferecendo opções como "Cadastrar Usuários" e "Listar Usuários". Ela usa o método protege() no início para garantir que apenas usuários logados possam vê-la.
* **cadstrar.php:**
  * Apresenta um formulário para registrar um novo usuário no sistema. Assim como a página protegida, ela também verifica se o usuário atual tem permissão para estar ali.
* **lista-usuario.php:**
  * Exibe uma tabela com todos os usuários cadastrados, oferecendo botões para "Editar" e "Excluir" cada um.
* **editar.php**
  * Um formulário pré-preenchido com os dados de um usuário específico, permitindo que suas informações sejam alteradas.
* **delete.php:**
  * Um script que não tem interface visual. Ele recebe o ID de um usuário e chama o método deleteUsuario() da classe Usuarios.php para removê-lo do banco de dados, redirecionando de volta para a lista.
* **logout.php:**
  * Outro script sem interface. Ele chama o método logout() para destruir a sessão do usuário atual e redireciona para a página de login.


## Banco de Dados:

  * O sistema depende de um banco de dados para funcionar:

  * Eu utilizo o phpMyAdmin como ferramenta de gerenciamento para trabalhar de forma prática e visual com bancos de dados. Através dele, consigo administrar minhas tabelas, realizar consultas, importar e exportar dados, além de acompanhar toda a estrutura do banco. Para o armazenamento e manipulação das informações, utilizo o MySQL, um sistema de gerenciamento de banco de dados robusto e amplamente usado no desenvolvimento de aplicações. A combinação do MySQL com o phpMyAdmin facilita o meu fluxo de trabalho e garante eficiência no gerenciamento dos dados.


  * Cria-se uma Database: `login_usuario`. 

  * Dentro do banco (Database) uma tabela com o nome: `usuarios`.

  ```
    CREATE TABLE `usuarios` (
    `id` int(11) NOT NULL,
    `nome` varchar(500) NOT NULL,
    `email` varchar(500) NOT NULL,
    `usuario` varchar(500) NOT NULL,
    `senha` varchar(500) NOT NULL,
    `tipo` enum('adm','user') NOT NULL
    );

  ```


## Finalidade da Tabela usuarios:

  * O objetivo principal desta tabela é guardar os dados de identificação e autenticação dos usuários.
  * É aqui que o sistema consulta para verificar se um login é válido e para determinar o que cada usuário pode fazer.


## Detalhe das Colunas e as função de cada coluna na tabela usuarios:

* **id (int(11) NOT NULL)**
  * É um identificador numérico único para cada usuário. Funciona como a "carteira de identidade" de cada registro, garantindo que não haja dois usuários iguais e permitindo que outras partes do sistema (como a tabela de tokens auth_tokens que será criada) se refiram a um usuário específico. É a chave primária da tabela.


* **nome (varchar(500) NOT NULL)**
  * Armazena o nome completo do usuário. É usado para personalização da interface, como exibir uma mensagem de "Bem-vindo, [Nome do Usuário]!".


* **email (varchar(500) NOT NULL)**
  * Guarda o endereço de e-mail do usuário. Além de ser uma forma de contato, em muitos sistemas modernos, o e-mail também pode ser usado como nome de usuário para o login.


* **usuario (varchar(500) NOT NULL)**
  * Este é o nome de login único que o usuário escolhe para acessar o sistema. É com este campo que o sistema faz a primeira verificação durante o processo de login.


* **senha (varchar(500) NOT NULL)**
  * Armazena a senha do usuário.
    * Segurança Crucial: É fundamental que a senha nunca seja guardada em texto puro.Esta coluna deve armazenar um "hash" seguro da senha, que é uma  versão criptografada e irreversível. Quando o usuário tenta fazer login, o sistema gera um hash da senha 
    digitada e o compara com o hash armazenado aqui.

* **tipo (enum('adm','user') NOT NULL)**
  * Define o nível de permissão ou o "papel" do usuário no sistema.
    * O tipo enum restringe os valores possíveis para 'adm' (administrador) ou 'user' (usuário comum).

    * 'adm': Um administrador geralmente tem acesso a todas as funcionalidades do sistema, como cadastrar novos usuários, editar perfis e visualizar todos os dados.

    * 'user': Um usuário comum tem permissões limitadas, podendo acessar apenas suas próprias informações e as áreas públicas do sistema.


  * Em resumo, esta tabela centraliza todas as informações necessárias para identificar, 
  autenticar e autorizar os usuários dentro da sua aplicação, sendo uma peça fundamental 
  para a segurança e o funcionamento do sistema de login.


* **Inserir na tabela (usuario) um administrador**

  * Senha: 123456

```
INSERT INTO `usuarios` (`id`, `nome`, `email`, `usuario`, `senha`, `tipo`) VALUES
(1, '(nome do usuario)', '(email do usuario)', '(login do usuario)', '$2y$10$PnZkKyVzc2jCl1fVU8hMfuxmDGySrXu49mmhlS.WGvPI8oRUHzhu6', 'adm');

```

## Adicionando os Arquivos na Raiz do Projeto:

  * index.html                    (vazio).
  * login.php                     (vazio).
  * pagina-protegida.php          (vazio).
  * cadastrar.php                 (vazio).
  * lista-usuario.php             (vazio).
  * editar.php                    (vazio).
  * delete.php                    (vazio).
  * logout.php                    (vazio).

## Nesse ponto a estrutura do sistema fica completa.


# O Coração do Sistema (Classe Usuarios.php).

# Esta classe é o coração do sistema de autenticação. Ela encapsula toda a lógica de negócio relacionada aos usuários: conexão com o banco de dados, login, logout, cadastro, listagem, atualização e exclusão.


```

class Usuarios
{

    private $table_name = "usuarios";

    
    protected $mysql;
    protected $db = array(
        'servidor'=>'localhost',
        'database'=>'blog_usuario',
        'usuario'=>'moises',
        'senha'=>'39138431',
    );
    

    public function __construct()
    {
        $this->conectaBd();
    }


    protected function conectaBd()
    {
        $this->mysql = new PDO(
            'mysql:host='.$this->db['servidor'].';dbname='.$this->db['database'], $this->db['usuario'], $this->db['senha']
        );
        $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

}

```

* **private $table_name = "usuarios";:** 
  * Declara uma propriedade privada chamada $table_name. Ela armazena o nome da tabela de usuários no banco de dados. Sendo private, só pode ser acessada de dentro desta mesma classe.

* **protected $mysql;:** 
    * Declara uma propriedade protegida que irá armazenar o objeto de conexão com 
  o banco de dados (PDO). Sendo protected, pode ser acessada por esta classe e por qualquer classe que a herde.

* **protected $db = array(...):** 
  * Declara uma propriedade protegida que é um array contendo as credenciais de acesso ao banco de dados. 



### É uma boa prática manter essas informações de configuração agrupadas.


* **public function __construct():** 
  * Este é o método construtor da classe. Ele é executado automaticamente
  sempre que um novo objeto Usuarios é criado (ex: $usuarios = new Usuarios();).
  * A expressão public function é usado em classes PHP para definir que um método ou propriedade pode ser acessado de qualquer lugar

* **$this->conectaBd();:** 
  * Dentro do construtor, ele chama o método conectaBd(), garantindo que a
  conexão com o banco de dados seja estabelecida assim que a classe for instanciada.


* **protected function conectaBd()**
  * Cria a instância do objeto PDO para se conectar ao banco de dados MySQL, usando as credenciais da propriedade $db.
  * A expressão protected function define um método protegido dentro de uma classe, é um modificador de visibilidade, que controla quem pode acessar o método

  * $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);: 
  Configura o PDO para lançar exceções em caso de erro, o que permite capturá-las com blocos try-catch.



## Usar PDO (PHP Data Objects) é considerado mais seguro sobretudo por causa da forma como ele trata consultas parametrizadas e da abstração que aplica ao acesso ao banco de dados.

  * Proteção contra SQL Injection 🔐

  * O principal ganho de segurança é que o PDO permite (e incentiva) o uso de prepared statements com bind parameters.

  * Isso separa dados de comandos SQL, impedindo que entradas maliciosas sejam interpretadas como instruções SQL.

* **Usar PDO é mais seguro porque:**

  * Garante tratamento seguro de parâmetros.

  * Protege contra problemas de encoding e concatenação.

  * Fornece API consistente e robusta.

  * Melhora tratamento de erros e transações.


## Criando página de boas-vindas "index.html":

** *Estrutura HTML bem organizada**

```
  <!doctype html>

  <html lang="pt-br">

  <meta charset="utf-8">

  <meta name="viewport">

```

  * Isso garante compatibilidade, acessibilidade e responsividade.

  * Uso de Bootstrap

  * A inclusão do Bootstrap melhora a responsividade e rapidez no desenvolvimento da interface.

  * Texto explicativo claro

  * O texto dentro do container apresenta bem a proposta do sistema.

