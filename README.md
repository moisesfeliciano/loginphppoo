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


## Criando a página de login: login.php

  * Arquivo login.php com o formulário HTML (campos: usuário, senha e o checkbox "Lembrar de mim").

## Criando método login() que realiza o lOgin do sistema.

* **public function login()** 
  * Define o método login como público, o que significa que ele pode ser chamado de 
  fora da classe.

* **$_SESSIOM**
  * Inicia uma sessão PHP ou recupera uma já existente, permitindo o uso da variável global $_SESSION 
  para armazenar e acessar dados do usuário durante a navegação.

* **session_start();** 
  * Esta é a primeira e mais importante etapa para trabalhar com sessões. Esta função 
  verifica se já existe uma sessão para o usuário; se houver, ela a retoma. Se não, ela inicia uma nova 
  sessão. Isso é essencial para que possamos armazenar o estado de "logado" do usuário.

* **if ($_SERVER['REQUEST_METHOD']=='POST')** 
  * O código dentro deste if só é executado quando a página recebe dados
  de um formulário enviado com method="post".
  Isso separa a lógica de processamento de login da simples exibição da página.
  indicando que dados estão sendo enviados pelo formulário de login.

* **$usuario=$this->retUsuario($_POST['usuario']);**
  * Aqui, o sistema pega o nome de usuário enviado pelo formulário ($_POST['usuario']) 
  e usa o método auxiliar retUsuario() para buscar no banco de dados o registro completo daquele usuário. 
  O resultado (um array com os dados do usuário ou false se não for encontrado) é armazenado na variável $usuario.


* **if (password_verify($_POST['senha'], $usuario['senha']))**
  * Esta é a maneira correta e segura de verificar uma senha em PHP. 
  A função password_verify() compara a senha em texto plano enviada pelo formulário ($_POST['senha']) com o hash 
  seguro armazenado no banco de dados ($usuario['senha']).
  Ela é projetada para ser resistente a ataques de tempo.


* **if (password_needs_rehash(...))**
  * Uma excelente prática de segurança, esta função verifica se o hash da senha no 
  banco de dados foi criado com um algoritmo ou "custo" que não é mais o padrão (PASSWORD_DEFAULT). Se for o caso 
  (por exemplo, se você aumentar o custo do hash no futuro), o sistema automaticamente gera um novo hash mais 
  forte ($this->hash(...)) e o atualiza no banco de dados ($this->atualizarSenha(...)). Isso melhora a segurança 
  do sistema ao longo do tempo, de forma transparente para o usuário.

* **$_SESSION["usuario"] = $usuario;**
  * Se a senha estiver correta, esta linha é a que efetivamente "loga" o 
  usuário. Ela armazena todo o array de dados do usuário na sessão, tornando-o acessível em outras páginas protegidas.

* **if (isset($_POST['lembrar']))**
  * Verifica se a caixa "Lembrar de mim" foi marcada no formulário.

* **$this->gerarEArmazenarTokens($usuario['id']);** 
  * Se a caixa foi marcada, este método é chamado para criar e armazenar os tokens seguros no banco de dados 
  e nos cookies do navegador, implementando a funcionalidade "Lembrar de mim" de forma segura.

* **elseif (crypt(...))** 
  * Este bloco serve como uma camada de compatibilidade para um método de hash mais antigo
  e menos seguro (crypt). Se o password_verify falhar, ele tenta verificar a senha com este método legado.
  * Se a verificação com crypt for bem-sucedida, ele imediatamente atualiza a senha para o novo formato seguro
  com password_hash e então loga o usuário. Esta é uma estratégia de migração perfeita.

* **else { ... }**
  * Se nenhuma das verificações de senha (password_verify ou crypt) passar, significa 
  que a senha está incorreta. O código então redireciona o usuário de volta para login.php, passando uma 
  mensagem de erro pela URL (?msg=...).

* **elseif (empty($_SESSION["usuario"]) && !empty($_COOKIE[...]))** 
  * Este bloco é executado se o usuário não enviou um formulário de login e não está logado na sessão, 
  mas possui os cookies remember_selector e remember_validator.

* **$usuario = $this->validarTokenEAutenticar(...)** 
* Ele chama o método que valida os tokens do cookie contra o banco de dados. 
  Se a validação for bem-sucedida, o método retorna os dados do usuário.

* **if ($usuario) { $_SESSION["usuario"] = $usuario; }**
  * Se a validação do token retornou um usuário válido, ele é logado na sessão, completando a autenticação automática.


* **if (!empty($_SESSION["usuario"]))** 
  * Após a execução dos blocos anteriores, este if final verifica se o usuário está, 
  de fato, logado (ou seja, se $_SESSION["usuario"] foi preenchido).

* **if (empty($_SESSION["url"]))** 
  * Verifica se o usuário autenticado está salvo na sessão.
  Ele verifica se existe uma URL de destino armazenada na sessão.
  Essa URL é geralmente definida pelo método protege() quando um usuário não logado tenta acessar uma página restrita.
  Se não houver uma URL de destino, ele redireciona para a página principal (index.html).
  Se houver uma URL de destino, ele redireciona o usuário de volta para a página que ele tentou acessar originalmente. 
  Isso proporciona uma experiência de usuário muito mais fluida.



* **public function cadastrar()**

# Método para cadastrar um novo usuário

* **if ($_SERVER['REQUEST_METHOD']=='POST')**
  * Garante que o código de cadastro só rode quando o formulário de cadastro for enviado.

* **$sql="INSERT INTO ...";** 
  * Monta a query SQL para inserir um novo usuário.

* **$mysql->bindValue(...)**
  * Associa os dados do formulário ($_POST) aos parâmetros da query de forma segura.

* **$mysql->bindValue(':senha', $this->hash($_POST['senha']), ...)** 
  * Crucial para a segurança, ele não salva a senha diretamente, mas sim o hash dela, gerado pelo método hash().

* **header('Location: lista-usuario.php');** 
* Após o cadastro, redireciona para lista-usuario.php.



## Criando o método protege() na classe Usuarios

  * Ele verifica se $_SESSION["usuario"] existe e, se não existir, redireciona para login.php.



## Adicionando código na pagina-protegida.php

* **require 'php/Usuarios.php';**
  * Importa o arquivo Usuarios.php, localizado dentro da pasta php.

* **$usuarios->protege();**
  * Chama o método protege() do objeto $usuarios.

* **$usuarios = new Usuarios();**
  * Cria um objeto da classe Usuarios.

* **$usuarios->protege();**
  * Bloquear acesso a páginas protegidas.


### Nessa paǵina é onde fica o Menu principal que dá acesso as outras paginas:

  * Botão para cadastrar um novo usuário.
  * Botão para listar todos os usuários cadastrados.
  * Botão para acessar o painel financeiro.



## Criando o método logout()

  * **public function logout()** 
  * Método para fazer o logout do sistema de forma segura

* **session_start()** 
  * Esta função verifica se já existe uma sessão para o usuário e, se houver, a carrega. 
  É um passo necessário para que o PHP possa manipular os dados da sessão que está prestes a ser encerrada.

* **session_unset();** 
  * Libera (remove) todas as variáveis que foram registradas na sessão atual. Por exemplo, a variável $_SESSION["usuario"], 
  que armazena os dados do usuário logado, é apagada da memória.

* **session_destroy();** 
  * Este é o passo final para encerrar a sessão no lado do servidor. Ele destrói todos os dados associados ao ID da sessão atual. 
  Após esta chamada, o usuário não está mais autenticado no servidor.

* **$this->limparTokensAoLogout();**
  * responsável por remover os cookies remember_selector e remember_validator do navegador do usuário e apagar o token
  correspondente do banco de dados. Isso garante que a funcionalidade "Lembrar de mim" seja desativada, impedindo 
  um login automático na próxima visita.

* **header('Location: index.html');** 
  * Envia um cabeçalho HTTP para o navegador do usuário, instruindo-o a redirecionar para a página index.html. É assim que o 
  usuário é levado para a página inicial após o logout ser processado.


* **exit();**
  * Termina a execução do script PHP imediatamente. É uma prática de segurança crucial usar exit() após um 
  redirecionamento com header(). Isso impede que qualquer código restante na página seja executado 
  acidentalmente, garantindo que o redirecionamento ocorra sem interferências.






## Criando o método listarUsuarios() e adicionando código no arquivo lista-usuario.php

* **public function listarUsuarios()** 
  * método que lista os usuários cadastrados no sistema

* **$sql = "SELECT * FROM " . $this->table_name;** 
  * Monta a string da consulta SQL para selecionar todos (*) os registros da tabela de usuários.

* **$stmt = $this->mysql->prepare($sql);** 
  * Prepara a consulta SQL para execução. Usar prepare é uma prática
  recomendada para evitar ataques e segurança essencial para prevenir injeção de SQL.

* **$stmt->execute();** 
  * Executa a consulta preparada.

* **return $stmt->fetchAll(PDO::FETCH_ASSOC);** 
  * Busca todos os resultados da consulta e os retorna como um array associativo, onde as chaves
  do array são os nomes das colunas da tabela.


## Implementando o método retUsuario() na classe Usuarios

  * Método auxiliar para buscar e retornar os dados de um usuário a 
  partir do seu nome de usuario. É usado principalmente no processo de login.




## Apartir desse ponto já é possível fazer o login

  * Ter acesso ao Menu Principal do sistema, com os botões de Cadastrar, Listar Usuários, acessar o Painel Financeiro e Sair.
  * Se clicar no botão Cadastrar você terá acesso ao formulário de cadastro de usuário.
  * Se clicar no botão Litar Usuários você terá acesso a lista de usuarios do sistema.




## Implementando o método hashSenha() na classe Usuarios

* **Método hash($senha)**
  * Centraliza a lógica de hashing de senha. 
  Usa a função password_hash do PHP, que é a maneira recomendada e mais segura de criar hashes de senha.
  PASSWORD_DEFAULT garante que o PHP sempre usará o algoritmo de hash mais forte disponível.




## Inserindo formulário de edição de usuarios no arquivo editar.php

* **($_SERVER['REQUEST_METHOD'] === 'POST')**
  * Processa o formulário quando enviado.

* **$resultado = $usuarios->atualizar($id, $nome, $email, $usuario, $tipo, $senha);**
  * Atualiza o usuário pelo método atualizar().

* **if ($resultado) {**
  * Se $resultado for True recebe mensagem de Atualizado com sucesso!
  * Se $resultado for false recebe mensagem de Não Atualizado!

* **(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)**
  * Recebendo e validando ID.

* **$usuario = $usuarios->buscarPorId($id);**
  * busca no banco de dados o usuário pelo ID pelo método buscarPorId($id) para preencher
  o formulário com os dados do usuário que vai ser editado.





## Implementando método buscarPorId($id) na classe Usuarios

* **public function buscarPorId($id)** 
  * método que um usuário pelo seu ID

* **$sql = "SELECT * FROM " . $this->table_name;** 
  * Monta a string da consulta SQL para selecionar todos (*) os registros da tabela de usuários.

* **$stmt = $this->mysql->prepare($sql);** 
  * Prepara a consulta SQL para execução. Usar prepare é uma prática
  recomendada para evitar ataques de injeção de SQL.

* **$stmt->bindValue(':id', $id, PDO::PARAM_INT);**
  * segurança essencial para prevenir injeção de SQL.

* **$stmt->execute();** 
  * Executa a consulta preparada.

* **return $stmt->fetchAll(PDO::FETCH_ASSOC);**
  * Busca todos os resultados da consulta e os retorna como
  um array associativo, onde as chaves do array são os nomes das colunas da tabela.




## Implementando método atualizar() na classe Usuarios

* **public function atualizar(..., $senha = null)** 
  * Define o método para atualizar um usuário. O 
  parâmetro $senha é opcional; se não for fornecido, seu valor será null.

* **try { ... } catch (PDOException $e) { ... }** 
  * Usa um bloco try-catch para tratamento de erros. Se  algo der errado com a consulta ao banco, 
  o código dentro do catch será executado.

* **if ($senha)** 
  * Verifica se uma nova senha foi fornecida.
  Se $senha existir, a query SQL UPDATE incluirá o campo senha. O valor da senha é processado pelo método $this->hash($senha) antes de ser salvo.
  Se $senha for null, a query UPDATE não incluirá o campo senha, preservando a senha atual do usuário.

* **$stmt->bindValue(...)** 
  * Associa os valores das variáveis aos marcadores na consulta SQL, de forma segura.

* **return $stmt->execute();** 
  * Executa a atualização e retorna true se for bem-sucedida ou false caso contrário.

* **error_log(...)** 
  * No bloco catch, registra o erro detalhado no log de erros do servidor, uma prática muito 
  melhor do que exibir o erro para o usuário.


## Adicionando coluna "USUÁRIO" na tabela Lista Usuário do arquivo lista-usuario.php.



## Adicionando código no arquivo logout.php que simplismente chama o método logout() da classe Usuarios.




## Adicionando método deleteUsuario($id) na classe Usuarios

  * Executa uma operação DELETE para remover um usuário do banco de dados com base no id fornecido, 
    usando um prepared statement para segurança.


* **Bloco ' try '**
  * O código dentro deste bloco será executado. Se ocorrer um erro (uma "exceção") relacionado ao banco de dados (PDOException), a execução salta imediatamente para o bloco 'catch'. Isso previne que o script quebre inesperadamente e permite um tratamento de erro elegante.

  * A função JavaScript confirmaExclusao() em lista-usuario.php para uma melhor experiência do usuário.

* **Bloco ' catch '**
  * Este bloco é executado para capturar exceções do PDO.
  * Este bloco só é executado se um erro do tipo PDOException ocorrer no bloco 'try' (por exemplo, falha de conexão, erro de sintaxe SQL, etc.). A variável $e conterá um objeto com os detalhes do erro.


  

## Adicionando código no arquivo delete.php

* **if (isset($_GET['id']))**
  * Verifica se um parâmetro chamado 'id' foi enviado na URL via método GET.

* **$usuarios->deleteUsuario($_GET['id']);**
  * Chama o método deleteUsuario(), Se o 'id' exixtir deleta o usuário.

* **header('Location: lista-usuario.php');**
  * Redireciona o usuário


## Protegendo partes do layout para que apenas usuários específicos tenham acesso:


### proteger áreas sensíveis (como o Painel Financeiro, botões de editar e excluir) para que apenas o Administrador tenha controle total, deixando a interface do Usuário Comum muito mais segura e limpa.

### Originalmente, as opções de Cadastro, Listagem, Painel Financeiro, Editar e Excluir usuaŕios, apareciam para todos os níveis de acesso.




> Para resolver isso no PHP, utilizamos uma estrutura de controle condicional diretamente no HTML. Olhe este bloco de código:

```
<?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] == 'adm'): ?>
    
<?php endif; ?>

```

### Explicação Passo a Passo, vamos entender o que está acontecendo aqui:

* **isset($_SESSION['usuario']):**
  * Primeiro, verificamos se existe uma sessão ativa. Isso evita erros caso o usuário nem tenha feito login.

* **&&:**
  * Este é o operador '&', Ele garante que as duas condições sejam verdadeiras ao mesmo tempo.

* **$_SESSION['usuario']['tipo'] == 'adm':**
  * Aqui está o filtro real, o PHP olha dentro dos dados do usuário logado e verifica se o 'tipo' dele é exatamente 'adm'.

* **Os dois pontos (:) e o endif;:**
  * Essa é a sintaxe alternativa do PHP, perfeita para organizar o código quando misturamos lógica com tags HTML, deixando tudo mais limpo e legível."


> Para implementar essa restrição, será preciso colocar essa estrutura de controle condicional diretamente no código HTML da página do Menu Usuários:


```PHP

      <div class="row align-items-md-stretch">
        <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] == 'adm'): ?>

          <div class="col-md-4">
            <div class="h-100 p-5 text-bg-success rounded-3">
              <h2>Cadastro Usuários</h2>
              <hr>
              <br>
              <p>Clique no botão abaixo para cadastrar um novo usuário.</p>
              <button class="btn btn-light" type="button"><a href="cadastrar.php">Cadastrar</a></button>
            </div>
          </div>

        <?php endif; ?>

          <div class="col-md-4">
            <div class="h-100 p-5 text-bg-primary border rounded-3">
              <h2>Listar Usuários</h2>
              <hr>
              <br>
              <p>Clique no botão abaixo para listar todos os usuários cadastrados.</p>
              <button class="btn btn-light" type="button"><a href="lista-usuario.php">Listar Usuários</a></button>
            </div>
          </div>

        <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] == 'adm'): ?>

          <div class="col-md-4">
            <div class="h-100 p-5 text-bg-dark border rounded-3">
              <h2>Painel Financeiro</h2>
              <hr>
              <br>
              <p>Clique no botão abaixo para acessar o painel financeiro.</p>
              <button class="btn btn-light" type="button">Acessar</button>
            </div>
          </div>

        <?php endif; ?>

        </div>
        <footer class="pt-3 mt-4 text-muted border-top">

```



> Também será preciso colocar a mesma estrutura de controle condicional diretamente no código HTML da página com a lista de Usuários:

```PHP
          <tr>
            <th scope="col">NOME</th>
            <th scope="col">USUÁRIO</th>
            <th scope="col">EMAIL</th>
            <th scope="col">TIPO</th>
          </tr>
		  <?php 
        
			$lista = $usuarios->listarUsuarios();
			foreach ($lista as $usuario) {
			
			?>
          </thead>
          <tbody>
			<tr>
			<td class="list"><?php echo $usuario['nome'];?></td>
      <td class="list"><?php echo $usuario['usuario'];?></td>
			<td class="list"><?php echo $usuario['email'];?></td>
			<td class="list"><?php echo $usuario['tipo'];?></td>

    <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] == 'adm'): ?>

			<td class="list editar">
				<a class="" href="editar.php?id=<?php echo $usuario['id']; ?>">Editar</a>
			</td>
			<td class="list excluir">
				<a class="" href="#" onclick='confirmaExclusao(<?php echo $usuario["id"]; ?>)' >Excluir</a>
			</td>

    <?php endif; ?>

			</tr>
      <?php  } ?>
			<!-- Finaliza o loop -->
		</tbody>
        </table>

```

## Conclusão e Resultado:

"Se o usuário for um administrador, o HTML que está ali no meio será renderizado normalmente. Se não for, o PHP simplesmente pula esse bloco e nada é enviado para o navegador do cliente. É uma forma simples e eficiente de garantir a segurança da interface!"


