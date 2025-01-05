<?php
include 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expense_category = $_POST['expense_category'];
    $nominal = str_replace('.', '', $_POST['nominal']);

    try {
        $pdo->prepare("CALL pAddExpense(?, ?);")->execute([$expense_category, $nominal]);
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
