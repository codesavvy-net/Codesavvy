# Projeto Squad21

### Como executar o projeto através do ?AMP?

- Instale o ?amp desejado, de acordo com seu sistema operacional
- Instale o git
- Dentro do diretório htdocs, www ou outro de acordo com o amp escolhido, execute o git clone
git clone git@github.com:Squad-2l/Projeto-001.git
- Configure o virtualhost de acordo com o ?amp escolhido para redirecionar um dominio interno para pasta public
Ex: squad.localhost

Agora instale as dependências do projeto:
- Instale o composer em sua maquina de acordo com seu sistema operacional
- Execute pelo CMD, Powershell ou Terminal o comando composer install dentro da pasta do projeto

Dependências do Frontend
- Instale o NPM
- Execute pelo CMD, Powershell ou Terminal o comando npm install dentro da pasta public do projeto

Banco de Dados
- Instale o banco de dados Mysql
- Crie o banco de dados com o comando:
CREATE SCHEMA `Squad21` DEFAULT CHARACTER SET utf8mb4;
- Copie o arquivo .env.example e crie um arquivo com o nome .env alterado os dados internos pelo dados da conexão de seu banco de dados atual
- Execute a migração através do composer migrate

### Como executar o projeto através do Docker?

- Instale o Docker e Docker-compose de acordo com seu sistema operacional
- Instale o git
- Execute o git clone na pasta desejada para o projeto
git clone git@github.com:Squad-2l/Projeto-001.git
- Execute docker-compose up -d

##### Os comandos a seguir podem ser rodados dentro do container ou em sua maquina local
Para rodar em sua maquina local, lembre-se de instalar o PHP de acordo com seu sistema operacional

- Execute composer install
- Crie um copia do arquivo .env.example com o nome .env
- Execute composer migrate

Dependências do Frontend (em sua maquina local)
- Instale o NPM
- Execute pelo CMD, Powershell ou Terminal o comando npm install dentro da pasta public do projeto