<?php
require_once('./connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['productName'];
    $price = (int) str_replace(".", "", $_POST['price']);
    $photo = $_FILES['image']['name'];
    $photoExtension = pathinfo($photo, PATHINFO_EXTENSION);
    $photoName = str_replace(' ', '_', strtolower($productName)) . '_' . date('Ymd') . '.webp';
    $dbPath = "FotoProduk/" . pathinfo($photoName, PATHINFO_FILENAME);
    $q = $pdo->prepare("SELECT fGenProductId(?);");
    $q->execute([$productName]);
    $id = $q->fetchColumn();

    // Handle file upload and conversion to .webp
    if ($photo) {
        $targetDir = "asset/FotoProduk/";
        $targetFile = $targetDir . $photoName;

        // Convert image to .webp
        $image = null;
        switch ($photoExtension) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($_FILES['image']['tmp_name']);
                break;
            case 'png':
                $image = imagecreatefrompng($_FILES['image']['tmp_name']);
                break;
            case 'svg':
                // Convert SVG to raster image (e.g., PNG) before converting to .webp
                $svgContent = file_get_contents($_FILES['image']['tmp_name']);
                $image = imagecreatefromstring($svgContent);
                break;
            case 'webp':
                $image = imagecreatefromwebp($_FILES['image']['tmp_name']);
                break;
        }

        if ($image) {
            imagewebp($image, $targetFile);
            imagedestroy($image);
        }
    }

    // Insert product into database
    $sql = "INSERT INTO PRODUK(ID_Produk, Nama_Produk, Total_Harga_Beli, Images, status_del) VALUES (:id, :name, :price, :photo, '1')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id, 'name' => $productName, 'price' => $price, 'photo' => $dbPath]);

    header("Location: transaction.php");
    exit();
}
