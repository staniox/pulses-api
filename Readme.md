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
rodar composer serve --dev //ele faz tudo e sobe o servidor cuidado que ele da timeout
voce pode rodar manualmente tambem:
composer install
vendor/bin/doctrine orm:schema:update --force
```

## Compilar e executar 
```
composer serve --dev ou 
php -S localhost:8000 -t public public/index.php // esse nao da timeout
```