<?php
require_once('./connection.php'); // Include your database configuration file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productIndex = $_POST['productIndex'];
    $newName = $_POST['newName'];
    $newPrice = $_POST['newPrice'];

    // Prepare and execute the update query
    $q = $pdo->prepare("UPDATE PRODUK SET Nama_Produk = :newName, Harga_Jual = :newPrice WHERE ID_Produk = :productIndex");
    $q->bindParam(':newName', $newName);
    $q->bindParam(':newPrice', $newPrice);
    $q->bindParam(':productIndex', $productIndex);

    if ($q->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
