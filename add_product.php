<?php
require_once('./connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['productName'];
    $price = (int) str_replace(".", "", $_POST['price']);
    $photo = $_FILES['image']['name'];
    $photoExtension = pathinfo($photo, PATHINFO_EXTENSION);
    $photoName = str_replace(' ', '_', strtolower($productName)) . '.' . $photoExtension;
    $dbPath = "FotoProduk/" . $photoName;
    $dbPath = "FotoProduk/" . $photo;
    $id = strtoupper(substr($productName, 0, 1));
    $q = $pdo->prepare("SELECT MAX(SUBSTR(`ID_Produk`, 2, 3)) AS max_id FROM PRODUK WHERE `ID_Produk` LIKE CONCAT(:id, '%');");
    $q->execute(['id' => $id]);
    $maxid = $q->fetch()['max_id'];

    $id = $id . ($maxid + 100);

    // Handle file upload with the new photo name
    if ($photo) {
        $targetDir = "asset/FotoProduk/";
        $targetFile = $targetDir . $photoName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    }

    // Insert product into database
    $sql = "INSERT INTO PRODUK(ID_Produk, Nama_Produk, Total_Harga_Beli, Images, status_del) VALUES (:id, :name, :price, :photo, '1')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id, 'name' => $productName, 'price' => $price, 'photo' => $dbPath]);

    header("Location: transaction.php");
    exit();
}
