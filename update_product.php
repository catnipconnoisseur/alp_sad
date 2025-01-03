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
                imagewebp($image, $targetFile);
                imagedestroy($image);

                // Move the uploaded file to the target directory
                move_uploaded_file($newImage['tmp_name'], $targetFile);

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
                            $response['success'] = false;
                            $response['message'] = 'Failed to delete the old image file.';
                        }
                    } else {
                        $response['success'] = false;
                        $response['message'] = 'The old image file does not exist.';
                    }
                }
            }
        }
        echo json_encode($response);
    } else {
        echo json_encode(['success' => false]);
    }
}
