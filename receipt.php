<?php
require_once('./header.php');

$q = $pdo->prepare("SELECT fGenTransactionId();");
$q->execute();

$noNota = $q->fetchColumn();

$date = new DateTime();

$day = $date->format('d');
$month = (int)$date->format('m');
$year = $date->format('Y');

$formattedDate = $day . '/' . $month . '/' . $year;

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
if (count($cart) > 0) {
    $cart[] = [
        'ID_Produk' => -1,
        'Nama_Produk' => "Shipping Cost",
        'Jumlah_Produk' => '',
        'Harga_Produk' => 0,
        'Total_Harga' => str_replace('.', '', $_POST['shippingCost'])
    ];
}

$grandTotal = isset($_POST['grandTotal']) ? $_POST['grandTotal'] : 0;

$itemsPerPage = 10;

$cartChunks = array_chunk($cart, $itemsPerPage);

if (count($cartChunks) <= 0) {
    $cartChunks = [['error' => "tidak ada item di cart"]];
} else {
    $pdo->prepare("INSERT INTO TRANSAKSI(ID_Transaksi, Tanggal_Transaksi, Nama_Pembeli, Jumlah_Barang_Beli, Total_Harga_Bayar, Alamat, Biaya_Ongkir, status_del)
        VALUES(:id_transaksi, :tanggaltransaksi, :namapembeli, 0, 0, :alamat, :biayaongkir, '1');")->execute([
        'id_transaksi' => $noNota,
        'tanggaltransaksi' => $date->format('Y-m-d H:i:s'),
        'namapembeli' => $_POST['customerName'],
        'alamat' => $_POST['address'],
        'biayaongkir' => str_replace('.', '', $_POST['shippingCost'])
    ]);
    foreach ($_SESSION['cart'] as $c) {
        if ($c['ID_Produk'] == -1) {
            continue;
        }
        $pdo->prepare("CALL pCreateTransaction(:id_transaksi, :namapembeli, :jumlahtotal, :totalbayar, :alamat, :biayaongkir, :idproduk, :jumlahsatuan, :hargasatuan, :totalharga)")->execute([
            'id_transaksi' => $noNota,
            'namapembeli' => $_POST['customerName'],
            'jumlahtotal' => $c['Jumlah_Produk'],
            'totalbayar' => $c['Total_Harga'],
            'alamat' => $_POST['address'],
            'biayaongkir' => str_replace('.', '', $_POST['shippingCost']),
            'idproduk' => $c['ID_Produk'],
            'jumlahsatuan' => $c['Jumlah_Produk'],
            'hargasatuan' => $c['Harga_Produk'],
            'totalharga' => $c['Total_Harga']
        ]);
    }
}

?>

<style>
    body {
        background-color: #BABDE2;
    }

    td {
        height: 36px;
        text-align: center;
        border: 1px solid lightgray;
    }
</style>

<div class="row" style="min-height: 100vh; width: 100vw">
    <div class="col-3 d-flex flex-column justify-content-center align-items-center overflow-hidden position-sticky" style="background-color: #374375; border-radius: 0 50px 50px 0; box-shadow: 10px 0 15px rgba(0, 0, 0, 0.3); top: 0; height: 100vh;">
        <div class="d-flex justify-content-center align-items-center" style="width: 100%; height:30vh">
            <img class="mb-5" src="./asset/logo-nama.png" style="height: 150px;" alt="homeIcon">
        </div>
        <div class="d-flex justify-content-center align-items-center" style="width: 100%; height:40vh; z-index: 1">
            <ul class="navbar-nav mt-4" style="width: 100%">
                <li class="nav-item text-white px-5 my-2">
                    <a href="./index.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <img src="./asset/homepage.png" style="width: 32px; height: 32px" alt="homeIcon">
                        <p style="margin-top: 13px; margin-left: 20px">Home</p>
                    </a>
                </li>
                <li class="nav-item text-white px-5 my-2" style="background-color: #00160A; width: 100%">
                    <a href="./transaction.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <img src="./asset/money.png" style="width: 32px; height: 32px" alt="homeIcon">
                        <p style="margin-top: 13px; margin-left: 20px">Transaction</p>
                        <img src="./asset/up-arrow.png" style="width: 32px; height: 32px" alt="homeIcon">
                    </a>
                </li>
                <li class="nav-item text-white px-5 my-2" style="margin-left: 80px">
                    <a href="./transaction.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <p style="margin-top: 13px; margin-left: 20px">New Order</p>
                    </a>
                    <a href="./historyTransaction.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <p style="margin-top: 13px; margin-left: 20px">History</p>
                    </a>
                </li>
                <li class="nav-item text-white px-5 my-2">
                    <a href="./purchase.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <img src="./asset/basket.png" style="width: 32px; height: 32px" alt="homeIcon">
                        <p style="margin-top: 13px; margin-left: 20px">Purchase</p>
                        <img src="./asset/down-arrow.png" style="width: 32px; height: 32px" alt="homeIcon">
                    </a>
                </li>
                <li class="nav-item text-white px-5 my-2">
                    <a href="./inventory.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <img src="./asset/briefcase.png" style="width: 32px; height: 32px" alt="homeIcon">
                        <p style="margin-top: 13px; margin-left: 20px">Inventory</p>
                    </a>
                </li>
                <li class="nav-item text-white px-5 my-2">
                    <a href="./financialReport.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <img src="./asset/circular-economy.png" style="width: 32px; height: 32px" alt="homeIcon">
                        <p style="margin-top: 13px; margin-left: 20px">Financial Report</p>
                    </a>
                </li>
                <li class="nav-item text-white px-5 my-2">
                    <a href="./return.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <img src="./asset/delivery-box.png" style="width: 32px; height: 32px" alt="homeIcon">
                        <p style="margin-top: 13px; margin-left: 20px">Return</p>
                        <img src="./asset/down-arrow.png" style="width: 32px; height: 32px" alt="homeIcon">
                    </a>
                </li>
            </ul>
        </div>
        <div class="d-flex justify-content-center align-items-center" style="width: 100%; height:30vh">
            <ul class="navbar-nav d-flex justify-content-center align-items-center" style="width: 100%">
                <li class="nav-item text-white px-5" style="margin-top: 50px">
                    <a href="./logout.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <p style="margin-top: 13px; margin-right: 20px">Log Out</p>
                        <img src="./asset/logout.png" style="width: 32px; height: 32px" alt="homeIcon">
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-9 d-flex flex-wrap justify-content-center align-items-center">
        <?php
        foreach ($cartChunks as $pageIndex => $chunk) {
            if (isset($chunk['error'])) {
        ?>
                <div class="bg-white mx-3 <?= count($cartChunks) > 2 ? "mt-5" : "" ?> d-flex flex-column justify-content-between" style="width: 564px; height: 789px; border: 1px solid black">
                    <div>
                        <div class="d-flex justify-content-center align-items-center mt-3" style="width: 100%">
                            <img src="./asset/logo-white.png" style="height: 120px" alt="">
                        </div>
                        <div class="px-3 mt-2">
                            <div class="text-danger text-center" style="font-family: PoppinsExtraBold; font-size: 32px;"><?= $chunk['error'] ?></div>
                            <div class="d-flex justify-content-center">
                                <img src="https://media.tenor.com/tygmFyX1tXoAAAAM/cat-pain.gif" style="height: 500px" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="mx-4 mb-5" style="font-family: InterSemiBold; font-size: 36px; color: #4F5F7F;">

                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="bg-white mx-3 <?= count($cartChunks) > 2 ? "mt-5" : "" ?> d-flex flex-column justify-content-between" style="width: 564px; height: 789px; border: 1px solid black">
                    <div>
                        <div class="d-flex justify-content-center align-items-center mt-3" style="width: 100%">
                            <img src="./asset/logo-white.png" style="height: 120px" alt="">
                        </div>
                        <div class="px-3 mt-5">
                            <div class="d-flex justify-content-between align-items-center" style="width: 100%">
                                <span>No. <?= $noNota ?></span>
                                <span><?= $formattedDate ?></span>
                            </div>
                            <table style="width: 100%;">
                                <thead>
                                    <tr>
                                        <td>Quantity</td>
                                        <td>Product</td>
                                        <td>Price</td>
                                        <td>Total Price (Rp.)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($chunk as $c) {
                                    ?>
                                        <tr>
                                            <td><?= $c['Jumlah_Produk'] ?></td>
                                            <td><?= $c['Nama_Produk'] ?></td>
                                            <td><?= number_format($c['Harga_Produk'], 0, ',', '.'); ?></td>
                                            <td><?= number_format($c['Total_Harga'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <?php if ($pageIndex === count($cartChunks) - 1) { ?>
                                        <tr>
                                            <td colspan="3" style="border: none; text-align: right;">Grand Total Rp. &nbsp;</td>
                                            <td><?= $grandTotal ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mx-4 mb-5" style="font-family: InterSemiBold; font-size: 36px; color: #4F5F7F;">
                        Thank You!
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>


<?php
require_once('./footer.php');
unset($_SESSION['cart']);
