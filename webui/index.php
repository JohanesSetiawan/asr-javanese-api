<?php
$username = "root";
$password = "";
$database = "jawir-database";
$hostname = "localhost";

$connection = mysqli_connect($hostname, $username, $password, $database);

session_start();

// Check if the user is not logged in and redirect to login.php
if (!isset($_SESSION['csrf_token'])) {
    header("Location: ./login.php");
    exit;
}

if (isset($_GET['logout'])) {
    // Check if the session exists before destroying it
    if (isset($_SESSION['csrf_token'])) {
        session_destroy();
    }

    header("Location: ./login.php");
    exit;
}

?>
<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jawa Automatic Speech Recognition | JAWIR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<style>
    .icon-list {
        padding-left: 0;
        list-style: none;
    }

    .icon-list li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 0.25rem;
    }

    .icon-list li::before {
        display: block;
        flex-shrink: 0;
        width: 1.5em;
        height: 1.5em;
        margin-right: 0.5rem;
        content: "";
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    .textJustify {
        text-align: justify;
        text-justify: inter-word;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>

<body>
    <div class="col-lg-8 mx-auto p-3 py-md-5">
        <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
            <h1 class="text-light">Jawa Automatic Speech Recognition | JAWIR</h1>
        </header>

        <main>
            <div class="row g-5">
                <div class="col-md-6">
                    <h2>About</h2>
                    <p class="textJustify">JAWIR adalah sebuah sistem pengenalan ucapan berbasis <i class="">deep learning</i> dengan model yang sudah di
                        tuning menggunakan dataset dengan suara Bahasa Jawa. Pada tahap ini JAWIR masih versi <i>beta</i> akibat model
                        kami yang belum cukup kuat untuk melakukan pengenalan ucapan dengan sangat presisi. Kedepannya, model yang kami
                        kembangkan dan analisis ini, akan (hampir) presisi, seperti yang Anda ucapkan. Dan kami percaya penuh, project yang kami buat
                        akan bermanfaat kedepannya. - <i><b>Kelompok 2</b></i></p>

                    <h2>Demo</h2>
                    <p class="textJustify">Anda bisa mencoba demo, dengan klik tombol Transcribe di bawah ini.</p>
                    <div class="mb-5">
                        <button class="btn btn-primary btn-lg px-4" onclick="checkLogin()">Transcribe</button>
                    </div>
                    <div class="mb-5">
                        <h2>Logout</h2>
                        <p>keluar untuk kembali ke login page</p>
                        <button class="btn btn-primary btn-lg px-4" onclick="logout()">Logout</button>
                    </div>
                </div>

                <div class="col-md-6">
                    <h2>Team</h2>
                    <p>5 Anggota yang hebat untuk membangun JAWIR pada platform website ini</p>
                    <ul>
                        <li>Muhammad Maulana Hikam</li>
                        <ul class="icon-list">
                            <li class="text-body-secondary"><i>Role: <b>Leader Team Developer</b> | Build and Training JAWIR Deep Learning</i></li>
                        </ul>
                        <li>Shaka Arisya</li>
                        <ul class="icon-list">
                            <li class="text-body-secondary"><i>Role: <b>Co-Leader Team Developer</b> | Pre-processing Dataset</i></li>
                        </ul>
                        <li>Dionisious Avedo Priyantoro</li>
                        <ul class="icon-list">
                            <li class="text-body-secondary"><i>Role: <b>Assistant Team Developer</b> | Optimalization Model and Website </i></li>
                        </ul>
                        <li>Itsna Maulana Hasan</li>
                        <ul class="icon-list">
                            <li class="text-body-secondary"><i>Role: <b>Assistant Team Developer</b> | Search and Creating Dataset | Build Backend API Model</i></li>
                        </ul>
                        <li>Johanes Setiawan</li>
                        <ul class="icon-list">
                            <li class="text-body-secondary"><i>Role: <b>Member Team Developer</b> | Tester | Build Frontend JAWIR Website</i></li>
                        </ul>
                    </ul>
                </div>
            </div>
        </main>
        <footer class="pt-5 my-5 text-muted border-top">
            Created by Kelompok 2 - STKI &middot; &copy; 2024
        </footer>

    </div>
    <script>
        function checkLogin() {
            <?php
            if (isset($_SESSION['csrf_token'])) {
                echo "window.location.href = './transcribe.php';";
            } else {
                echo "window.location.href = './login.php';";
            }
            ?>
        }

        function logout() {
            window.location.href = './index.php?logout=1';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>