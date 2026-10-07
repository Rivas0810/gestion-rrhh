Desarrollo de sistema de gestión de RRHH (Entradas y salidas)

Para abordar este planteamiento de problema, lo primero en lo que me enfoqué fue en montar el entorno completo, desde los archivos
de configuración iniciales contenedores Docker comprendendo la estructra inicial, tomando así el primer paso de la infraestructura,
esto siguiendo los lineamientos y la lógica básica del mismo planteamiento donde el sistema necesita al menos de dos contenedores
o servicios principales que son los encargados de administrar el sistema, describiendolos a continuación:

1. Contenedor PHP / Symfony: Este primer contenedor es el encargado de manejar el funcionamiento interno de todo el sistema
desde la gestión y manejo de la base de datos hasta las consultas API y toda la interfaz, podríamos definir sus responsabilidades
como las siguientes:
A. Manejo de interfaz "Admin" con la que interactua el usuario (gestion en RRHH, para este caso de uso se omitió el login pero se
plantea el que los usuarios autorizados para usar este sistema deberían contar con los permisos de autorización y autenticación.)
B. Conexión y manejo completo de la BDD (Básicamente, se encarga de gestionar la interacción y las acciones API REST que permiten
el funcionamiento del sistema CRUD: crear, editar, eliminar y visualizar)
C. Salida de los Endpoints: El acceso a la información de este mismo sistema se logra mediante una la API que devuelve formato JSON
que permite SOLO la consulta (GET) de la información que haya sido almacenada en este sistema (considerando que para un sistema 
completo, se debería incluir la capacidad de manejar los datos desde los/el endpoint segun fuera requerido.)

2. Contenedor MySQL: Este contenedor permite alojar la base de datos "gestion_rrhh", la cual es administrada directamente por el otro
contenedor PHP. De esta manera es que se pueden llevar a cabo las modificaciones dentro de la base de datos y es que el sistema 
funciona adecuadamente, en las responsabilidades del contenedor tenemos las siguientes:
A. Alojamiento de la base de datos y comunicación con el contenedor PHP que permite la administracion completa del sistema dentro del
entorno y la red del contenedor.

A continuación detallaré el desarrollo de la base de datos inicial:

Para llevar a cabo el desarrollo del sistema, tomaremos las siguientes simplificaciones:
-> El sistema no contará con un login de usuarios (autenticación)
-> Los campos que podrían ser multiples, por ej: "teléfono", solo serán y se tomarán como si fueran de un solo dato
-> Los empleados solo pueden pertenecer a un solo departamento.
-> No se registrará si el empleado llegó "a tiempo" o "tarde" sino solo si llegó y se fue. 
-> Para mantener simple la BDD usare ID autoincremental en lugar de UUID o similares.
-> Omitiremos cuestiones como un log de cambios o identificadores de quien hace los cambios, porque carecemos de login para registrarlo.

Las tablas desarrolladas inicialmente son las siguientes:

Tabla - employee: Vamos a guardar sus datos básicos: nombre, correo y un dato de contacto personal (telefono), se pueden agregar otros
ya sea domicilio, NSS, o los que sean necesarios para identificar al empleado. Finalmente una FK que permite catalogarlo como parte de un departamento
ID - PK++
name - string (70)
email - string (70)
phone - string(10)
department_id - FK

Tabla - department: Con el principio de mantenerlo simple, esta tabla solo indica el nombre del departamento, omitimos cuestiones tales como ubicación,
funciones del departamento, entre otros datos de especificación del departamento. 
ID - PK++
name - string(70)

Tabla - attendance_records: Esta tabla es la encargada de la gestion directa de los registros de entrada y de salida dentro del sistema, por lo que debe de contar con registros de entrada/salida y el empleado el cual genera estos registros. Considero que no hace falta agregar más información a esta tabla
con el esquema actual del desarrollo del sistema.
ID - PK++
entry_time - datetime
exit_time - datetime
employee_id - FK

