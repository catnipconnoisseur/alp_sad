<?php
include 'connection.php';
session_start();

$month = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expense_category = $_POST['expense_category'];
    $nominal = (int) str_replace('.', '', $_POST['nominal']);
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];

    try {
        $pdo->prepare("CALL pAddExpense(?, ?, ?, ?);")->execute([$expense_category, $nominal, $month[$bulan], $tahun]);
    } catch (PDOException $e) {
        echo $e->getMessage();
        $_SESSION['notification']['status'] = "error";
        $_SESSION['notification']['message'] = "Failed to add expense";
        header('Location: financialReport.php');
    }
}
$_SESSION['notification']['status'] = "success";
$_SESSION['notification']['message'] = "Your expense data has been successfully recorded!";
header('Location: financialReport.php');
