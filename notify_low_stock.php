<?php
header('Content-Type: application/json');
include 'connection.php';
try {
    $stmt = $pdo->prepare("CALL pNotifyLowStock();  ");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $out = false;
    foreach ($result as $row) {
        if ($row['Stock_Tersedia'] <= 0) {
            $out = true;
            break;
        }
    }
    if ($result) {
        echo json_encode(['data' => $result, 'message' => $out ? "RUN OUT OF STOCK" : "LOW STOCK"]);
    } else {
        echo json_encode(['data' => [], 'message' => "Semua Produk Memiliki Stock Mencukupi"]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => "Kesalahan database: " . $e->getMessage()]);
}
$conn = null;
