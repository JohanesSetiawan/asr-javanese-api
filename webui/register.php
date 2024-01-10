<?php
$username = "root";
$password = "";
$database = "jawir-database";
$hostname = "localhost";

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    echo "Error: " . PHP_EOL;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Encrypt the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statement to prevent SQL injection
    $query = "INSERT INTO users (username, password) VALUES (?, ?)";
    $statement = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($statement, "ss", $username, $hashedPassword);
    mysqli_stmt_execute($statement);

    if (mysqli_stmt_affected_rows($statement) > 0) {
        // Registration successful
        header("Location: ./index.php");
    } else {
        // Registration failed
        header("Location: ./register.php");
    }
}

# if user already logged in, redirect to index.php (use session to check)
session_start();
if (isset($_SESSION['csrf_token'])) {
    header("Location: ./index.php");
    exit;
}
?>

<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JAWIR | Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        html {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #000;
            height: 100%;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body class="text-center">
    <main class="form-signin">
        <form method="POST">
            <h1 class="h3 mb-3 fw-normal">Register</h1>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" name="username" placeholder="username">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                <label for="floatingPassword">Password</label>
                <p>Have an account?
                    <a href="./login.php">login</a>
                </p>
            </div>
            <button class="w-100 btn btn-lg btn-primary mt-2" type="submit" name="submit">Register</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>