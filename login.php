<?php
session_start();
$show_modal = false;

if (isset($_SESSION['response']) && $_SESSION['response']['type'] === "incorrect") {
    $show_modal = true;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <style>
        @font-face {
            font-family: 'PoppinsRegular';
            src: url('./asset/font/Poppins-Regular.woff2') format('woff2'),
                url('./asset/font/Poppins-Regular.woff') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'PoppinsBold';
            src: url('./asset/font/Poppins-Bold.woff2') format('woff2'),
                url('./asset/font/Poppins-Bold.woff') format('woff');
            font-weight: bold;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'PoppinsMedium';
            src: url('./asset/font/Poppins-Medium.woff2') format('woff2'),
                url('./asset/font/Poppins-Medium.woff') format('woff');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'PoppinsSemiBold';
            src: url('./asset/font/Poppins-SemiBold.woff2') format('woff2'),
                url('./asset/font/Poppins-SemiBold.woff') format('woff');
            font-weight: 600;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'PoppinsExtraBold';
            src: url('./asset/font/Poppins-ExtraBold.woff2') format('woff2'),
                url('./asset/font/Poppins-ExtraBold.woff') format('woff');
            font-weight: bold;
            font-style: normal;
            font-display: swap;
        }

        body {
            background-color: #374375;
            width: 100vw;
            overflow: hidden;
            height: 100vh;
            font-family: 'PoppinsRegular';
        }

        thead {
            font-family: 'PoppinsMedium';
        }

        h1 {
            font-family: 'PoppinsBold';
        }

        li a {
            font-family: 'PoppinsMedium';
        }

        table {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>

    <div class="d-flex flex-column justify-content-between align-items-center overflow-hidden" style="height: 100vh">
        <div class="container d-flex flex-column justify-content-center align-items-center">
            <img src="./asset/bg-login-logo.png" class="mt-5" style="width: 100px;" alt="">
            <h1 class="text-white text-center mt-5" style="margin-bottom: 100px;">WELCOME BACK!</h1>
            <div class="bg-white mb-5" style="border-radius: 100%; width: 150px; height: 150px; border: 1px solid blue"><img src="asset/user.png" alt="profileIcon" style="width: 100%; height: 100%"></div>
            <form class="form d-flex flex-column justify-content-center align-items-center" action="cekLogin.php" method="post">
                <label class="form-label text-white">Username :</label>
                <input class="form-control" style="width: 200px" type="text" name="username">
                <?= isset($_SESSION['response']) ? ($_SESSION['response']['type'] === "emptyUsername" ? "<span style='color: red'>" . $_SESSION['response']['message'] . "</span><br/>" : "") : "" ?>
                <label class="form-label text-white">Password :</label>
                <input class="form-control" style="width: 200px" type="password" name="password">
                <?= isset($_SESSION['response']) ? ($_SESSION['response']['type'] === "emptyPassword" ? "<span style='color: red'>" . $_SESSION['response']['message'] . "</span><br/>" : "") : "" ?>
                <input class="btn text-white mt-3" style="width: 180px; padding: 0px; border-radius: 50px; background-color: #000208" type="submit" value="Login">
            </form>
        </div>
        <img src="./asset/bg-login-bottom.png" style="width: 100%;" alt="">
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3" style="background-color: #BABDE2">
                <div class="modal-header" style="border: none; padding: 0; margin: 0;">
                    <h5 class="modal-title" id="errorModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center" style="color: #374375; margin: 0; padding: 0; height: 50px">
                    <?= $_SESSION['response']['message'] ?>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        <?php if ($show_modal): ?>
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        <?php endif; ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
if (isset($_SESSION['response'])) {
    unset($_SESSION['response']);
}
?>