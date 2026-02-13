# 🌍 EcoWeb - Protegiendo los Ecosistemas del Planeta

Proyecto web educativo alineado con el **Objetivo de Desarrollo Sostenible (ODS) 15** enfocado en la conservación y protección de los ecosistemas terrestres, marinos y polares.

## 📁 Estructura del Proyecto

```
EcoWeb/
├── index.html                 # Página principal del sitio
├── public/                    # Archivos públicos y recursos
│   ├── css/
│   │   └── estilos.css       # Estilos del proyecto
│   ├── js/
│   │   └── script.js         # Lógica del cliente
│   └── img/                  # Imágenes del proyecto
│       ├── Eco1.webp
│       ├── Eco2.jpg
│       └── Eco3.png
├── pages/                     # Páginas HTML del sitio
│   ├── ecosistemas.html      # Información sobre ecosistemas
│   └── contactos.html        # Página de contacto
├── backend/                   # Lógica del servidor (PHP)
│   ├── conexion.php          # Configuración de base de datos
│   └── comentarios.php       # Gestión de comentarios
└── README.md                 # Este archivo

```

## 🚀 Características

- **Multipágina**: Inicio, Ecosistemas y Contacto
- **Base de datos**: Integración con MySQL/MariaDB
- **Sistema de comentarios**: Gestión de feedback de usuarios
- **Diseño responsivo**: Estilos CSS organizados
- **Interactividad**: JavaScript para experiencia mejorada

## 📋 Descripción de Carpetas

| Carpeta | Propósito |
|---------|-----------|
| `public/` | Recursos accesibles al cliente (CSS, JS, imágenes) |
| `pages/` | Páginas HTML del sitio web |
| `backend/` | Lógica del servidor en PHP |

## ⚙️ Requisitos

- PHP 7.0+
- MySQL/MariaDB
- Servidor web (Apache, Nginx, etc.)
- Base de datos configurada como `ecoweb`

## 🔧 Configuración

1. Edita `backend/conexion.php` con tus credenciales de base de datos:
   ```php
   $servidor = "localhost";
   $usuario = "root";
   $password = "tu_contraseña";
   $bd = "ecoweb";
   ```

2. Coloca el proyecto en la raíz de tu servidor web
3. Accede a través de `http://localhost/EcoWeb/`

## 📝 Contenido del Sitio

### Inicio (index.html)
- Bienvenida al proyecto
- Descripción de EcoWeb
- Navegación general

### Ecosistemas (pages/ecosistemas.html)
- Ecosistemas terrestres (Bosques, Selvas, Desiertos, Montañas)
- Ecosistemas marinos (Océanos, Mares, Arrecifes)
- Ecosistemas polares (Ártico, Antártida, Tundra)

### Comentarios (backend/comentarios.php)
- Gestión de comentarios de usuarios
- Integración con base de datos

### Contacto (pages/contactos.html)
- Información de contacto
- Redes sociales
- Formulario de contacto

## 📚 Tecnologías Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Base de datos**: MySQL/MariaDB

## 🎯 Objetivos de Desarrollo Sostenible

Este proyecto contribuye al **ODS 15: Vida Terrestre** promoviendo:
✅ Conservación de ecosistemas terrestres  
✅ Protección de ecosistemas marinos  
✅ Conciencia ambiental  
✅ Educación ecológica  

## 📄 Licencia

EcoWeb © 2026

## 👥 Autor

Proyecto educativo dedicado a la protección del medio ambiente.

---

**Última actualización**: Febrero 2026
