<?php
require_once('./header.php');

$q = $pdo->prepare("select * from PRODUK;");
$q->execute();
$products = $q->fetchAll();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

?>
<style>
    body {
        background-color: #BABDE2;
    }

    .form-control {
        border-radius: 50px;
        height: 20px;
        padding: 0 5px 0 5px;
        display: flex;
        align-items: center;
        font-size: 12px;
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
    <div class="col-6">
        <div class="p-5" style="width: 100%;">
            <a href="./addProductTransaction.php" class="btn d-flex justify-content-center align-items-center" style="padding: 0; width: 211px; height: 43px; color: white; font-family: PoppinsMedium; font-size: 20px; background-color: #374375"><img src="./asset/plus.png" style="width: 24px; height: 24px; margin-right: 15px" alt=""><span>Add Product</span></a>
        </div>
        <div class="row">
            <?php
            foreach ($products as $key => $p) {
                $initialQuantity = 0;
                foreach ($cart as $cartItem) {
                    if ($cartItem['ID_Produk'] == $p['ID_Produk']) {
                        $initialQuantity = $cartItem['Jumlah_Produk'];
                        break;
                    }
                }
            ?>
                <div class="col-6 p-5">
                    <div class="px-3" style="background-color: #BABDE2; border: none">
                        <div class="d-flex justify-content-center" style="width: 100%;">
                            <img src="./asset/Winton.webp" class="m-2" style="height: 250px" alt="">
                        </div>
                        <div class="d-flex justify-content-between align-items-center" style="width: 100%;">
                            <div>
                                <div style="font-size: 20px"><?= $p['Nama_Produk'] ?></div>
                                <div style="font-family: PoppinsSemiBold; font-size: 22px">Rp. <?= number_format($p['Harga_Jual'], 0, '.', ','); ?></div>
                            </div>
                            <div>
                                <button class="btn" style="color: #374375">Edit</button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center" style="width: 100%;">
                            <div class="btn d-flex justify-content-between align-items-center overflow-hidden text-white" style="padding: 0; width: 130px; height: 30px; background-color: #374375; border-radius: 50px; border: none;">
                                <button class="btn btn-outline-secondary decrease" style="color: white; padding: 0; border-radius: 50%; width: 30px; height: 30px; border: 3px solid white;" data-index="<?= $key ?>">-</button>
                                <!-- Set the initial value for each product based on the session -->
                                <div id="input-<?= $key ?>" class="count-value"><?= $initialQuantity ?></div>
                                <button class="btn btn-outline-secondary increase" style="color: white; padding: 0; border-radius: 50%; width: 30px; height: 30px; border: 3px solid white;" data-index="<?= $key ?>">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="col-3 bg-white position-sticky overflow-hidden d-flex flex-column justify-content-between align-items-center py-5" style="height: 100vh; padding: 0; top: 0;">
        <div style="font-family: PoppinsMedium; font-size: 32px;">Order Details</div>
        <div style="width: 100%; overflow-y: auto; max-height: 60vh">
            <table class="text-center" style="width: 100%; border-radius: 0;">
                <thead>
                    <tr class="text-white" style="background-color: #9FA4EA">
                        <td>Product</td>
                        <td>Quantity</td>
                        <td>Price</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <?php
                    if (isset($_SESSION['cart'])) {
                        $even = false;
                        foreach ($_SESSION['cart'] as $c) {
                    ?>
                            <tr style="background-color: <?= $even ? '#9FA4EA' : '#FFFFFF' ?>;">
                                <td><?= $c['Nama_Produk'] ?></td>
                                <td><?= $c['Jumlah_Produk'] ?></td>
                                <td><?= number_format($c['Harga_Produk'], 0, ',', '.'); ?></td>
                                <td><?= number_format($c['Total_Harga'], 0, ',', '.'); ?></td>
                            </tr>
                    <?php
                            $even = !$even;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="px-2" style="width: 100%">
            <form style="width: 100%">
                <div class="row d-flex align-items-center">
                    <div class="col-5">
                        <span style="font-size: 16px">Customer Name </span>
                    </div>
                    <div class="col-7">
                        <input class="form-control mt-2" name="curtomerName" type="text">
                    </div>
                </div>
                <div class="row d-flex align-items-center">
                    <div class="col-5">
                        <span style="font-size: 16px">Address </span>
                    </div>
                    <div class="col-7">
                        <input class="form-control mt-2" name="address" type="text">
                    </div>
                </div>
                <div class="row d-flex align-items-center">
                    <div class="col-5">
                        <span style="font-size: 16px">Shipping Cost </span>
                    </div>
                    <div class="col-7">
                        <input class="form-control mt-2" name="shippingCost" type="text">
                    </div>
                </div>
                <div class="row d-flex align-items-center">
                    <div class="col-5">
                        <span style="font-size: 16px">Total </span>
                    </div>
                    <div class="col-7">
                        <input class="form-control mt-2" name="total" type="text">
                    </div>
                </div>
                <div class="d-flex justify-content-center align-item-center mt-3">
                    <a href="./receipt.php" class="btn d-flex justify-content-center align-items-center" style="padding: 0; font-family: PoppinsMedium; font-size: 20px; width: 239px; height: 43px; background-color: #374375; color: white" type="submit"><img src="./asset/receipt.png" style="width: 24px; height: 24px; margin-right: 15px" alt="">Generate Receipt</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Increase button functionality
        $(".increase").click(function() {
            var index = $(this).data("index");
            var currentValue = parseInt($("#input-" + index).text());

            // Increment the count in the UI
            var newValue = currentValue + 1;
            $("#input-" + index).text(newValue);

            // Update the cart session via AJAX
            $.ajax({
                url: 'update_cart.php',
                method: 'POST',
                data: {
                    action: 'add',
                    productIndex: index,
                    quantity: newValue
                },
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    // Update the cart display with the new cart items
                    var cartHtml = '';
                    $.each(response, function(i, item) {
                        cartHtml += '<tr style="background-color: ' + item.row_color + ';">' +
                            '<td>' + item.Nama_Produk + '</td>' +
                            '<td>' + item.Jumlah_Produk + '</td>' +
                            '<td>' + item.Harga_Produk + '</td>' +
                            '<td>' + item.Total_Harga + '</td>' +
                            '</tr>';
                    });
                    $("#cart-items").html(cartHtml); // Update the table with new cart items
                }
            });
        });

        // Decrease button functionality
        $(".decrease").click(function() {
            var index = $(this).data("index");
            var currentValue = parseInt($("#input-" + index).text());

            if (currentValue > 0) {
                // Decrement the count in the UI
                var newValue = currentValue - 1;
                $("#input-" + index).text(newValue);

                // Update the cart session via AJAX
                $.ajax({
                    url: 'update_cart.php',
                    method: 'POST',
                    data: {
                        action: 'remove',
                        productIndex: index,
                        quantity: newValue
                    },
                    dataType: 'json', // Expect JSON response
                    success: function(response) {
                        // Update the cart display with the new cart items
                        var cartHtml = '';
                        $.each(response, function(i, item) {
                            cartHtml += '<tr style="background-color: ' + item.row_color + ';">' +
                                '<td>' + item.Nama_Produk + '</td>' +
                                '<td>' + item.Jumlah_Produk + '</td>' +
                                '<td>' + item.Harga_Produk + '</td>' +
                                '<td>' + item.Total_Harga + '</td>' +
                                '</tr>';
                        });
                        $("#cart-items").html(cartHtml);
                    }
                });
            }
        });
    });
</script>

<?php
require_once('./footer.php');
