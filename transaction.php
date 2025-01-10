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
        <div class="d-flex flex-wrap align-items-stretch row">
            <?php
            foreach ($products as $key => $p) {
                $imagePath = $p['Images'] ? '   asset/' . $p['Images'] . '.webp' : './asset/box.png';
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
                            <img src="<?= $imagePath ?>" class="m-2" style="height: 250px" alt="">
                        </div>
                        <div class="row" style="width: 100%;">
                            <div class="col-9">
                                <div id="name" class="text-wrap" style="font-size: 20px"><?= $p['Nama_Produk'] ?></div>
                                <div id="price" class="d-flex justify-content-start align-items-center" style="font-family: PoppinsSemiBold; font-size: 22px">Rp. <?= number_format($p['Harga_Jual'], 0, ',', '.'); ?></div>
                            </div>
                            <div class="col-3 d-flex align-items-center">
                                <button class="btn" id="editButton" style="color: #374375" data-index="<?= $key ?>" data-id="<?= $p['ID_Produk'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                    </svg> Edit</button>
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
            <form id="formTransaksi" action="./receipt.php" method="POST" style="width: 100%">
                <div class="row d-flex align-items-center">
                    <div class="col-5">
                        <span style="font-size: 16px">Customer Name </span>
                    </div>
                    <div class="col-7">
                        <input class="form-control mt-2" name="customerName" type="text">
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
                        <input class="form-control mt-2" name="total" type="text" readonly>
                    </div>
                </div>
                <div class="row d-flex align-items-center">
                    <div class="col-5">
                        <span style="font-size: 16px">Grand Total </span>
                    </div>
                    <div class="col-7">
                        <input class="form-control mt-2" name="grandTotal" type="text" readonly>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-item-center mt-3">
                    <button class="btn d-flex justify-content-center align-items-center" style="padding: 0; font-family: PoppinsMedium; font-size: 20px; width: 239px; height: 43px; background-color: #374375; color: white" type="submit"><img src="./asset/receipt.png" style="width: 24px; height: 24px; margin-right: 15px" alt="">Generate Receipt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3" style="background-color: #BABDE2">
            <div class="modal-header mb-3" style="color: #374375; border: none; padding: 0; margin: 0;">
                <h5 class="modal-title" id="notificationModalLabel"></h5>
            </div>
            <div class="modal-body d-flex justify-content-center align-items-center flex-column" id="modalBody" style="color: #374375; margin: 0; padding: 0; font-family: PoppinsSemiBold; font-size: 40px;">
                <img src="<?= isset($status) && $status == 'success' ? './asset/checked.png' : './asset/no.png' ?>" alt="icon" style="height: 203px;">
                <div id="status" style="font-family: PoppinsSemiBold; font-size: 48px"><?= isset($status) && $status == 'success' ? 'Success' : 'Error' ?></div>
                <div class="text-center" style="font-size: 24px"><?= isset($message) ? $message : ''; ?></div>
            </div>
            <div class="modal-footer d-flex justify-content-center align-items-center" style="border: none; padding: 0; margin: 0;">
                <button type="button" class='btn' style='height: 43px; width: 188px; color: white; background-color: #374375; font-family: PoppinsMedium; font-size: 20px;' data-bs-dismiss='modal'>OK</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        console.log("test");

        // Function to format numbers with thousand separators
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Function to update total and grand total fields
        function updateTotals() {
            var total = 0;
            $("#cart-items tr").each(function() {
                var rowTotal = parseInt($(this).find("td:last").text().replace(/\./g, '')) || 0;
                total += rowTotal;
            });

            $("input[name='total']").val(formatNumber(total).replace(/,/g, '.'));

            var shippingCost = parseInt($("input[name='shippingCost']").val().replace(/\./g, '')) || 0;
            var grandTotal = total + shippingCost;
            $("input[name='grandTotal']").val(formatNumber(grandTotal).replace(/,/g, '.'));
        }

        // Increase button functionality
        $(".increase").click(function() {
            var index = $(this).data("index");
            var currentValue = parseInt($("#input-" + index).text());

            var newValue = currentValue + 1;

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
                    if (response.status === 'success') {
                        // Update the count in the UI after checking with database
                        $("#input-" + index).text(newValue);
                        // Update the cart display with the new cart items
                        var cartHtml = '';
                        $.each(response.cart, function(i, item) {
                            cartHtml += '<tr style="background-color: ' + item.row_color + ';">' +
                                '<td>' + item.Nama_Produk + '</td>' +
                                '<td>' + item.Jumlah_Produk + '</td>' +
                                '<td>' + item.Harga_Produk + '</td>' +
                                '<td>' + item.Total_Harga + '</td>' +
                                '</tr>';
                        });
                        $("#cart-items").html(cartHtml); // Update the table with new cart items
                        updateTotals(); // Update totals
                    } else {
                        showNotificationModal('error', response.message);
                    }
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
                        if (response.status === 'success') {
                            // Update the cart display with the new cart items
                            var cartHtml = '';
                            $.each(response.cart, function(i, item) {
                                cartHtml += '<tr style="background-color: ' + item.row_color + ';">' +
                                    '<td>' + item.Nama_Produk + '</td>' +
                                    '<td>' + item.Jumlah_Produk + '</td>' +
                                    '<td>' + item.Harga_Produk + '</td>' +
                                    '<td>' + item.Total_Harga + '</td>' +
                                    '</tr>';
                            });
                            $("#cart-items").html(cartHtml);
                            updateTotals(); // Update totals
                        } else {
                            showNotificationModal('error', response.message);
                        }
                    }
                });
            }
        });

        // Update totals when shipping cost changes
        $("input[name='shippingCost']").on('input', function() {
            updateTotals();
        });

        // Initial update of totals
        updateTotals();

        // Prevent form submission and show confirmation alert
        $("#formTransaksi").submit(function(event) {
            // Check if any field is empty
            var customerName = $("input[name='customerName']").val().trim();
            var address = $("input[name='address']").val().trim();
            var shippingCost = $("input[name='shippingCost']").val().trim();

            if (customerName === "") {
                showNotificationModal('error', 'Customer Name field cannot be empty.');
                event.preventDefault();
                return false;
            }

            if (address === "") {
                showNotificationModal('error', 'Address field cannot be empty.');
                event.preventDefault();
                return false;
            }

            if (shippingCost === "") {
                showNotificationModal('error', 'Shipping Cost field cannot be empty.');
                event.preventDefault();
                return false;
            }

            // Check if shippingCost contains only numbers and thousand separators
            var shippingCostPattern = /^[0-9.]+$/;
            if (!shippingCostPattern.test(shippingCost)) {
                showNotificationModal('error', 'Shipping Cost must contain only numbers and thousand separators.');
                event.preventDefault();
                return false;
            }
            // Show confirmation alert
            if (!confirm("Are you sure you want to submit the transaction?")) {
                event.preventDefault();
            } else {
                this.submit();
            }
        });
        // Add thousand separators to shipping cost input
        $("input[name='shippingCost']").on('input', function() {
            var value = $(this).val().replace(/\D/g, ''); // Remove non-digit characters
            if (value === "") {
                $(this).val("");
            } else {
                $(this).val(parseInt(value).toLocaleString('de-DE')); // Add thousand separators with dot
            }
            updateTotals();
        });

        // Alert if non-numeric input is detected
        $("input[name='shippingCost']").on('keypress', function(event) {
            if (event.which < 48 || event.which > 57) {
                event.preventDefault();
            }
        });

        function showNotificationModal(status, message) {
            $("#status").text(status === 'success' ? 'Success' : 'Error');
            $("#modalBody img").attr('src', status === 'success' ? './asset/checked.png' : './asset/no.png');
            $("#modalBody .text-center").html(message);
            $("#notificationModal").modal('show');
        }

        $(".btn#editButton").click(function() {
            var index = $(this).data("index");
            var productId = $(this).data("id");
            var isEdit = $(this).text().trim() === "Edit";
            var productDiv = $(this).closest('.row');
            var nameDiv = productDiv.find("#name");
            var priceDiv = productDiv.find("#price");
            var imageDiv = productDiv.closest('.px-3').find("img");
            var originalImagePath = imageDiv.attr('src');

            if (isEdit) {
                $(this).html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16"><path d="M13.485 1.515a.5.5 0 0 1 .707 0l.707.707a.5.5 0 0 1 0 .707l-8 8a.5.5 0 0 1-.708 0L1.5 7.207a.5.5 0 0 1 0-.707l.707-.707a.5.5 0 0 1 .707 0L6 9.293l7.485-7.778z"/></svg> Save');
                var name = nameDiv.text();
                var price = priceDiv.text().replace('Rp. ', '');
                nameDiv.html('<input type="text" class="form-control" style="height:30px; font-size: 20px" value="' + name + '">');
                priceDiv.html('Rp. <input type="text" class="my-1 form-control" style="font-family: PoppinsSemiBold; height:30px; font-size: 22px" value="' + price + '">');
                priceDiv.find("input").on('input', function() {
                    var value = $(this).val().replace(/\D/g, ''); // Remove non-digit characters
                    if (value === "") {
                        $(this).val("");
                    } else {
                        $(this).val(parseInt(value).toLocaleString('de-DE')); // Add thousand separators with dot
                    }
                });

                // Change image to file input
                imageDiv.replaceWith('<div class="m-2" style="height: 250px; width: 250px; display: flex; justify-content: center; align-items: center; background-color: #f0f0f0; border: 1px dashed #ccc;"><input type="file" class="form-control-file" style="display: none;" id="file-input-' + index + '" accept=".jpg,.jpeg,.svg,.png,.webp"><button class="btn btn-secondary" style="color: white; font-family: PoppinsMedium; font-size: 20px; background-color: #374375" onclick="$(\'#file-input-' + index + '\').click();">Choose File</button></div>');
            } else {
                $(this).html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16"><path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/></svg> Edit');
                var newName = nameDiv.find("input").val();
                var newPrice = priceDiv.find("input").val().replace(/\./g, '');
                var fileInput = $("#file-input-" + index)[0];
                var newImage = fileInput.files.length > 0 ? fileInput.files[0] : null;

                nameDiv.text(newName);
                priceDiv.text('Rp. ' + parseInt(newPrice).toLocaleString('de-DE'));

                var formData = new FormData();
                formData.append('productIndex', productId);
                formData.append('newName', newName);
                formData.append('newPrice', newPrice);
                if (newImage) {
                    formData.append('newImage', newImage);
                }

                // Save the updated product information to the database
                $.ajax({
                    url: 'update_product.php',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            showNotificationModal('success', 'Product updated successfully.');

                            // Update the cart session via AJAX to reflect the changes
                            $.ajax({
                                url: 'update_cart.php',
                                method: 'POST',
                                data: {
                                    action: 'update',
                                    productIndex: index,
                                    newName: newName,
                                    newPrice: newPrice,
                                    quantity: -1
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
                                    updateTotals(); // Update totals
                                },
                                error: function() {
                                    showNotificationModal('error', 'Failed to update cart.');
                                }
                            });

                            // Fetch the updated image path from the database
                            $.ajax({
                                url: 'fetch_image.php',
                                method: 'POST',
                                data: {
                                    productId: productId
                                },
                                success: function(response) {
                                    var newImagePath = response.trim();
                                    $("#file-input-" + index).closest('.m-2').replaceWith('<img src="' + newImagePath + '" class="m-2" style="height: 250px" alt="">');
                                },
                                error: function(response) {
                                    console.log(response);
                                    showNotificationModal('error', 'Failed to fetch updated image.');
                                }
                            });
                        } else {
                            showNotificationModal('error', jsonResponse.message);
                        }
                    },
                    error: function() {
                        showNotificationModal('error', 'Failed to update product.');
                    }
                });
            }
        });
    });
</script>

<?php
require_once('./footer.php');
?>