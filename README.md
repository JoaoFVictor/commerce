# Commerce

<p align="center">
  <img src="https://cdn.pixabay.com/photo/2016/06/12/09/08/iphone-1451614_960_720.png" width=300px>
</p>

> O presente projeto é uma API para um comércio desenvolvida com laravel utilizando `service`, `action` e `repository`. A API contempla toda a parte de usuários, clientes, produtos, estoque, notificações e transações.

## ✨ Features

O projeto ainda está em desenvolvimento e as próximas atualizações serão voltadas nas seguintes tarefas:

- ✅Usuário e cliente
- ✅Produto e estoque
- ✅Notificação
- ⌛Menu, tela
- ⌛Imagem e carousel
- ⌛Transação de produtos

## 💻 Pré-requisitos

Antes de começar, verifique se você atendeu aos seguintes requisitos:
* Sua máquina contém PHP com versão 8.1 ou superior e com todas as extensões necessárias para o funcionamento do laravel.
* Sua máquina contém Composer com versão 2.0 ou superior.

## ⚙️ Instalação

Para a instalação do projeto, siga as etapas:

Primeiramente clone o projeto:
```
git clone https://github.com/JoaoFVictor/commerce.git
```

Acesse a pasta do projeto:
```
cd commerce
```

Execute o comando de instalação de pacotes do composer:
```
composer install
```
Execute o comando de instalação de pacotes do composer:
```
composer install
```

## ⛵ Laravel Sail

O projeto utiliza o Sail para conteinerização o ambiente de desenvolvimento. Para instalar utilize os seguintes comandos:
```
php artisan sail:install
```
> Obs: O Sail irá pegar as informações de `username`, `password` e `database` que estão configurado no `.env`

Para subir os containers da aplicação execute o comando:
```
./vendor/bin/sail up -d
```
> Obs: Se houver alterações no arquivo `docker-compose.yml` é recomendado fazer novamente o build da aplicação, para isso, utilize `./vendor/bin/sail up -d --build`. Antes de executar o comando, certifique que nenhum contêiner esteja rodando, caso esteja, utilize o comando `./vendor/bin/sail down` para desligá-los

Para total funcionamento do projeto, é necessário dar permissões para algumas pastas, para isso é necessário entrar no container do Sail e executar alguns comandos:
```
./vendor/bin/sail root-shell
chmod -R 777 storage
chmod -R 777 bootstrap/cache
```
## 🚀 Executando projeto

Após a configuração do Sail e os containers já em funcionamento, para a execução do projeto é necessário alguns outros passos. O primeiro deles é a criação da `APP_KEY` do Laravel, para isso execute o comando:
```
./vendor/bin/sail artisan key:generate
```

É necessário também criar e popular o banco de dados, rode o comando:
```
./vendor/bin/sail artisan migrate --seed
```

## 🤝 Colaboradores

Agradecemos às seguintes pessoas que contribuíram para este projeto:

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/JoaoFVictor">
        <img src="https://avatars.githubusercontent.com/u/40879034?v=4" width="100px;" alt="Foto do João Victor"/><br>
        <sub>
          <b>João Victor</b>
        </sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/Chris7T">
        <img src="https://avatars.githubusercontent.com/u/61260897?v=4" width="100px;" alt="Foto do Christian Eduardo"/><br>
        <sub>
          <b>Christian Eduardo</b>
        </sub>
      </a>
    </td>
  </tr>
</table>

## 📝 Licença

Esse projeto está sob licença. Veja o arquivo [MIT Licença](https://opensource.org/licenses/MIT) para mais detalhes.
