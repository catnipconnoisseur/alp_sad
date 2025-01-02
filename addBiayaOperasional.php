<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expense_category = $_POST['expense_category'];
    $nominal = str_replace('.', '', $_POST['nominal']);

    try {
        $pdo->prepare("CALL pAddExpense(?, ?);")->execute([$expense_category, $nominal]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
