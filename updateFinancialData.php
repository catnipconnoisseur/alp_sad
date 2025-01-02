<?php
require 'connection.php';

if (isset($_GET['tahun']) && isset($_GET['bulan'])) {
    $tahun = $_GET['tahun'];
    $bulan = $_GET['bulan'];

    $q = $pdo->prepare("SELECT IFNULL(SUM(Total_Harga_Beli), 0) AS totalpembelian FROM PEMBELIAN WHERE MONTH(Tanggal_Pembelian) = ? AND YEAR(Tanggal_Pembelian) = ?;");
    $q->execute([
        $bulan,
        $tahun,
    ]);
    $totalPembelian = $q->fetch()['totalpembelian'];
    $q = $pdo->prepare("SELECT IFNULL(SUM(Jumlah_Biaya), 0) AS totalexpense FROM BIAYA_OPERASIONAL WHERE MONTH(Tanggal_Biaya) = ? AND YEAR(Tanggal_Biaya) = ?;");
    $q->execute([
        $bulan,
        $tahun,
    ]);
    $totalExpense = $q->fetch()['totalexpense'];
    $q = $pdo->prepare("SELECT IFNULL(SUM(Total_Harga_Bayar), 0) AS totaltransaksi FROM TRANSAKSI WHERE MONTH(Tanggal_Transaksi) = ? AND YEAR(Tanggal_Transaksi) = ?;");
    $q->execute([
        $bulan,
        $tahun,
    ]);
    $totalTransaksi = $q->fetch()['totaltransaksi'];
    echo json_encode([
        'totalSales' => 'Rp ' . number_format($totalTransaksi, 0, ',', '.'),
        'totalExpense' => 'Rp ' . number_format($totalExpense + $totalPembelian, 0, ',', '.'),
    ]);
} else {
    echo json_encode([
        'error' => 'Invalid parameters'
    ]);
}
