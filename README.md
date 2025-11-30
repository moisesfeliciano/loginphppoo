### Sistema de autenticação e gerenciamento de usuários em PHP orientado a objetos, implementando operações CRUD (Create, Read, Update, Delete) por meio de classes responsáveis por conexão, manipulação de dados e controle de fluxo. O sistema utiliza práticas de encapsulamento, reutilização de código e tratamento de exceções, além de aplicar hashing de senhas para segurança. A interface web é construída com HTML semântico, estilizada com CSS e aprimorada com componentes responsivos do Bootstrap.


### A estrutura de sistema de login se começa criando todos arquivos necessários:

1 - Cria-se uma pasta-raiz dentro do diretório do localhost, com o nome do projeto (loginphppoo).


loginphppoo/
│
├── assets/
│   ├── dist/
│   │   └── css/
│   │       ├── bootstrap.min.css  (Framework de estilo principal)
│   │       ├── custom.css         (Estilos personalizados globais)
│   │       └── sign.css           (Estilos específicos para a tela de login)
│   │
│   └── brand/
│       └── user.jpg             (Imagem usada na tela de login)
│
├── php/
│   └── Usuarios.php             (Classe principal com toda a lógica de back-end)
│
├── index.html                   (Página inicial de boas-vindas)
├── login.php                    (Página com o formulário de login)
├── pagina-protegida.php         (Menu principal após o login)
├── cadastrar.php                (Formulário para adicionar novos usuários)
├── lista-usuario.php            (Página que lista todos os usuários)
├── editar.php                   (Formulário para editar um usuário existente)
├── delete.php                   (Script que processa a exclusão de um usuário)
├── logout.php                   (Script que encerra a sessão do usuário)


### Pastas Principais:

assets/: 
Esta pasta contém todos os recursos estáticos, como folhas de estilo (CSS), 
imagens e, potencialmente, JavaScript.

dist/css/: 
Armazena os arquivos CSS. Você tem o bootstrap.min.css que é a base do design, 
o custom.css para suas personalizações e o sign.css para estilizar a página de login.

php/ É o coração do seu back-end:

Usuarios.php: Este arquivo é uma classe PHP que gerencia todas as operações relacionadas 
aos usuários: conexão com o banco de dados, validação de login, proteção de páginas, cadastro, listagem, edição e exclusão de usuários.