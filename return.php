<?php
require_once('./header.php');
require_once('./connection.php');

$q = $pdo->prepare("SELECT * FROM PRODUK;");
$q->execute();
$products = $q->fetchAll();
$returnCart = $_SESSION['return_cart'] ?? [];
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
                <li class="nav-item text-white px-5 my-2" style="background-color: #00160A; width: 100%">
                    <a href="./return.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <img src="./asset/delivery-box.png" style="width: 32px; height: 32px" alt="homeIcon">
                        <p style="margin-top: 13px; margin-left: 20px">Return</p>
                        <img src="./asset/up-arrow.png" style="width: 32px; height: 32px" alt="homeIcon">
                    </a>
                </li>
                <li class="nav-item text-white px-5 my-2" style="margin-left: 80px">
                    <a href="./return.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <p style="margin-top: 13px; margin-left: 20px">New Return</p>
                    </a>
                    <a href="./historyReturn.php" class="nav-link d-flex justify-content-start align-items-center" style="font-size: 24px; height: 50px">
                        <p style="margin-top: 13px; margin-left: 20px">History</p>
                    </a>
                </li>
            </ul>
        </div>
        <div class="d-flex justify-content-center align-items-center" style="width: 100%; height: 30vh">
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
        <div class="row">
            <?php
            foreach ($products as $key => $p) {
                $imagePath = $p['Images'] ? './asset/' . $p['Images'] . '.webp' : './asset/box.png';
                $cartItem = array_filter($returnCart, function ($item) use ($p) {
                    return $item['ID_Produk'] === $p['ID_Produk'];
                });
                $cartItem = reset($cartItem);
                $quantity = $cartItem['Jumlah_Produk_Retur'] ?? 0;
                $reason = $cartItem['Jenis_Retur'] ?? '';
            ?>
                <div class="col-4 p-5">
                    <div class="px-3" style="background-color: #BABDE2; border: none">
                        <div class="d-flex justify-content-center" style="width: 100%;">
                            <img src="<?= $imagePath ?>" class="m-2" style="height: 250px" alt="">
                        </div>
                        <div style="font-size: 20px"><?= $p['Nama_Produk'] ?></div>
                        <div style="font-family: PoppinsSemiBold; font-size: 22px">Rp. <?= number_format($p['Harga_Jual'], 0, '.', ','); ?></div>
                        <div class="d-flex justify-content-center" style="width: 100%;">
                            <div class="btn d-flex justify-content-between align-items-center overflow-hidden text-white" style="padding: 0; width: 130px; height: 30px; background-color: #374375; border-radius: 50px; border: none;">
                                <button class="btn btn-outline-secondary decrease" style="color: white; padding: 0; border-radius: 50%; width: 30px; height: 30px; border: 3px solid white;" data-index="<?= $key ?>">-</button>
                                <div id="input-<?= $key ?>" class="count-value"><?= $quantity ?></div>
                                <button class="btn btn-outline-secondary increase" style="color: white; padding: 0; border-radius: 50%; width: 30px; height: 30px; border: 3px solid white;" data-index="<?= $key ?>">+</button>
                            </div>
                        </div>
                        <span style="font-size: 20px;">Reason</span>
                        <input class="form-control reason-input" id="reason-<?= $key ?>" style="width: 100%; height: 43px;" value="<?= $reason ?>" <?= $quantity == 0 ? 'disabled' : '' ?> data-index="<?= $key ?>"> </input>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <button id="done-button" class="btn text-white position-sticky" style="bottom: 40px; left: 1450px; width: 150px; background-color: #374375; font-family:PoppinsMedium; font-size: 20px">Done</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var reasonTimeout;
        var productIds = <?= json_encode(array_column($products, 'ID_Produk')) ?>;

        function updateCart(action, index, reason = '') {
            var productId = productIds[index];
            $.ajax({
                url: 'update_return_cart.php',
                type: 'POST',
                data: {
                    action: action,
                    productId: productId,
                    reason: reason
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        var currentValue = parseInt($("#input-" + index).text());
                        if (action === 'increase') {
                            $("#input-" + index).text(currentValue + 1);
                            $("#reason-" + index).prop('disabled', false);
                        } else if (action === 'decrease') {
                            if (currentValue - 1 == 0) {
                                $("#input-" + index).text(0);
                                $("#reason-" + index).prop('disabled', true);
                            } else {
                                $("#input-" + index).text(currentValue - 1);
                            }
                        }
                        console.log(data.cart);
                    } else {
                        alert(data.message);
                    }
                }
            });
        }

        $(".increase").click(function() {
            var index = $(this).data("index");
            var reason = $("#reason-" + index).val();
            updateCart('increase', index, reason);
        });

        $(".decrease").click(function() {
            var index = $(this).data("index");
            var currentValue = parseInt($("#input-" + index).text());
            if (currentValue > 0) {
                updateCart('decrease', index);
            } else {
                alert("Quantity is already zero");
            }
        });

        $(".reason-input").on('input', function() {
            var index = $(this).data("index");
            var reason = $(this).val();
            clearTimeout(reasonTimeout);
            reasonTimeout = setTimeout(function() {
                updateCart('update_reason', index, reason);
            }, 500);
        });

        $("#done-button").click(function() {
            if (<?= empty($returnCart) ? 'true' : 'false' ?>) {
                alert("Return cart is empty");
                return;
            }
            $.ajax({
                url: 'commit_return.php',
                type: 'POST',
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        alert("Return committed successfully!");
                        location.reload(); // Reload the page to reset the view
                    } else {
                        alert(data.message);
                    }
                }
            });
        });
    });
</script>

<?php
require_once('./footer.php');
