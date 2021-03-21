para rodar o projeto:
composer install;

php -S localhost:8080 -t public public/index.php
# pulses-api

## Requisitos
```
php 7.4 ou superior
composer instalado
mysql
```
## Instalacao
```
alterar o .env na raiz do projeto
criar um banco de dados com o mesmo que esta no .env
rodar compose serve //ele faz tudo e sobe o servidor
voce pode rodar manualmente tambem:
composer install
vendor/bin/doctrine orm:schema:update --force
```

## Instalar Compilar and executar 
```
composer serve ou php -S localhost:8000 -t public public/index.php
```