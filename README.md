ZF2 UFMG Test
=======================

Introdução
------------
Esse projeto tem como objetivo realizar a apresentação e o conhecimento relacionada ao desenvolvimento PHP. 
Nesse caso foi utilizado o Zend Framework 2 para essa finalidade.

O Projeto consiste na exibição/listagens de notícias, com os recursos de adicionar uma nova notícia (com título, subtítulo e texto), 
editar uma determinada notícia, e ainda visualizar as informações de uma determinada notícia. 

O sistema ainda possui autenticação, na qual o usuário só tera acesso aos recursos informando as suas credenciais (usuário e senha).

Para realizar as operações como realizar login, visualizar as notícias e editar as notícicas, a aplicação irá consumir dados de um serviço RESTFULL, disponibilizado pela UFMG.

Regras da aplicação
---------------------------
+ Página de Login para ter acesso ao sistema
+ Dashboard para exibir as notícias, bem como a informação do usuário logado
+ Na listagem de notícias deve conter o mecanismo de paginação
+ Cadastro e Edição de notícias com os campos título, subtítulo e texto

### Tecnologias usadas
Para o desenvolvimento da aplicação foram utilizados os seguintes recursos:

+ ZendFramework 2
+ Restfull
+ Bootstrap

### Ambiente de Desenvolvimento

+ IDE PHPStorm

### Requisitos da Aplicação

+ Git
+ PHP 5
+ Composer

### Execução da Aplicação
Para realizar o uso da aplicação, basta seguir os seguintes passos:

1. Através do 'prompt command' ou 'git bash', realizar o clone do projeto pelo comando:

        git clone git@github.com:diogomarcos/zf2-ufmg-test.git zf2-ufmg-test

2. Com o 'prompt command' ou 'git bash', navegue até a pasta do projeto `zf2-ufmg-test` e execute os comandos abaixo para 
fazer o download dos requisitos necessários para o funcionamento da aplicação:

        php composer.phar install
        php composer.phar update

3. Assim que finalizar o passo 2, pelo 'prompt command' ou 'git bash', estando na pasta do projeto `zf2-ufmg-test` execute 
o comando abaixo para executar a aplicação:

        php -S localhost:8888 -t public

4. Em seu navegador de preferência use o endereço abaixo para ter acesso a aplicação:

        http://localhost:8888

5. Para obter acesso as funcionadades desenvolvidas (ver notícias, editar notícias, e criar notícias), deve ser utilizado as credenciais abaixo:

        Usuário: 'será disponibilizado em breve'
        Senha:   'será disponibilizado em breve'

### Considerações Complementares
1. Para ter acesso ao review online da aplicação, basta utilizar o endereço abaixo:

        https://zf2-ufmg-test.herokuapp.com/

### Resultado do Desenvolvimento
Abaixo estão disponibilizados as telas da aplicação:

+ Página Login:
![alt tag](https://raw.githubusercontent.com/diogomarcos/zf2-ufmg-test/master/public/img/screen/pagina-login.PNG)

+ Página Inícial:
![alt tag](https://raw.githubusercontent.com/diogomarcos/zf2-ufmg-test/master/public/img/screen/pagina-inicial.PNG)

+ Página Listagem Notícias:
![alt tag](https://raw.githubusercontent.com/diogomarcos/zf2-ufmg-test/master/public/img/screen/pagina-listagem-noticias.PNG)

+ Página Adicionar Notícia:
![alt tag](https://raw.githubusercontent.com/diogomarcos/zf2-ufmg-test/master/public/img/screen/pagina-adicionar-noticia.PNG)

+ Página Ver Notícia:
![alt tag](https://raw.githubusercontent.com/diogomarcos/zf2-ufmg-test/master/public/img/screen/pagina-ver-noticia.PNG)

+ Página Editar Notícia:
![alt tag](https://raw.githubusercontent.com/diogomarcos/zf2-ufmg-test/master/public/img/screen/pagina-editar-noticia.PNG)

