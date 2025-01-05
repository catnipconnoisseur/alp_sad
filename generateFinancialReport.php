<?php
require_once('./header.php');

$month = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December',
];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $tahun = $_GET['tahun'];
    $bulan = $_GET['bulan'];

    try {
        $q = $pdo->prepare("SELECT SUM(Jumlah_Biaya) FROM BIAYA_OPERASIONAL WHERE Jenis_Biaya = ? AND MONTH(Tanggal_Biaya) = ? AND YEAR(Tanggal_Biaya) = ?;");
        $q->execute(['Listrik Air', $bulan, $tahun]);
        $waterElectricity = $q->fetchColumn();
        $q->execute(['Transportasi', $bulan, $tahun]);
        $transportation = $q->fetchColumn();
        $q->execute(['Gaji', $bulan, $tahun]);
        $salary = $q->fetchColumn();
        $q->execute(['Biaya Tak Terduga', $bulan, $tahun]);
        $unexpected = $q->fetchColumn();
        $q = $pdo->prepare("SELECT IFNULL(SUM(Total_Harga_Bayar), 0) AS totaltransaksi FROM TRANSAKSI WHERE MONTH(Tanggal_Transaksi) = ? AND YEAR(Tanggal_Transaksi) = ?;");
        $q->execute([
            date('m'),
            date('Y'),
        ]);
        $totalTransaksi = $q->fetch()['totaltransaksi'];
        $q = $pdo->prepare("CALL pGenCashFlow(?, ?);");
        $q->execute([$month[$bulan], $tahun]);
        $cashFlow = $q->fetch()['totalcashflow'];
        $cashFlow = (int) $cashFlow;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$report = [
    'transaction' => $totalTransaksi ?? 0,
    'waterElectricity' => $waterElectricity ?? 0,
    'transportation' => $transportation ?? 0,
    'salary' => $salary ?? 0,
    'unexpected' => $unexpected ?? 0,
    'cashFlow' => $cashFlow ?? 0,
]

?>

<style>
    body {
        background-color: #BABDE2;
    }

    .report-segment {
        font-family: "PoppinsMedium";
        font-size: 32px;
        color: #374375;
    }

    .report-item {
        font-family: "PoppinsMedium";
        font-size: 24px;
        color: #374375;
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
                <li class="nav-item text-white px-5 my-2">
                    <a href="./transaction.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <img src="./asset/money.png" style="width: 32px; height: 32px" alt="homeIcon">
                        <p style="margin-top: 13px; margin-left: 20px">Transaction</p>
                        <img src="./asset/down-arrow.png" style="width: 32px; height: 32px" alt="homeIcon">
                    </a>
                </li>
                <li class="nav-item text-white px-5 my-2">
                    <a href="./purchase.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <img src="./asset/basket.png" style="width: 32px; height: 32px" alt="homeIcon">
                        <p style="margin-top: 13px; margin-left: 20px">Purchase</p>
                        <img src="./asset/up-arrow.png" style="width: 32px; height: 32px" alt="homeIcon">
                    </a>
                </li>
                <li class="nav-item text-white px-5 my-2">
                    <a href="./inventory.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <img src="./asset/briefcase.png" style="width: 32px; height: 32px" alt="homeIcon">
                        <p style="margin-top: 13px; margin-left: 20px">Inventory</p>
                    </a>
                </li>
                <li class="nav-item text-white px-5 my-2" style="background-color: #00160A; width: 100%">
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
        <div class="bg-white px-3 pb-5 d-flex flex-column justify-content-between" style="width: 564px; height: 789px; border: 1px solid black">
            <span class="text-center mt-3" style="font-family: InterExtraBold; font-size: 40px; color: #374375;">Financial Report<br>of Cash Flow</span>
            <span class="report-segment">Income</span>
            <span class="report-item mx-3 row d-flex align-items-center">
                <span class="col-7">Transaction</span>
                <span class="col-5">Rp. <?= number_format($report['transaction'], 0, ',', '.') ?>,-</span>
            </span>
            <span class="report-segment">Expense</span>
            <span class="report-item mx-3 row d-flex align-items-center">
                <span class="col-7">Water and Electricity</span>
                <span class="col-5">Rp. <?= number_format($report['waterElectricity'], 0, ',', '.') ?>,-</span>
            </span>
            <span class="report-item mx-3 row d-flex align-items-center">
                <span class="col-7">Transportation</span>
                <span class="col-5">Rp. <?= number_format($report['transportation'], 0, ',', '.') ?>,-</span>
            </span>
            <span class="report-item mx-3 row d-flex align-items-center">
                <span class="col-7">Salary Expenses</span>
                <span class="col-5">Rp. <?= number_format($report['salary'], 0, ',', '.') ?>,-</span>
            </span>
            <span class="report-item mx-3 row d-flex align-items-center">
                <span class="col-7">Unexpected Costs</span>
                <span class="col-5">Rp. <?= number_format($report['unexpected'], 0, ',', '.') ?>,-</span>
            </span>
            <span class="report-segment row d-flex align-items-center">
                <span class="col-5">Cash Flow</span>
                <span class="col-7" style="text-align: right;"><?= $report['cashFlow'] < 0 ? '-' : '' ?>Rp. <?= str_replace('-', '', number_format($report['cashFlow'], 0, ',', '.')) ?>,-</span>
            </span>
        </div>
    </div>
</div>

<?php
require_once('./footer.php');
