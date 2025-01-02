<?php
require_once('./connection.php');
session_start();

$returnCart = $_SESSION['return_cart'] ?? [];

if (empty($returnCart)) {
    echo json_encode(['success' => false, 'message' => 'Return cart is empty']);
    exit;
}

try {
    $pdo->beginTransaction();

    foreach ($returnCart as $item) {
        $q = $pdo->prepare("INSERT INTO RETUR (ID_Produk, Nama_Produk, Jumlah_Produk_Retur, Harga_Produk_Return, Total_Harga_Retur, Jenis_Retur) VALUES (?, ?, ?, ?, ?, ?)");
        $q->execute([
            $item['ID_Produk'],
            $item['Nama_Produk'],
            $item['Jumlah_Produk_Retur'],
            $item['Harga_Produk_Return'],
            $item['Total_Harga_Retur'],
            $item['Jenis_Retur']
        ]);
    }

    $pdo->commit();
    $_SESSION['return_cart'] = []; // Reset the return cart
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Failed to commit return: ' . $e->getMessage()]);
}
