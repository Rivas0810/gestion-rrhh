Resumen del proyecto
Estamos montando un sistema de RRHH con Symfony + PHP + MySQL usando Docker. La base de datos se llamará:

gestion_rrhh

La idea actual es no separar un frontend: Symfony renderizará la interfaz directamente mediante Twig. No añadiremos Nginx, Redis, Elasticsearch, etc. por ahora.

Estructura actual
gestor_rrhh/
├── .docker/
│   ├── php/
│   │   └── Dockerfile
│   └── mysql/
│       └── Dockerfile
│
├── app/
│   └── Symfony
│
├── .env
└── docker-compose.yml

app/ está montado como volumen, así que puedes editar el código desde Fedora/VS Code y PHP/Symfony lo ejecuta dentro del contenedor.

Contenedor PHP
Usamos:

FROM php:8.4-cli

El Dockerfile terminó teniendo conceptualmente:

PHP 8.4 CLI

pdo

pdo_mysql

zip

unzip

curl

Composer

Symfony CLI

usuario appuser con el mismo UID/GID que el usuario de Fedora

Usamos:

ARG UID=1000
ARG GID=1000

y desde Compose:

build:
  context: .
  dockerfile: .docker/php/Dockerfile
  args:
    UID: ${UID}
    GID: ${GID}

El .env de la raíz contiene actualmente:

UID=1000
GID=1000

Esto es para solucionar los permisos del bind mount en Fedora.

Volumen PHP
Tenemos:

volumes:
  - ./app:/var/www/html:Z

La :Z es importante en Fedora porque permite que SELinux autorice el acceso del contenedor al directorio.

Así:

Fedora
  ./app
     │
     ▼
PHP container
  /var/www/html

Los archivos creados por Composer/Symfony quedan en tu máquina y puedes modificarlos directamente.

Symfony
Creamos Symfony con:

docker compose run --rm php composer create-project symfony/skeleton .

Composer inicialmente se quejó de que faltaba zip, así que añadimos:

libzip-dev
unzip

y:

docker-php-ext-install pdo pdo_mysql zip

Symfony se creó correctamente.

También instalamos Symfony CLI.

El contenedor PHP se mantiene ejecutándose mediante:

command: symfony server:start --no-tls --allow-http --port=8000 --listen-ip=0.0.0.0

El puerto está configurado como:

ports:
  - "8082:8000"

Por tanto:

localhost:8082
      ↓
contenedor PHP:8000
      ↓
Symfony

Y ya comprobamos que http://localhost:8082 funciona.

Contenedor MySQL
Queremos un Dockerfile propio en:

.docker/mysql/Dockerfile

pero no necesitamos construir MySQL desde cero.

La idea es:

FROM mysql:8.4

En Compose tenemos el servicio:

mysql:
  build:
    context: .
    dockerfile: .docker/mysql/Dockerfile

  environment:
    MYSQL_ROOT_PASSWORD: root
    MYSQL_DATABASE: gestion_rrhh
    MYSQL_USER: rootu
    MYSQL_PASSWORD: rootp

  volumes:
    - mysql_data:/var/lib/mysql

  networks:
    - gestion_rrhh

El volumen:

mysql_data:/var/lib/mysql

permite conservar los datos aunque se recree el contenedor.

Importante: las variables MYSQL_* se utilizan principalmente durante la inicialización de un MySQL vacío. Si cambiamos usuario/contraseña después de haber inicializado el volumen, MySQL no necesariamente crea el nuevo usuario.

Como todavía estamos configurando el proyecto y no hay datos importantes, para reinicializarlo completamente podemos usar:

docker compose down -v

⚠️ Esto elimina el volumen y, por tanto, los datos de MySQL.

Después:

docker compose up -d --build

Red Docker
PHP y MySQL están en la misma red:

networks:
  gestion_rrhh:

Por eso PHP no debe utilizar localhost para conectarse a MySQL.

Desde PHP:

mysql:3306

es el servidor MySQL.

Docker Compose proporciona resolución DNS para el nombre del servicio:

php container
     │
     │ mysql:3306
     ▼
mysql container

DATABASE_URL
Symfony utiliza:

app/.env
app/.env.dev

y descubrimos que .env.dev tiene prioridad sobre .env.

Inicialmente Symfony tenía una configuración por defecto de PostgreSQL:

postgresql://app:!ChangeMe!@127.0.0.1:5432/app

Eso causaba:

could not find driver

porque nuestro PHP solamente tiene pdo_mysql.

Lo corregimos en:

app/.env.dev

con:

DATABASE_URL="mysql://rootu:rootp@mysql:3306/gestion_rrhh?serverVersion=8.4&charset=utf8mb4"

La correspondencia es:

MySQL                         Symfony

gestion_rrhh        ←──────→ gestion_rrhh
rootu               ←──────→ rootu
rootp               ←──────→ rootp
mysql:3306          ←──────→ mysql:3306

Conexión comprobada
Probamos directamente desde PHP:

docker compose exec php php -r '$pdo = new PDO("mysql:host=mysql;port=3306;dbname=gestion_rrhh", "rrhh_user", "rrhh_password"); echo $pdo->query("SELECT VERSION()")->fetchColumn() . PHP_EOL;'

y obtuvimos:

8.4.11

Esto demostró que:

PHP
 ↓
PDO
 ↓
pdo_mysql
 ↓
Docker network
 ↓
mysql:3306
 ↓
MySQL 8.4.11
 ↓
gestion_rrhh

funciona.

Posteriormente instalamos symfony/orm-pack.

doctrine:query:sql no está disponible en nuestra instalación; doctrine:query:dql existe, pero SELECT 1 no era una consulta DQL adecuada.

Finalmente:

docker compose exec php php bin/console doctrine:schema:validate

ya funciona correctamente después de corregir DATABASE_URL.

Estado actual
Tenemos la infraestructura base funcionando:

                         Fedora
                           │
                    localhost:8082
                           │
                           ▼
                 ┌──────────────────┐
                 │   PHP container   │
                 │                  │
                 │ PHP 8.4          │
                 │ Symfony           │
                 │ Symfony CLI       │
                 │ Composer          │
                 │ PDO               │
                 │ PDO MySQL         │
                 │ Doctrine ORM      │
                 └────────┬─────────┘
                          │
                    gestion_rrhh
                     Docker network
                          │
                          ▼
                 ┌──────────────────┐
                 │  MySQL container │
                 │    MySQL 8.4     │
                 │                  │
                 │ gestion_rrhh     │
                 │ rootu / rootp    │
                 └──────────────────┘

Siguiente paso recomendado
Ahora que Docker + PHP + Symfony + Doctrine + MySQL ya funcionan, el siguiente paso lógico es crear la primera entidad del sistema, probablemente:

Empleado

y aprender el flujo:

Entidad Symfony
      ↓
Doctrine ORM
      ↓
Migration
      ↓
MySQL
      ↓
tabla empleado

Después podremos modelar las entradas/salidas de los empleados y empezar realmente con el sistema de RRHH.