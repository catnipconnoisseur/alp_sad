<?php
require_once('./header.php');

$q = $pdo->prepare("select * from vLapCashFlow;");
$q->execute();
$returns = $q->fetchAll();
$total_transaksi = $returns[0]['total_transaksi'] ?? 'N/A';
$total_operasional = $returns[0]['total_operasional'] ?? 'N/A';
$formatted_total_transaksi = "Rp. " . number_format($total_transaksi, 0, ',', '.');
$formatted_total_operasional = "Rp. " . number_format($total_operasional, 0, ',', '.');

?>

<style>
    body {
        background-color: #BABDE2;
    }

    .form-select {
        color: white;
        background-color: #374375;
        background-image: url("./asset/down-arrow.png");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 32px;
    }

    .form-select.open {
        background-image: url("./asset/up-arrow.png");
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
    <div class="col-9">
        <h1 class="text-left mx-5 mt-5" style="font-family: PoppinsMedium; font-size:24px; color: #000000; width: 100%">Expense Category</h1>
        <select class="form-select text-white mx-5 mt-3" id="dropdown" style="background-color: #374375; border-radius: 50px; width: 200px; height: 46px" data-bs-theme="dark">
            <option value="">Water and Electricity</option>
            <option value="">Transportation</option>
            <option value="">Salary Expenses</option>
            <option value="">Operational Costs</option>
        </select>
        <h1 class="text-left mx-5 mt-5" style="font-family: PoppinsMedium; font-size:24px; color: #000000; width: 100%">Nominal</h1>
        <form class="d-flex align-items-end flex-column mx-5 mt-3" action="">
            <input type="text" class="form-control" style="background-color: #BABDE2; color: white; border: 1px solid #374375">
            <button type="submit" class="btn mt-5" style="background-color: #374375; color: white; width: 188px">Add</button>
        </form>
        <div class="d-flex mx-5 mt-5">
            <h1 class="text-left" style="font-family: InterExtraBold; font-size:32px; color: #374375; width: 40%">Cash Flow</h1>
            <select class="form-select text-white" id="dropdown2" style="background-color: #374375; border-radius: 50px; width: 200px; height: 46px" data-bs-theme="dark">
                <option value="">January</option>
                <option value="">February</option>
                <option value="">TEST</option>
                <option value="">TEST</option>
            </select>
        </div>
        <div class="container mx-3 mt-5">
            <div class="d-flex" style="font-family: PoppinsMedium; font-size: 22px;">
                <div class=" bg-white px-3 mx-3" style="border-radius: 10px; width: 330px">
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-center align-items-center" style="background-color: rgba(18, 39, 125, 0.17); border-radius: 50px; width: 80px; height: 80px">
                            <img src="./asset/star.png" style="width: 40px; height: 40px" alt="">
                        </div>
                        <div class="mx-3">
                            <p style="color: red; margin-top: 20px">Total Sales</p>
                            <p style="font-size: 24px;"><?= htmlspecialchars($formatted_total_transaksi) ?></p>
                        </div>
                    </div>
                </div>
                <div class=" bg-white px-3 mx-3" style="border-radius: 10px; width: 330px">
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-center align-items-center" style="background-color: rgba(241, 0, 0, 0.17); border-radius: 50px; width: 80px; height: 80px">
                            <img src="./asset/search.png" style="width: 40px; height: 40px" alt="">
                        </div>
                        <div class="mx-3">
                            <p style="color: red; margin-top: 20px">Total Expense</p>
                            <p style="font-size: 24px;"><?= htmlspecialchars($formatted_total_operasional) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" bg-white px-3" style="border-radius: 10px; width: 890px; margin-left: 160px">
            </div>
            <a href="./generateFinancialReport.php" class="btn d-flex justify-content-center align-items-center" style="padding: 0; background-color: #374375; color: white; width: 364px; height: 43px; font-size: 20px; font-family: PoppinsMedium; margin-top: 100px"><img src="./asset/document.png" style="width: 24px; height: 24px; margin-right: 15px" alt="">Generate Financial Report</a>
        </div>
    </div>
</div>

<script>
    const dropdown = document.getElementById('dropdown');

    dropdown.addEventListener('click', () => {
        if (dropdown.classList.contains('open')) {
            dropdown.classList.remove('open');
        } else {
            dropdown.classList.add('open');
        }
    });

    dropdown.addEventListener('blur', () => {
        dropdown.classList.remove('open');
    });

    dropdown.addEventListener('change', () => {
        dropdown.classList.remove('open');
    });

    const dropdown2 = document.getElementById('dropdown2');

    dropdown2.addEventListener('click', () => {
        if (dropdown2.classList.contains('open')) {
            dropdown2.classList.remove('open');
        } else {
            dropdown2.classList.add('open');
        }
    });

    dropdown2.addEventListener('blur', () => {
        dropdown2.classList.remove('open');
    });

    dropdown2.addEventListener('change', () => {
        dropdown2.classList.remove('open');
    });
</script>

<?php
require_once('./footer.php');
