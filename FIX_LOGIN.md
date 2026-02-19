# 🔧 SOLUCIÓN: Error de Credenciales - Login no Funciona

## 🔍 ¿Cuál es el Problema?

Los hashes bcrypt que generé inicialmente podría que no sean válidos. La solución es **regenerar los usuarios con hashes confirmados**.

---

## ✅ SOLUCIÓN RÁPIDA (RECOMENDADO)

### Opción 1: Ejecutar Script de Inicialización

1. **Abre tu navegador**
   ```
   http://localhost/EcoWeb/inicializar.php
   ```

2. **El script hará lo siguiente:**
   - ✅ Borrará usuarios antiguos
   - ✅ Creará 6 usuarios nuevos
   - ✅ Generará hashes bcrypt válidos
   - ✅ Creará comentarios de prueba

3. **Verás confirmación:**
   ```
   ✓ Usuario creado: admin@ecoweb.com / Admin123
   ✓ Usuario creado: admin2@ecoweb.com / Admin456
   ... (y 4 más)
   ✓ Comentarios de prueba creados
   ```

4. **¡Listo!** Ahora intenta login con:
   ```
   Email:    admin@ecoweb.com
   Password: Admin123
   ```

---

## 📋 OPCIÓN 2: Generar y Copiar Hashes Manualmente

Si prefieres hacerlo manualmente:

1. **Abre el generador**
   ```
   http://localhost/EcoWeb/generar_hashes.php
   ```

2. **Verás una tabla con:**
   - Email
   - Contraseña
   - Hash bcrypt válido

3. **Copia el SQL completo** (al final de la página)

4. **Pégalo en phpMyAdmin:**
   - Abre http://localhost/phpmyadmin
   - Selecciona BD `ecoweb`
   - Haz clic en "SQL"
   - Borra contenido anterior
   - Pega el SQL
   - Ejecuta

5. **¡Listo!** Las credenciales ahora funcionarán

---

## 🧪 VERIFICACIÓN

Después de ejecutar cualquier opción, intenta:

```
Email:    admin@ecoweb.com
Password: Admin123
```

Deberías ver: **Bienvenida a EcoWeb** ✅

---

## 🆘 SI SIGUE SIN FUNCIONAR

1. **Verifica que MySQL está corriendo**
   ```
   XAMPP → MySQL → Start
   ```

2. **Verifica la BD existe**
   ```
   http://localhost/phpmyadmin
   → Izquierda: "ecoweb" debe estar listada
   ```

3. **Verifica los usuarios existen**
   ```
   phpmyadmin → ecoweb → usuarios
   → Deberías ver 6 filas
   ```

4. **Prueba una contraseña diferente**
   ```
   Email:    juan@ecoweb.com
   Password: Usuario123
   ```

5. **Si nada funciona:**
   - Elimina la BD: DROP DATABASE ecoweb;
   - Reimporta ecoweb.sql
   - Ejecuta inicializar.php de nuevo

---

## 🔐 LOS 6 USUARIOS (Una Vez Inicializados)

| Email | Contraseña | Rol |
|-------|-----------|-----|
| `admin@ecoweb.com` | `Admin123` | ADMIN ✅ |
| `admin2@ecoweb.com` | `Admin456` | ADMIN ✅ |
| `juan@ecoweb.com` | `Usuario123` | Usuario |
| `maria@ecoweb.com` | `Usuario456` | Usuario |
| `carlos@ecoweb.com` | `Prueba789` | Usuario |
| `sofia@ecoweb.com` | `Demo2024` | Usuario |

---

## 📝 RESUMEN

**El problema:** Los hashes iniciales podrían no ser válidos

**La solución:** Ejecutar `inicializar.php` una sola vez

**Result:** Usuarios con hashes válidos y seguros

---

**¿Listo? Ve a:** `http://localhost/EcoWeb/inicializar.php` 🚀
