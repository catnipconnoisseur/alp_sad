<?php
session_start();
require_once('./connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['purchase_cart']) && !empty($_SESSION['purchase_cart'])) {

        $q = $pdo->prepare("SELECT fGenPurchaseId();");
        $q->execute();
        $purchaseId = $q->fetchColumn();

        try {
            $pdo->prepare("INSERT INTO PEMBELIAN(ID_Pembelian, Jumlah_Dibeli, Total_Harga_Beli, status_del) VALUES (?, ?, ?, '1');")->execute([
                $purchaseId,
                0,
                0
            ]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

        try {
            $pdo->beginTransaction();

            foreach ($_SESSION['purchase_cart'] as $item) {
                $q = $pdo->prepare("INSERT INTO DETAIL_PEMBELIAN(ID_Produk, ID_Pembelian, Jumlah_Produk_Beli, Harga_Produk_Beli, status_del) VALUES (?, ?, ?, ?, '1');");
                $q->execute([
                    $item['ID_Produk'],
                    $purchaseId,
                    $item['Jumlah_Produk_Beli'],
                    $item['Harga_Produk_Beli']
                ]);

                $q = $pdo->prepare("SELECT Jumlah_Dibeli FROM PEMBELIAN WHERE ID_Pembelian = ?;");
                $q->execute([$purchaseId]);
                $currentJumlahDibeli = $q->fetchColumn();

                $q = $pdo->prepare("SELECT Total_Harga_Beli FROM PEMBELIAN WHERE ID_Pembelian = ?;");
                $q->execute([$purchaseId]);
                $currentTotalHargaBeli = $q->fetchColumn();

                $pdo->prepare("UPDATE PEMBELIAN SET Jumlah_Dibeli = ?, Total_Harga_Beli = ? WHERE ID_Pembelian = ?;")->execute([
                    $currentJumlahDibeli + $item['Jumlah_Produk_Beli'],
                    $currentTotalHargaBeli + $item['Harga_Produk_Beli'] * $item['Jumlah_Produk_Beli'],
                    $purchaseId
                ]);
            }

            $pdo->commit();
            $_SESSION['purchase_cart'] = [];
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Cart is empty.']);
    }
}
