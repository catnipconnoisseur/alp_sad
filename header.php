<?php
session_start();
require_once("./connection.php");
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
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

<body style="max-width: 100%; margin: 0; padding: 0">

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

    @font-face {
      font-family: 'InterExtraBold';
      src: url('./asset/font/Inter-ExtraBold.woff2') format('woff2'),
        url('./asset/font/Inter-ExtraBold.woff') format('woff');
      font-weight: bold;
      font-style: normal;
      font-display: swap;
    }

    @font-face {
      font-family: 'InterSemiBold';
      src: url('./asset/font/Inter-SemiBold.woff2') format('woff2'),
        url('./asset/font/Inter-SemiBold.woff') format('woff');
      font-weight: 600;
      font-style: normal;
      font-display: swap;
    }

    body {
      font-family: 'PoppinsRegular';
      font-size: 16px;
      overflow-x: hidden;
      width: 100vw;
      min-height: 100vh;
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