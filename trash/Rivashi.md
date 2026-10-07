RRHH pide una aplicación web sencilla para **administrar empleados y registrar sus checadas de
entrada y salida**, además de una forma de **consultar esa información desde otros sistemas**.

### A. Panel de administración (Admin)
Una interfaz web donde RRHH pueda **dar de alta, consultar, editar y eliminar** la información
del sistema (lo que llamamos un CRUD). Debe cubrir, como mínimo:

- Administrar **empleados**.
- Registrar y consultar las **checadas** (entradas/salidas) de cada empleado.
- Organizar a los empleados de la forma que consideres adecuada (por ejemplo, por área o
  departamento).

El Admin debe hacerse **a mano con formularios de Symfony y plantillas Twig**

### B. API de lectura (solo consulta)
Un conjunto de endpoints **GET** que devuelvan la información en **JSON**, pensados para que
otros sistemas puedan consultar datos. Por ejemplo:

- Listar empleados.
- Consultar un empleado y sus checadas.
- Consultar las checadas de una fecha o un rango.

La API es **solo de lectura**: no se crean ni modifican datos desde ella (eso es trabajo del
Admin). No lleva autenticación.

---

## 3. El modelo de datos lo diseñas tú

Parte importante del reto: **tú propones las entidades, sus campos y sus relaciones**. Analiza
la problemática y decide cómo modelarías empleados, checadas y lo que creas necesario.

Piensa en cosas como: ¿una checada pertenece a un empleado? ¿cómo distingues una entrada de una
salida? ¿cómo agrupas a los empleados? Documenta brevemente tu modelo (puedes incluir un diagrama
simple o una lista de entidades y relaciones en tu propio README).

---

## 4. Stack y reglas

- **Lenguaje/Framework:** PHP + **Symfony** (última versión estable).
- **ORM:** **Doctrine**, con **migraciones** (no modifiques la BD a mano; genera y versiona
  migraciones).
- **Base de datos:** **MySQL**.
- **Vistas:** **Twig**.
- **Docker.** Todo el entorno (PHP, Symfony y MySQL) debe correr en contenedores con
  **Docker + Docker Compose**. No necesitas instalar PHP ni MySQL directamente en tu
  máquina (ver sección 6).
- **Fuera de alcance (no lo hagas):** autenticación/login, POST/PUT/DELETE en la API, tests
  automatizados (bonus opcional si te sobra tiempo), despliegue.

## 5. Entregables

1. El proyecto Symfony completo (código fuente) en un repositorio Git con commits ordenados.
2. Los archivos de **Docker** (`Dockerfile`, `docker-compose.yml` y lo que necesites) para
   levantar todo el entorno.
3. Las **migraciones** de Doctrine (para que podamos recrear la BD).
4. Opcional: fixtures o un script con datos de ejemplo.
5. Un **README propio** dentro de tu proyecto que explique:
   - Cómo levantar tu solución con Docker paso a paso.
   - Qué entidades y relaciones modelaste y por qué.
   - Qué rutas tiene el Admin y qué endpoints tiene la API.
   - Qué dejaste pendiente o mejorarías con más tiempo.



### 6.2 Armar los contenedores

Debes crear tú el entorno Docker del proyecto. Como mínimo:

- Un servicio **php** (imagen con PHP + extensiones de Symfony: `pdo_mysql`, `intl`,
  `mbstring`, etc.) donde correrás Composer y `bin/console`.
- Un servicio **mysql** (base de datos).
- Un `docker-compose.yml` que los conecte y exponga el puerto web para ver la app en el
  navegador.

> Pista: puedes basar la imagen de PHP en `php:8.x-fpm` o `php:8.x-cli` + un servidor web,
> o usar la Symfony CLI dentro del contenedor. Instala las extensiones con
> `docker-php-ext-install`. Documenta en tu README cómo decidiste armarlo.

### 6.3 Crear el proyecto Symfony dentro del contenedor

Una vez levantado el contenedor de PHP, trabaja **dentro de él**:

```bash
# Levantar los servicios
docker compose up -d

# Entrar al contenedor de PHP (ajusta el nombre del servicio)
docker compose exec php bash

# Ya dentro del contenedor:
symfony new asistencia-rrhh --webapp   # o: composer create-project symfony/skeleton
cd asistencia-rrhh
```

Configura la conexión a MySQL en `.env` / `.env.local` (`DATABASE_URL`) apuntando al
**host del servicio de MySQL de docker-compose** (no `127.0.0.1`, sino el nombre del
servicio, p. ej. `mysql`). Luego:

```bash
php bin/console doctrine:database:create
php bin/console make:entity
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

El servidor web lo expones por el puerto que definas en `docker-compose.yml`; abre la app
en tu navegador en `http://localhost:<puerto>`.

> Vienes de Laravel: `php artisan` ↔ `php bin/console`, Eloquent ↔ Doctrine, Blade ↔ Twig,
> migrations ↔ Doctrine Migrations. La diferencia aquí es que todo corre dentro de Docker.

---

## 7. Cómo se evalúa

- Cómo modelaste los datos y sus relaciones.
- Uso correcto de Doctrine y migraciones.
- Calidad del Admin: formularios, validaciones, Twig, mensajes al usuario.
- La API devuelve JSON con los **códigos de estado HTTP correctos**
  (200 cuando hay datos, 200 cuando el recurso existe pero no tiene datos, 404 cuando no
  existe, 400 cuando el parámetro es inválido).
- Orden del código, nombres claros y commits entendibles.
- Tu README y la explicación de tus decisiones.

No se evalúa que esté "terminado al 100%". Se evalúa cómo trabajas y cómo aprendes. ¡Éxito!
