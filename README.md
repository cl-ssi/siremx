## Autoría

Sistema desarrollado en la unidad TIC del Servicio de Salud de Tarapacá.

sistemas.sst@redsalud.gob.cl

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


1. En archivo .env, la variable MIX_VUE_APP_URL se le agregar ruta /siremx/
2. Se modifica el archivo bootstrap.js (abrir archivo, agregar o quitar un espacio es mas que suficiente)
3. Ejecutar en tu consola el siguiente comando: npm run prod
4. Guardas tu cambios git commit y git push
5. En el servidor se dirige a carpeta siremx y se ejecuta comando git pull

Cada vez que guardas en tu editor de texto puedes ver los cambios con el comando: npm run watch