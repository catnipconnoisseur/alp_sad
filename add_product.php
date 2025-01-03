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

    // Insert product into database
    try {
        $stmt = $pdo->prepare("INSERT INTO PRODUK(ID_Produk, Nama_Produk, Total_Harga_Beli, Images, status_del) VALUES (:id, :name, :price, :photo, '1')");
        $stmt->execute(['id' => $id, 'name' => $productName, 'price' => $price, 'photo' => $dbPath]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }

    // Handle file upload and conversion to .webp
    if ($photo) {
        $targetDir = "asset/FotoProduk/";
        $targetFile = $targetDir . $photoName;

        // Convert image to .webp
        $image = null;
        $width = 0;
        $height = 0;
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
            $width = imagesx($image);
            $height = imagesy($image);
            $size = min($width, $height);
            $x = ($width - $size) / 2;
            $y = ($height - $size) / 2;

            $croppedImage = imagecrop($image, ['x' => $x, 'y' => $y, 'width' => $size, 'height' => $size]);
            if ($croppedImage) {
                imagewebp($croppedImage, $targetFile);
                imagedestroy($croppedImage);
            }
            imagedestroy($image);
        }
    }

    header("Location: transaction.php");
    exit();
}
