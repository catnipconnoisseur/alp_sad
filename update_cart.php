<?php
session_start();
require_once("./connection.php");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'];
$productIndex = $_POST['productIndex'];
$quantity = $_POST['quantity'];

$q = $pdo->prepare("select * from PRODUK;");
$q->execute();
$products = $q->fetchAll();

$product = $products[$productIndex];

if ($action == 'add') {
    $found = false;
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['ID_Produk'] == $product['ID_Produk']) {
            $cartItem['Jumlah_Produk'] = $quantity;
            $cartItem['Total_Harga'] = $cartItem['Jumlah_Produk'] * $product['Harga_Jual'];
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'ID_Produk' => $product['ID_Produk'],
            'Nama_Produk' => $product['Nama_Produk'],
            'Jumlah_Produk' => $quantity,
            'Harga_Produk' => $product['Harga_Jual'],
            'Total_Harga' => $quantity * $product['Harga_Jual']
        ];
    }
} elseif ($action == 'remove') {
    if ($quantity == 0) {
        foreach ($_SESSION['cart'] as $key => $cartItem) {
            if ($cartItem['ID_Produk'] == $product['ID_Produk']) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
    } else {
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['ID_Produk'] == $product['ID_Produk']) {
                $cartItem['Jumlah_Produk'] = $quantity;
                $cartItem['Total_Harga'] = $cartItem['Jumlah_Produk'] * $product['Harga_Jual'];
                break;
            }
        }
    }
} elseif ($action == 'update') {
    $newPrice = str_replace(".", "", $_POST['newPrice']);
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['ID_Produk'] == $product['ID_Produk']) {
            $cartItem['Nama_Produk'] = $_POST['newName'];
            $cartItem['Harga_Produk'] = $_POST['newPrice'];
            $cartItem['Total_Harga'] = $cartItem['Jumlah_Produk'] * $_POST['newPrice'];
            break;
        }
    }
}

$cartItems = [];
$even = false;
foreach ($_SESSION['cart'] as $c) {
    $cartItems[] = [
        'Nama_Produk' => $c['Nama_Produk'],
        'Jumlah_Produk' => $c['Jumlah_Produk'],
        'Harga_Produk' => number_format($c['Harga_Produk'], 0, ',', '.'),
        'Total_Harga' => number_format($c['Total_Harga'], 0, ',', '.'),
        'row_color' => $even ? '#9FA4EA' : '#FFFFFF'
    ];
    $even = !$even;
}

echo json_encode($cartItems);
