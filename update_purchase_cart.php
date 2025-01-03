<?php
session_start();
require_once('./connection.php');

if (!isset($_SESSION['purchase_cart'])) {
    $_SESSION['purchase_cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];
    $action = $_POST['action'];

    // Fetch product details from the database
    $q = $pdo->prepare("SELECT * FROM PRODUK WHERE ID_Produk = ?");
    $q->execute([$productId]);
    $product = $q->fetch();

    if ($product) {
        $found = false;
        foreach ($_SESSION['purchase_cart'] as &$item) {
            if ($item['ID_Produk'] === $productId) {
                if ($action === 'increase') {
                    $item['Jumlah_Produk_Beli'] += 1;
                } elseif ($action === 'decrease') {
                    $item['Jumlah_Produk_Beli'] -= 1;
                    if ($item['Jumlah_Produk_Beli'] <= 0) {
                        // Remove item if quantity is 0 or less
                        $_SESSION['purchase_cart'] = array_filter($_SESSION['purchase_cart'], function ($i) use ($productId) {
                            return $i['ID_Produk'] !== $productId;
                        });
                    }
                }
                $found = true;
                break;
            }
        }

        if (!$found && $action === 'increase') {
            $_SESSION['purchase_cart'][] = [
                'ID_Produk' => $productId,
                'Jumlah_Produk_Beli' => 1,
                'Harga_Produk_Beli' => $product['Total_Harga_Beli']
            ];
        }

        echo json_encode(['success' => true]);
    }
}
