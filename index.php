<?php
require_once('./header.php');

$q = $pdo->prepare("SELECT 
    fBestSellingProducts() as BestSellingProducts,
    p.ID_Produk, 
    p.Nama_Produk,
    IFNULL(SUM(d.Jumlah_Produk), 0) AS Total_Sales
FROM 
    PRODUK p
LEFT JOIN 
    DETAIL_TRANSAKSI d ON p.ID_Produk = d.ID_Produk
GROUP BY 
    p.ID_Produk
ORDER BY 
    Total_Sales DESC
LIMIT 3;");
$q->execute();
$products = $q->fetchAll(PDO::FETCH_ASSOC);
$product_list = $products[0]['BestSellingProducts'];
$product_array = explode(",", $product_list);

$query_current_order = $pdo->prepare("SELECT COUNT(ID_Transaksi) AS 'Current Order'
                                       FROM TRANSAKSI
                                       WHERE DATE(Tanggal_Transaksi) = CURDATE()
                                       AND HOUR(Tanggal_Transaksi) = HOUR(NOW())");
$query_current_order->execute();
$current_order = $query_current_order->fetch();


$query_complete_order = $pdo->prepare("SELECT COUNT(ID_Transaksi) AS 'Complete Order'
                                        FROM TRANSAKSI
                                        WHERE Tanggal_Transaksi < CURDATE() AND Tanggal_Transaksi < NOW();");
$query_complete_order->execute();
$complete_order = $query_complete_order->fetch();
?>

<style>
    body {
        background-color: #BABDE2;
    }
</style>

<div class="row" style="min-height: 100vh; width: 100vw">
    <div class="col-3 d-flex flex-column justify-content-center align-items-center overflow-hidden position-sticky" style="background-color: #374375; border-radius: 0 50px 50px 0; box-shadow: 10px 0 15px rgba(0, 0, 0, 0.3); top: 0; height: 100vh;">
        <div class="d-flex justify-content-center align-items-center" style="width: 100%; height:30vh">
            <img class="mb-5" src="./asset/logo-nama.png" style="height: 150px;" alt="homeIcon">
        </div>
        <div class="d-flex justify-content-center align-items-center" style="width: 100%; height:40vh; z-index: 1">
            <ul class="navbar-nav mt-4" style="width: 100%">
                <li class="nav-item text-white px-5 my-2" style="background-color: #00160A; width: 100%">
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
    <div class="col-9">
        <div class="container">
            <div class="d-flex justify-content-end align-items-center" style="height: 150px">
                <h1 class="text-center" style="font-family: PoppinsExtraBold; color: #374375; width: 100%">WELCOME BACK!</h1>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" style="color: #374375;" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                </svg>
                <div class="bg-white mx-3" style="border: 1px solid black; border-radius: 50%; height: 50px; width: 55px;"></div>
            </div>
            <div class="container mt-5">
                <div class="d-flex justify-content-around align-items-center px-5" style="font-family: PoppinsMedium; font-size: 32px;">
                    <div class="bg-white px-3" style="border-radius: 10px; width: 322px">
                        <p style="font-size: 48px; height: 50px"><?= $current_order['Current Order']; ?></p>
                        <p style="color: red">Current Order</p>
                    </div>

                    <div class="bg-white px-3" style="border-radius: 10px; width: 322px">
                        <p style="font-size: 48px; height: 50px"><?= $complete_order['Complete Order']; ?></p>
                        <p style="color: red">Completed Order</p>
                    </div>
                </div>
                <p style="font-family: PoppinsSemiBold; font-size: 48px; color: #374375; width: 100%; margin-left: 160px; margin-top: 100px">Best Selling Product</p>
                <!-- <div class=" bg-white px-3" style="border-radius: 10px; width: 890px; margin-left: 160px">
                    <table class="text-center" style="width: 100%; font-family:PoppinsMedium; font-size:24px">
                        <thead style="color: red">
                            <tr class="row my-3">
                                <td class="d-flex justify-content-center align-items-center col-2"><img src="./asset/medal.png" alt=""> Rank</td>
                                <td class="col-5">Product</td>
                                <td class="col-5">Total Sales</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="row my-3">
                                <td class="d-flex justify-content-center align-items-center col-2"><img src="./asset/goldmedal.png" style="width: 60px" alt=""></td>
                                <td class="col-5">sad</td>
                                <td class="col-5">asd</td>
                            </tr>
                            <tr class="row my-3">
                                <td class="d-flex justify-content-center align-items-center col-2"><img src="./asset/silvermedal.png" style="width: 60px" alt=""></td>
                                <td class="col-5">sad</td>
                                <td class="col-5">asd</td>
                            </tr>
                            <tr class="row my-3">
                                <td class="d-flex justify-content-center align-items-center col-2"><img src="./asset/bronzemedal.png" style="width: 60px" alt=""></td>
                                <td class="col-5">sad</td>
                                <td class="col-5">asd</td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
                <!-- <div class="bg-white px-3" style="border-radius: 10px; width: 890px; margin-left: 160px">
                    <table class="text-center" style="width: 100%; font-family:PoppinsMedium; font-size:24px">
                        <thead style="color: red">
                            <tr class="row my-3">
                                <td class="d-flex justify-content-center align-items-center col-2"><img src="./asset/medal.png" alt=""> Rank</td>
                                <td class="col-5">Product</td>
                                <td class="col-5">Total Sales</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through the $products array and display each product
                            $medals = ["goldmedal.png", "silvermedal.png", "bronzemedal.png"]; // Medal icons for the top 3 ranks
                            foreach ($products as $index => $product) {
                                if ($index < 3) { // Top 3 only
                                    $medal = $medals[$index];
                                } else {
                                    $medal = "regularmedal.png"; // Placeholder for ranks beyond top 3
                                }
                                echo '
                <tr class="row my-3">
                    <td class="d-flex justify-content-center align-items-center col-2">
                        <img src="./asset/' . $medal . '" style="width: 60px" alt="">
                    </td>
                    <td class="col-5">' . htmlspecialchars($product['BestSellingProducts']) . '</td>
                    <td class="col-5">' . htmlspecialchars($product['TotalSales'] ?? 'N/A') . '</td>
                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div> -->
                <div class="bg-white px-3" style="border-radius: 10px; width: 890px; margin-left: 160px">
                    <table class="text-center" style="width: 100%; font-family:PoppinsMedium; font-size:24px">
                        <thead style="color: red">
                            <tr class="row my-3">
                                <td class="d-flex justify-content-center align-items-center col-2"><img src="./asset/medal.png" alt=""> Rank</td>
                                <td class="col-5">Product</td>
                                <td class="col-5">Total Sales</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Prepare medal icons for the top 3 ranks
                            $medals = ["goldmedal.png", "silvermedal.png", "bronzemedal.png"];

                            // Loop through the product array and display each product in its respective rank
                            // foreach ($product_array as $index => $product) {
                            if (is_array($products) && count($products) > 0) {
                                foreach ($products as $index => $product) {
                                    // Assign medals based on the index
                                    $medal = '';
                                    switch ($index) {
                                        case 0:
                                            $medal = 'goldmedal.png';  // Gold medal for the top product
                                            break;
                                        case 1:
                                            $medal = 'silvermedal.png';  // Silver medal for the second product
                                            break;
                                        case 2:
                                            $medal = 'bronzemedal.png';  // Bronze medal for the third product
                                            break;
                                    }

                                    // Output the product information with the appropriate medal
                                    echo '
                                        <tr class="row my-3">
                                            <td class="d-flex justify-content-center align-items-center col-2">
                                                <img src="./asset/' . $medal . '" style="width: 60px" alt="Medal">
                                            </td>
                                            <td class="col-5">' . htmlspecialchars(trim($product['Nama_Produk'])) . '</td>
                                            <td class="col-5">' . (isset($product['Total_Sales']) ? number_format($product['Total_Sales'], 0, '.', ',') : 'N/A') . '</td>
                                        </tr>';
                                }
                            } else {
                                echo "No products found.";
                            }
                            // }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3" style="background-color: #BABDE2">
            <div class="modal-header mb-3" style="color: #374375; border: none; padding: 0; margin: 0;">
                <h5 class="modal-title" id="notificationModalLabel">Low Stock Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody" style="color: #374375; margin: 0; padding: 0; height: 50px">
                <!-- Notification content will be inserted here -->
            </div>
            <div class="modal-footer" style="border: none; padding: 0; margin: 0;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.bi-bell-fill').addEventListener('click', function() {
            fetch('notify_low_stock.php')
                .then(response => response.json())
                .then(data => {
                    let modalBody = document.querySelector('#modalBody');
                    let closeButton = document.querySelector('.modal-footer .btn');
                    if (data.length > 0) {
                        let message = "Produk dengan stok rendah:<br>";
                        data.forEach(item => {
                            message += `- ${item.Nama_Produk}: ${item.Stock_Tersedia} unit<br>`;
                        });
                        modalBody.innerHTML = message;
                        closeButton.classList.remove('btn-secondary');
                        closeButton.classList.add('btn-warning');
                    } else {
                        modalBody.innerHTML = "Semua produk memiliki stok mencukupi.";
                        closeButton.classList.remove('btn-warning');
                        closeButton.classList.add('btn-secondary');
                    }
                    new bootstrap.Modal(document.getElementById('notificationModal')).show();
                })
                .catch(error => {
                    document.querySelector('#modalBody').innerHTML = `Kesalahan database: ${error.message}`;
                    new bootstrap.Modal(document.getElementById('notificationModal')).show();
                });
        });
    });
</script>

<?php
require_once('./footer.php');
