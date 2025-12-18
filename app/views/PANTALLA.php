<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PANTALLA</title>
  <link rel="stylesheet" href="../../public/css/stylesPANTALLA.css" />
  <link rel="icon" href="../../public/img/CALAMAR.png" type="image/png" />
  <style>
    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 25vw;
        max-width: 300px;
    }
    .password-wrapper input[type="password"],
    .password-wrapper input[type="text"] {
        flex: 1;
        width: 100%;
        padding-right: 40px;
    }
    .toggle-password {
        position: absolute;
        right: 10px;
        cursor: pointer;
        user-select: none;
        color: hsl(0, 95%, 33%);
        font-weight: bold;
        font-size: 14px;
    }
    .toggle-password:hover {
        color: hsl(0, 95%, 60%);
    }
  </style>
</head>
<body>
  <div class="logo-container">
    <img id="logoCALAMAR" src="../../public/img/CALAMAR.png" class="iconos" alt="Logo" />
  </div>

  <?php if (isset($_GET['error'])): ?>
    <div class="error-message" style="color:red; text-align:center; margin-bottom:10px;">
      <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
  <?php endif; ?>

  <form id="loginForm" class="general-container" action="/proyecto-final-main/app/controllers/RegisterController.php" method="POST" novalidate>
    
    <div class="logo-usuario-contraseña">
      <img id="logoPERSONA" src="../../public/img/SCOOBY.png" class="etiqueta iconos" alt="Logo" />
      <input type="text" placeholder="Apodo" id="nombre" name="nombre" required />
    </div>

    <div class="logo-usuario-contraseña">
      <img id="logoPERSONITA" src="../../public/img/PERSONITA.png" class="etiqueta iconos" alt="Logo" />
      <input type="email" placeholder="Correo" id="correo" name="correo" required />
    </div>

    <div class="logo-usuario-contraseña password-wrapper">
      <img id="logoCONTRASEÑA" src="../../public/img/CONTRASEÑA.png" class="etiqueta iconos" alt="Logo" />
      <input type="password" id="password" name="password" placeholder="Contraseña" required />
      <span class="toggle-password" id="togglePassword">👁️</span>
    </div>

    <div class="botones">
      <button type="submit" name="accion" value="login" class="logoISR" id="inicio">Iniciar Sesión</button>
      <button type="submit" name="accion" value="register" class="logoISR" id="registerBtn">Registrar</button>
    </div>

  </form>

  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        togglePassword.textContent = type === 'password' ? '👁️' : '🙈';
    });
  </script>
</body>
</html>
