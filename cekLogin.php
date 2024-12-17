<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['username']) && $_POST['username'] !== "") {
        if (isset($_POST['password']) && $_POST['password'] !== "") {
            if ($_POST['username'] == "admin" && $_POST['password'] == "admin") {
                $_SESSION['login'] = "admin";
                header("Location: index.php");
            } else {
                $_SESSION['response']['message'] = "Username/Password is incorrect";
                $_SESSION['response']['status'] = "error";
                $_SESSION['response']['type'] = "incorrect";
                header("Location: login.php");
            }
        } else {
            $_SESSION['response']['message'] = "Password Tidak Boleh Kosong";
            $_SESSION['response']['status'] = "error";
            $_SESSION['response']['type'] = "emptyPassword";
            header("Location: login.php");
        }
    } else {
        $_SESSION['response']['message'] = "Username Tidak Boleh Kosong";
        $_SESSION['response']['status'] = "error";
        $_SESSION['response']['type'] = "emptyUsername";
        header("Location: login.php");
    }
}
