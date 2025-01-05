<?php
require_once('./connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $productId = $_POST['productId'];
    $reason = $_POST['reason'] ?? '';

    // Fetch product details
    $q = $pdo->prepare("SELECT * FROM PRODUK WHERE ID_Produk = ?");
    $q->execute([$productId]);
    $product = $q->fetch();

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }

    $stockAvailable = $product['Stock_Tersedia'];
    $currentCart = $_SESSION['return_cart'] ?? [];
    $cartItemKey = array_search($productId, array_column($currentCart, 'ID_Produk'));

    if ($cartItemKey !== false) {
        $currentQuantity = $currentCart[$cartItemKey]['Jumlah_Produk_Retur'];
    } else {
        $currentQuantity = 0;
    }

    switch ($action) {
        case 'increase':
            if ($currentQuantity < $stockAvailable) {
                if ($cartItemKey !== false) {
                    $currentCart[$cartItemKey]['Jumlah_Produk_Retur'] += 1;
                    $currentCart[$cartItemKey]['Jenis_Retur'] = $reason;
                    $currentCart[$cartItemKey]['Total_Harga_Retur'] = $currentCart[$cartItemKey]['Jumlah_Produk_Retur'] * $currentCart[$cartItemKey]['Harga_Produk_Return'];
                } else {
                    $currentCart[] = [
                        'ID_Produk' => $productId,
                        'Nama_Produk' => $product['Nama_Produk'],
                        'Jumlah_Produk_Retur' => 1,
                        'Harga_Produk_Return' => $product['Total_Harga_Beli'],
                        'Total_Harga_Retur' => $product['Total_Harga_Beli'],
                        'Jenis_Retur' => $reason
                    ];
                }
                $_SESSION['return_cart'] = $currentCart;
                echo json_encode(['success' => true, 'cart' => $currentCart]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Stock limit reached']);
            }
            break;

        case 'decrease':
            if ($currentQuantity > 0) {
                if ($currentQuantity == 1) {
                    unset($currentCart[$cartItemKey]);
                } else {
                    $currentCart[$cartItemKey]['Jumlah_Produk_Retur'] -= 1;
                    $currentCart[$cartItemKey]['Total_Harga_Retur'] = $currentCart[$cartItemKey]['Jumlah_Produk_Retur'] * $currentCart[$cartItemKey]['Harga_Produk_Return'];
                }
                $_SESSION['return_cart'] = array_values($currentCart);
                echo json_encode(['success' => true, 'cart' => $_SESSION['return_cart']]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Quantity is already zero']);
            }
            break;

        case 'update_reason':
            if ($currentQuantity > 0) {
                $currentCart[$cartItemKey]['Jenis_Retur'] = $reason;
                $_SESSION['return_cart'] = $currentCart;
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Cannot update reason for item with zero quantity']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
}
