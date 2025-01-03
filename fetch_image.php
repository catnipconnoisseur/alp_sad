<?php
require_once('./connection.php'); // Include your database configuration file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];

    // Fetch the updated image path from the database
    $q = $pdo->prepare("SELECT Images FROM PRODUK WHERE ID_Produk = :productId");
    $q->bindParam(':productId', $productId);
    $q->execute();
    $imagePath = $q->fetchColumn();

    if ($imagePath) {
        echo 'asset/' . $imagePath . '.webp';
    } else {
        echo './asset/box.png';
    }
}
