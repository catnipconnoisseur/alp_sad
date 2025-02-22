<?php
require_once('./connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['productName'];
    $price = (int) str_replace(".", "", $_POST['price']);
    if (isset($_POST['image']) && $_FILES['image']['error'] == 0) {
        $photo = $_FILES['image']['name'];
        $photoExtension = pathinfo($photo, PATHINFO_EXTENSION);
        $photoName = str_replace(' ', '_', strtolower($productName)) . '_' . date('Ymd') . '.webp';
        $dbPath = "FotoProduk/" . pathinfo($photoName, PATHINFO_FILENAME);
    } else {
        $photo = null;
        $photoExtension = null;
        $photoName = null;
        $dbPath = null;
    }
    $q = $pdo->prepare("SELECT fGenProductId(?);");
    $q->execute([$productName]);
    $id = $q->fetchColumn();

    // Validation
    $errors = [];

    if (empty($productName)) {
        $errors[] = "Product name is required.";
    }

    if (empty($price) || !is_numeric(str_replace(".", "", $price))) {
        $errors[] = "Valid price is required.";
    }

    // If validation fails, return error message
    if (!empty($errors)) {
        $_SESSION['notification']['status'] = "error";
        $_SESSION['notification']['message'] = implode("<br>", $errors);
        header("Location: addProductTransaction.php");
        exit();
    }

    // Insert product into database
    try {
        $stmt = $pdo->prepare("INSERT INTO PRODUK(ID_Produk, Nama_Produk, Total_Harga_Beli, Images, status_del) VALUES (:id, :name, :price, :photo, '1')");
        $stmt->execute(['id' => $id, 'name' => $productName, 'price' => $price, 'photo' => $dbPath ?? null]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['notification']['status'] = "error";
        $_SESSION['notification']['message'] = "Failed to add product<br>" . $e->getMessage();
        header("Location: addProductTransaction.php");
        exit;
    }

    // Handle file upload and conversion to .webp
    if ($photo != null) {
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

        if ($image != null) {
            $width = imagesx($image);
            $height = imagesy($image);
            $size = min($width, $height);
            $x = ($width - $size) / 2;
            $y = ($height - $size) / 2;

            $croppedImage = imagecreatetruecolor($size, $size);
            imagecopyresampled($croppedImage, $image, 0, 0, $x, $y, $size, $size, $size, $size);
            imagewebp($croppedImage, $targetFile);
            imagedestroy($croppedImage);
            imagedestroy($image);
        }
    }
    $_SESSION['notification']['status'] = "success";
    $_SESSION['notification']['message'] = "Your new product has been successfully added!";
    header("Location: addProductTransaction.php");
    exit();
}
