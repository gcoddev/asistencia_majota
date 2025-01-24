# Proyecto de Asistencias y Sueldos

Este proyecto es una aplicación desarrollada en Laravel para la gestión de asistencias y sueldos de una empresa. Los usuarios principales de la aplicación son:

- **Administrador**
- **Técnico**
- **Empleado**

Cada uno de estos roles tiene funcionalidades específicas dentro del sistema.

## Requisitos Previos

- PHP >= 8.2
- Composer
- Base de datos MySQL (deseable)

## Instalación

1. **Clonar el repositorio**

   ```bash
   git clone <URL-del-repositorio>
   cd <nombre-del-directorio>
   ```

2. **Instalar las dependencias del proyecto**

   ```bash
   composer install
   ```

3. **Copiar el archivo de configuración**

   ```bash
   cp .env.example .env
   ```

4. **Generar la clave de la aplicación**

   ```bash
   php artisan key:generate
   ```

5. \*\*Configurar el archivo \*\*\`\`

   - Configura la conexión a la base de datos en el archivo `.env`.

6. **Ejecutar las migraciones y seeders**

   ```bash
   php artisan migrate --seed
   ```

## Paquetes Adicionales

El proyecto incluye el paquete **dompdf** para la generación de documentos PDF. No requiere un comando adicional después de instalarlo con Composer, pero asegúrate de que esté configurado correctamente en el archivo `.env` si es necesario.

## Credenciales de Acceso

Los usuarios iniciales creados por los seeders son:

- **Administrador**

  - Usuario: `admin`
  - Contraseña: `admin`

- **Técnico**

  - Usuario: `tecnico`
  - Contraseña: `tecnico`

- **Empleado**

  - Usuario: `empleado`
  - Contraseña: `empleado`

## Uso

1. Inicia el servidor de desarrollo de Laravel:

   ```bash
   php artisan serve
   ```

2. Acceso `http://localhost:8000`.

3. Inicia sesión con las credenciales proporcionadas según el rol deseado.

## Funcionalidades Principales

- **Administrador**: Gestión completa del sistema, incluyendo usuarios, asistencias, sueldos y roles.
- **Técnico**: Gestión parcial del sistema, asistencias y sueldos.
- **Empleado**: Permisos y marcado de asistencia.

