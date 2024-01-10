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
                    <h2>Transcribe</h2>
                    <p>dmfido</p>
                    <div class="mb-5">
                        <h2>Kembali ke home</h2>
                        <button class="btn btn-primary btn-lg px-4 mt-2" onclick="backToIndex()">Back</button>
                    </div>
                </div>


                <div class="col-md-6">
                    <p>Hasil Transcribe dari audio</p>
                </div>
            </div>
        </main>
        <footer class="pt-5 my-5 text-muted border-top">
            Created by Kelompok 2 - STKI &middot; &copy; 2024
        </footer>

    </div>
    <script>
        function backToIndex() {
            window.location.href = './index.php';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>