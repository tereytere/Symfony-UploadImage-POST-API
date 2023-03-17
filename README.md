![image](https://user-images.githubusercontent.com/103147148/225964059-f79d1737-5fc3-41f6-99ab-0bfcc312e5b3.png)
# Symfony POST API subir una imagen desde mi local
creación de una API POST que reciba una imágen

# Requisitos
* Symfony CLI: [https://symfony.com/download]
* PHP: PHP 8.2.3 (cli). Por ejemplo se puede descargar en OSX con: [https://formulae.brew.sh/formula/php]
* Composer: [https://getcomposer.org/download/]

# Pasos para la instalación de Symfomy y paquetes
* new symfony users --version=5.4
* composer require symfony/orm-pack (Sin docker)
* composer require symfony/maker-bundle
* composer require form validator twig-bundle security-csrf annotations

# Configuración y creación de entidades/controladores
* Modificamos el .env para que usar nuestra base de datos, sea sqlite o MySql, etc
* Creamos una Entidad que se puede llamar "ImageUpload"
* En nuestra entidad creamos una propiedad 'image' de tipo string
* Creamos un controlador llamado 'ImageUploadController'

# Rutas de la aplicación:
|URL   | Descripción  | 
|---|---|
|/upload/image   | API post  |
