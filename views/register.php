<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?> - Registro</title>
    <link rel="stylesheet" href="/test-vocacional/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <h1>🎯 Test Vocacional</h1>
                    <p>Registro de Estudiantes</p>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?= htmlspecialchars($_SESSION['error']) ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/test-vocacional/register" class="login-form">
                    <div class="form-group">
                        <label for="username">Usuario</label>
                        <input type="text" id="username" name="username" required 
                               placeholder="Ingresa un nombre de usuario">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required 
                               placeholder="Ingresa tu email">
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required 
                               placeholder="Ingresa tu nombre">
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" id="apellido" name="apellido" required 
                               placeholder="Ingresa tu apellido">
                    </div>

                    <div class="form-group">
                        <label for="curso">Curso</label>
                        <select id="curso" name="curso" required>
                            <option value="">Selecciona tu curso</option>
                            <option value="3ro BGU">3ro BGU</option>
                            <option value="3ro BT">3ro Técnico</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required 
                               placeholder="Ingresa tu contraseña (mínimo 6 caracteres)">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Registrarse
                    </button>
                </form>

                <div class="login-footer">
                    <p>¿Ya tienes cuenta? <a href="/test-vocacional/login">Inicia sesión aquí</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="/test-vocacional/assets/js/main.js"></script>
</body>
</html>