#  Backend_Catedral

API REST desarrollada en PHP con arquitectura en capas 
(Controller → Service → Repository), diseñada para gestionar las operaciones correspondientes a la funcionalidad del 
proyecto CatedralApp

---

##  Arquitectura

El proyecto sigue una arquitectura desacoplada:

Controller → Manejo de HTTP  
Service → Lógica de negocio  
Repository → Acceso a base de datos  

---

##  Tecnologías

- PHP 8+
- MySQL
- Composer

---

##  Instalación

### 1. Clonar repositorio

```bash
git clone https://github.com/JulioFV/Backend_Catedral.git
cd Backend_Catedral

### 2.Instalar librerias necesarias
composer install

### 3. Crear el archivo .env en la raiz del proyecto
Crear las variables necesarias
DB_HOST
DB_PORT
DB_USER
DB_PASSWORD
DB_NAME
DB_CHARSET
DB_COLLATION
