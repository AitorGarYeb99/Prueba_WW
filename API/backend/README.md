# Prueba Técnica - API RESTful de Restaurantes 🍽️

Este proyecto consiste en una API RESTful desarrollada como parte de una prueba técnica para **WeWelcome**. Permite realizar operaciones CRUD sobre una entidad `Restaurante`, incluyendo autenticación por API Key y frontend en React.

## 🛠️ Tecnologías utilizadas

- Backend: **Symfony 6**, **Doctrine ORM**
- Base de datos: **PostgreSQL**
- Frontend: **React**
- Seguridad: **Autenticación por API Key**
- Contenerización: **Docker & Docker Compose**
- Otros: **CORS (NelmioCorsBundle)**

---

## 📦 Instalación y ejecución

### 1. Clonar el repositorio


git clone <URL_DEL_REPO>
cd <nombre_del_proyecto>

### 2. Levantar la base de datos con Docker


cd backend
docker compose up -d
Esto levantará un contenedor con PostgreSQL en el puerto 5432.

### 3. Configurar variables de entorno

Copia el archivo .env o crea uno nuevo:
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
Asegúrate de que los datos coincidan con los del contenedor.

### 4. Instalar dependencias del backend

composer install

### 5. Ejecutar migraciones y cargar datos

php bin/console doctrine:migrations:migrate
Puedes insertar un registro de prueba desde PostgreSQL:
INSERT INTO restaurant (name, address, phone) VALUES ('Restaurante WEWelcome', 'Calle Madrid 123', '910000000');

### 6. Iniciar el servidor Symfony

php -S 127.0.0.1:8000 -t public

### 7. Instalar dependencias para el front con React

cd frontend
npm install

### 8. Iniciar el front

npm start
La app se abrirá en: http://localhost:3000
Asegúrate de que el backend esté activo en http://localhost:8000.

🔐 Autenticación

La API requiere autenticación por API Key en la cabecera:
X-API-KEY: 12345
Sin esta cabecera, las peticiones devolverán un error 401 Unauthorized.

📚 Endpoints disponibles
GET /api/restaurants
Obtiene todos los restaurantes.

POST /api/restaurants
Crea un nuevo restaurante. Ejemplo de cuerpo:

{
  "name": "Nuevo Restaurante",
  "address": "Calle Falsa 123",
  "phone": "123456789"
}

GET /api/restaurants/{id}
Devuelve un restaurante por ID.

PUT /api/restaurants/{id}
Actualiza un restaurante. Ejemplo:

{
  "name": "Restaurante Actualizado"
}

DELETE /api/restaurants/{id}
Elimina un restaurante por ID.

📌 Notas finales
Proyecto desarrollado con fines evaluativos.

Incluye contenedor Docker para la base de datos.

Frontend y backend conectados mediante CORS y API Key.
