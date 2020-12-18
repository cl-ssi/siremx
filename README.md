## Autoría

Sistema desarrollado en la unidad TIC del Servicio de Salud de Iquique.

sistemas.ssi@redsalud.gob.cl

## Instalación
> Este proyecto está desarrollado en Laravel 7.0 y VueJS

### Prerequisitos

- Ambiente para Laravel [Laragon](https://laragon.org/) (Windows) o [Valet](https://laravel.com/docs/7.x/valet) (Mac OSX)
- Control de versión mediante [git](https://git-scm.com/)
- [composer](https://getcomposer.org/)
- [LTS NPM](https://nodejs.org/es/download/)

### Ejecutar en Terminal

```php
git clone https://github.com/cl-ssi/siremx.git
cd siremx
composer install
cp .env.example .env
php artisan key:generate

# editar archivo .env y modificar las variables de base de datos.
php artisan migrate:fresh --seed
```

```js
npm install
npm run dev
npm run watch
```


### Usuario por defecto
Usuario: Admin clave: 123465
