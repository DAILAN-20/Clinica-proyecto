<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud_example";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$message = '';

// Insertar o actualizar datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        header("Location: Login.php");
        exit();
    }

    $id = $_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($id) {
        // Actualizar
        $sql = "UPDATE users SET name='$name', surname='$surname', email='$email', password='$password' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $message = "Registro actualizado con éxito";
        } else {
            $message = "Error al actualizar el registro: " . $conn->error;
        }
    } else {
        // Insertar
        $sql = "INSERT INTO users (name, surname, email, password) VALUES ('$name', '$surname', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $message = "Nuevo registro creado con éxito";
        } else {
            $message = "Error al crear el registro: " . $conn->error;
        }
    }
}

// Eliminar datos
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "Registro eliminado con éxito";
    } else {
        $message = "Error al eliminar el registro: " . $conn->error;
    }
}

$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSULTORIO CLINICO</title>
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Login/css/style.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>
<body>
    <main>
        <article id="register">
            <form id="register-form" method="post" action="">
                <h1>Regístrate</h1>
                <div class="social-login">
                    <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-square" class="svg-inline--fa fa-facebook-square fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg>
                    <img src="google.svg" title="Inicia Sesión con Google" alt="Inicia Sesión con Google">
                </div>
                <input type="hidden" name="id" value="<?php echo $edit ? $row['id'] : ''; ?>">
                <input type="text" id="name" name="name" placeholder="Nombre" value="<?php echo $edit ? $row['name'] : ''; ?>" required>
                <input type="text" id="surname" name="surname" placeholder="Apellidos" value="<?php echo $edit ? $row['surname'] : ''; ?>" required>
                <input type="email" id="email" name="email" placeholder="Correo electrónico" value="<?php echo $edit ? $row['email'] : ''; ?>" required>
                <input type="password" id="password" name="password" placeholder="Contraseña" value="<?php echo $edit ? $row['password'] : ''; ?>" required>
                <button type="submit"><?php echo $edit ? 'Actualizar' : 'Agregar'; ?></button>
                <button type="reset">Limpiar</button>
                <button type="submit" name="login">Iniciar Sesión</button>
                <p>¿Ya tienes cuenta? <a href="Login.php">Inicia Sesión</a></p>
            </form>
        </article>
        <article>
            <h2>Datos del Usuario</h2>
            <table id="userTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo electrónico</th>
                        <th>Contraseña</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["name"]. "</td>";
                        echo "<td>" . $row["surname"]. "</td>";
                        echo "<td>" . $row["email"]. "</td>";
                        echo "<td>" . $row["password"]. "</td>";
                        echo "<td><a href='?edit=" . $row["id"] . "'>Editar</a> | <a href='?delete=" . $row["id"] . "'>Eliminar</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay registros</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </article>
    </main>
    <script>
        function addUserData() {
            var name = document.getElementById("name").value;
            var surname = document.getElementById("surname").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var password2 = document.getElementById("password2").value;

            if (!name || !surname || !email || !password || !password2) {
                alert("Por favor, complete todos los campos.");
                return;
            }

            if (password !== password2) {
                alert("Las contraseñas no coinciden.");
                return;
            }

            var table = document.getElementById("userTable").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();
            newRow.innerHTML = `
                <td>${name}</td>
                <td>${surname}</td>
                <td>${email}</td>
                <td>${password}</td>
                <td><button onclick="editUserData(this)">Editar</button></td>
            `;

            document.getElementById("register-form").reset();
        }

        function editUserData(button) {
            var row = button.parentNode.parentNode;
            for (var i = 0; i < 4; i++) {
                var cell = row.cells[i];
                cell.innerHTML = `<input type="text" value="${cell.textContent}">`;
            }
            button.textContent = 'Guardar';
            button.setAttribute('onclick', 'saveUserData(this)');
        }

        function saveUserData(button) {
            var row = button.parentNode.parentNode;
            for (var i = 0; i < 4; i++) {
                var cell = row.cells[i];
                cell.textContent = cell.querySelector('input').value;
            }
            button.textContent = 'Editar';
            button.setAttribute('onclick', 'editUserData(this)');
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
