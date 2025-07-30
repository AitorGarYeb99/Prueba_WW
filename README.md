# 🍽️ Prueba Técnica - API RESTful de Restaurantes

Este proyecto consiste en una **aplicación fullstack** desarrollada como parte de una prueba técnica para **WeWelcome**. Permite realizar operaciones CRUD sobre una entidad Restaurante, incluyendo:

- API RESTful con Symfony
- Autenticación por API Key
- Base de datos PostgreSQL
- Documentación Swagger
- Frontend funcional con React
- Contenerización con Docker y Docker Compose

---

## 🛠️ Tecnologías utilizadas

- **Backend**: Symfony 6, Doctrine ORM
- **Base de datos**: PostgreSQL 16
- **Frontend**: React 19 (con Hooks)
- **Seguridad**: Autenticación por API Key
- **Documentación**: Swagger (NelmioApiDocBundle)
- **Contenerización**: Docker & Docker Compose

---

## ⚙️ ¿Cómo ejecutar el proyecto?

### 1. Clona el repositorio

```bash
git clone <URL_DEL_REPO>
cd <nombre_del_proyecto>
```

### 2. Levanta los servicios con Docker Compose

```bash
docker compose up --build
```

Esto iniciará:

- Frontend en `http://localhost:3000`
- Backend Symfony en `http://localhost:8000`
- Documentación Swagger en `http://localhost:8000/api/doc`
- PostgreSQL en `localhost:5432`

### 3. Ejecuta migraciones en el backend

```bash
docker exec -it api_wewelcome-backend-1 bash
php bin/console doctrine:migrations:migrate
exit
```

---

## 🔐 Autenticación

La API requiere una API Key en la cabecera de todas las peticiones:

```http
X-API-KEY: 12345
```

---

## 📚 Documentación interactiva

Swagger UI disponible en:

```
http://localhost:8000/api/doc
```

Desde ahí puedes hacer pruebas directamente sobre la API con la clave de autenticación.

---

## 📦 Endpoints disponibles

| Método | Ruta                    | Descripción              |
|--------|-------------------------|--------------------------|
| GET    | /api/restaurants        | Listar restaurantes      |
| GET    | /api/restaurants/{id}   | Obtener un restaurante   |
| POST   | /api/restaurants        | Crear restaurante        |
| PUT    | /api/restaurants/{id}   | Actualizar restaurante   |
| DELETE | /api/restaurants/{id}   | Eliminar restaurante     |

---

## 💻 Frontend

Aplicación React conectada a la API para:

- Listar restaurantes
- Crear, editar y eliminar
- Validación básica de campos
- Mensajes de error gestionados con `alert()`

Disponible en:  
👉 `http://localhost:3000`

---

## 📌 Notas finales

✅ Proyecto completamente funcional y contenerizado.  
✅ Sin dependencias locales, todo corre en Docker.  
✅ Listo para evaluación técnica.

Desarrollado por **Aitor Garrido** para **WeWelcome**.
