<?php
require_once('./connection.php'); // Include your database configuration file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productIndex = $_POST['productIndex'];
    $newName = $_POST['newName'];
    $newPrice = $_POST['newPrice'];
    $newImage = isset($_FILES['newImage']) ? $_FILES['newImage'] : null;

    // Prepare and execute the update query
    $q = $pdo->prepare("UPDATE PRODUK SET Nama_Produk = :newName, Harga_Jual = :newPrice WHERE ID_Produk = :productIndex");
    $q->bindParam(':newName', $newName);
    $q->bindParam(':newPrice', $newPrice);
    $q->bindParam(':productIndex', $productIndex);

    if ($q->execute()) {
        $response = ['success' => true];

        if ($newImage) {
            // Fetch the old image path
            $q = $pdo->prepare("SELECT Images FROM PRODUK WHERE ID_Produk = :productIndex");
            $q->bindParam(':productIndex', $productIndex);
            $q->execute();
            $oldImagePath = $q->fetchColumn();

            // Handle file upload and conversion to .webp
            $photoExtension = pathinfo($newImage['name'], PATHINFO_EXTENSION);
            $photoName = str_replace(' ', '_', strtolower($newName)) . '_' . date('Ymd') . '.webp';
            $dbPath = "FotoProduk/" . pathinfo($photoName, PATHINFO_FILENAME);
            $targetDir = "asset/FotoProduk/";
            $targetFile = $targetDir . $photoName;

            // Convert image to .webp
            $image = null;
            switch ($photoExtension) {
                case 'jpg':
                case 'jpeg':
                    $image = imagecreatefromjpeg($newImage['tmp_name']);
                    break;
                case 'png':
                    $image = imagecreatefrompng($newImage['tmp_name']);
                    break;
                case 'svg':
                    // Convert SVG to raster image (e.g., PNG) before converting to .webp
                    $svgContent = file_get_contents($newImage['tmp_name']);
                    $image = imagecreatefromstring($svgContent);
                    break;
                case 'webp':
                    $image = imagecreatefromwebp($newImage['tmp_name']);
                    break;
            }

            if ($image) {
                $width = imagesx($image);
                $height = imagesy($image);
                $size = min($width, $height);
                $x = ($width - $size) / 2;
                $y = ($height - $size) / 2;

                $croppedImage = imagecreatetruecolor($size, $size);
                imagecopyresampled($croppedImage, $image, 0, 0, $x, $y, $size, $size, $size, $size);
                if (!imagewebp($croppedImage, $targetFile)) {
                    echo json_encode(['success' => false, 'message' => 'Failed to convert the image to .webp.']);
                }
                imagedestroy($croppedImage);
                imagedestroy($image);

                // Update the image path in the database
                $q = $pdo->prepare("UPDATE PRODUK SET Images = :dbPath WHERE ID_Produk = :productIndex");
                $q->bindParam(':dbPath', $dbPath);
                $q->bindParam(':productIndex', $productIndex);
                $q->execute();

                // Delete the old image file if the paths are different
                if ($oldImagePath && $oldImagePath !== $dbPath && file_exists("asset/" . $oldImagePath . ".webp")) {
                    $fullPath = "asset/" . $oldImagePath . ".webp";

                    if (file_exists($fullPath)) {
                        if (!unlink($fullPath)) {
                            echo json_encode(['success' => false, 'message' => 'Failed to delete the old image file.']);
                        }
                    } else {
                        echo json_encode(['success' => false, 'message' => 'The old image file does not exist.']);
                    }
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create an image resource.']);
            }
        }
        echo json_encode($response);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update the product.']);
    }
}
