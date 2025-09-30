## About
Projeto livros

## Instruções de ambiente
Basta clonar o repositório e no diretório raíz usar o seguinte comando para construir e subir os containers necessários para a aplicação.
Esse comando além de subir os containers irá realizar as configurações iniciais da aplicação, instalação das dependências e execução das
migrations para iniciar o banco de dados base da aplicação
```
make build
```

## Acesso a aplicação
Para acessar a aplicação, basta abrir o navegador e entrar no seguinte endereço
```
http://localhost:8000
```

## Testes
Para executar os testes da aplicação utilize o seguinte comando
```
make test
```