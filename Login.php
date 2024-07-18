<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultorioclinico";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $message = "Inicio de sesión exitoso";
    } else {
        $message = "Correo electrónico o contraseña incorrectos";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CONSULTORIO CLINICO</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        main {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form h1 {
            margin-bottom: 20px;
        }

        form img {
            width: 30px;
            margin: 10px;
            cursor: pointer;
        }

        form input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #5cb85c;
            color: #fff;
            cursor: pointer;
        }

        form button[type="reset"] {
            background-color: #d9534f;
        }

        form p {
            margin-top: 10px;
        }

        form a {
            color: #5bc0de;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <main>
        <article>
            <section>
                <form action="" method="POST">
                    <h1>Inicia Sesion</h1>
                    <img src="facebook.svg" title="Inicia Sesion con Facebook" alt="Inicia Sesion con Facebook">
                    <img src="google.svg" title="Inicia Sesion con Google" alt="Inicia Sesion con Google">

                    <input type="email" name="email" placeholder="Correo electr&oacute;nico" required><br/>
                    <input type="password" name="password" placeholder="Contrase&ntilde;a" required><br/>
                    <button type="submit">Entrar</button>
                    <button type="reset">Limpiar</button>

                    <p>Aun no tienes cuenta ?</p>
                    <p>
                        <a href="Registrar.php">Registrate</a>
                    </p>
                    <?php if ($message): ?>
                    <p><?php echo $message; ?></p>
                    <?php endif; ?>
                </form>
            </section>
        </article>
    </main>
</body>
</html>

