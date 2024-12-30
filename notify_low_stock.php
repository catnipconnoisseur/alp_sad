<?php
header('Content-Type: application/json');
include 'connection.php';
try {
    $stmt = $pdo->prepare("CALL pNotifyLowStock()");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode([]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => "Kesalahan database: " . $e->getMessage()]);
}
$conn = null;
