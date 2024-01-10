<?php

$upload_success = false;
$uploaded_filename = '';
$audioSrc = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Logika untuk menentukan src audio berdasarkan file yang diunggah
    if (isset($_FILES['file']) && $_FILES['file']['name'] && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Ensure that the uploaded audio file has the appropriate MIME type (e.g., audio/mpeg for MP3 files)
        $allowed_mime_types = [
            'audio/mpeg',
            'audio/wav',
            'audio/x-wav',
            'audio/mp3',
            'audio/ogg',
        ];
        $filename = $_FILES['file']['name'];
        if (in_array($_FILES['file']['type'], $allowed_mime_types)) {
            // Determine the storage path for the audio file
            $audioPath = 'upload/' . $filename;

            // Move the uploaded audio file to the desired location
            move_uploaded_file($_FILES['file']['tmp_name'], $audioPath);

            $uploaded_filename = '<li>' . $filename . '</li>';
            $upload_success = true;

            // Set the audio src based on the uploaded file
            $audioSrc = $audioPath;
        } else {
            $uploaded_filename = '<li>' . $filename . ' - File type not allowed</li>';
        }

        // Store the filename and upload success flag in the session
        $_SESSION['uploaded_filename'] = $uploaded_filename;
        $_SESSION['upload_success'] = $upload_success;

        // Redirect to the same page
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Check the session for filename and upload success flag
$uploaded_filename = isset($_SESSION['uploaded_filename']) ? $_SESSION['uploaded_filename'] : '';
$upload_success = isset($_SESSION['upload_success']) ? $_SESSION['upload_success'] : false;

// Clear the session values
unset($_SESSION['uploaded_filename'], $_SESSION['upload_success']);
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

    .box {
        outline: 2px dashed white;
        height: 300px;
        border-radius: 10px;
    }

    .box.is-dragover {
        background-color: grey;
    }

    .box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .box label strong {
        text-decoration: underline;
        color: #0d6efd;
        cursor: pointer;
    }

    .box label strong:hover {
        color: blueviolet
    }

    .box input {
        display: none;
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
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="box my-5">
                            <label>
                                <strong>Choose a file</strong>
                                <span>or drag it here.</span>
                                <input class="box__file" type="file" name="file" />
                            </label>
                            <div class="file-list"></div>
                        </div>
                        <input class="btn btn-primary btn-lg" type="submit" value="Submit" name="submit">
                    </form>

                    <audio class="my-3" controls <?php if (!empty($audioSrc)) echo 'src="' . $audioSrc . '"'; ?>></audio>

                    <?php
                    var_dump($_FILES);
                    if (isset($_FILES['file']) && $_FILES['file']['name']) {
                        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
                            // If upload is successful
                            echo '<div class="alert alert-success alert-dismissible" role="alert">';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo 'Upload successful! You just uploaded this file:<br>';
                            echo '<ul>' . $_FILES['file']['name'] . '</ul>';
                            echo '</div>';
                        } else {
                            if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                                // An error occurred during the upload. Handle it here.
                                switch ($_FILES['file']['error']) {
                                    case UPLOAD_ERR_INI_SIZE:
                                    case UPLOAD_ERR_PARTIAL:
                                        $message = "File upload was not completed";
                                        break;
                                    case UPLOAD_ERR_NO_FILE:
                                        $message = "No file was uploaded";
                                        break;
                                    case UPLOAD_ERR_NO_TMP_DIR:
                                        $message = "Missing a temporary folder";
                                        break;
                                    case UPLOAD_ERR_CANT_WRITE:
                                        $message = "Failed to write file to disk";
                                        break;
                                    case UPLOAD_ERR_EXTENSION:
                                        $message = "File upload stopped by extension";
                                        break;
                                    default:
                                        $message = "Unknown upload error";
                                        break;
                                }
                                echo '';
                                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                echo $message;
                                echo '</div>';
                            }
                        }
                    }
                    ?>

                    <div class="mb-5">
                        <h2>Hasil Transcribe dari audio</h2>
                        <div id="result" class="my-3"></div>
                    </div>
                    <div class="mb-5">
                        <h2>Kembali ke home</h2>
                        <button class="btn btn-primary btn-lg px-4 mt-2" onclick="backToIndex()">Back</button>
                    </div>
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


        const box = document.querySelector('.box');
        const fileInput = document.querySelector('[name="file"]');
        const selectButton = document.querySelector('label strong');
        const fileList = document.querySelector('.file-list');

        let droppedFiles = [];

        ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(event => box.addEventListener(event, function(e) {
            e.preventDefault();
            e.stopPropagation();
        }), false);

        ['dragover', 'dragenter'].forEach(event => box.addEventListener(event, function(e) {
            box.classList.add('is-dragover');
        }), false);

        ['dragleave', 'dragend', 'drop'].forEach(event => box.addEventListener(event, function(e) {
            box.classList.remove('is-dragover');
        }), false);

        box.addEventListener('drop', function(e) {
            droppedFiles = e.dataTransfer.files;
            fileInput.files = droppedFiles;
            updateFileList();
        }, false);

        fileInput.addEventListener('change', updateFileList);

        function updateFileList() {
            const file = fileInput.files[0];
            if (file) {
                fileList.innerHTML = `<p>Selected file: ${file.name}</p>`;
            } else {
                fileList.innerHTML = '';
            }
        }

        $(document).ready(function() {
            // Hide alert when Close button is clicked
            $('.alert button').on('click', function() {
                $(this).closest('.alert').hide();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>