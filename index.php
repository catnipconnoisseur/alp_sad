<?php
require_once('./header.php');

$q = $pdo->prepare("select fBestSellingProducts() as BestSellingProducts;");
$q->execute();
$products = $q->fetchAll();
$product_list = $products[0]['BestSellingProducts'];
$product_array = explode(",", $product_list);

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
                    <div class=" bg-white px-3" style="border-radius: 10px; width: 322px">
                        <p style="font-size: 48px; height: 50px">0</p>
                        <p style="color: red">Current Order</p>
                    </div>
                    <div class=" bg-white px-3" style="border-radius: 10px; width: 322px">
                        <p style="font-size: 48px; height: 50px">0</p>
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
                            foreach ($product_array as $index => $product) {
                                if ($index < 3) { // Only the top 3 ranks will have medals
                                    $medal = $medals[$index];
                                } else {
                                    $medal = "regularmedal.png"; // Placeholder for ranks beyond the top 3
                                }

                                // Display each product in the table
                                echo '
                <tr class="row my-3">
                    <td class="d-flex justify-content-center align-items-center col-2">
                        <img src="./asset/' . $medal . '" style="width: 60px" alt="">
                    </td>
                    <td class="col-5">' . htmlspecialchars(trim($product)) . '</td>
                    <td class="col-5">N/A</td> <!-- Placeholder for total sales -->
                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
require_once('./footer.php');
