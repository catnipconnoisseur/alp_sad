<?php
require_once('./header.php');
?>

<style>
    body {
        background-color: #BABDE2;
    }

    .form-control::placeholder {
        color: white;
    }

    .form-control[type="file"] {
        background-color: #BABDE2 !important;
        color: white !important;
        border: 1px solid #374375 !important;
        height: 62px !important;
    }

    .form-control[type="file"]::file-selector-button {
        background-color: #374375 !important;
        color: white !important;
        border: 0 !important;
        border-radius: 10px !important;
        height: 100% !important;
        margin: 0 15px 0 0 !important;
    }

    .form-control[type="file"]::file-selector-button:hover {
        background-color: #BABDE2 !important;
        cursor: pointer !important;
    }
</style>

<div class="row" style="min-height: 100vh; width: 100vw">
    <div class="col-3 d-flex flex-column justify-content-center align-items-center overflow-hidden position-sticky" style="background-color: #374375; border-radius: 0 50px 50px 0; box-shadow: 10px 0 15px rgba(0, 0, 0, 0.3); top: 0; height: 100vh;">
        <div class="d-flex justify-content-center align-items-center" style="width: 100%; height:30vh">
            <img class="mb-5" src="./asset/logo-nama.png" style="height: 150px;" alt="homeIcon">
        </div>
        <div class="d-flex justify-content-center align-items-center" style="width: 100%; height:40vh">
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
    <div class="col-9">
        <h1 class="text-left mx-5 mt-5 d-flex justify-content-start align-items-center" style="font-family: PoppinsBold; font-size:48px; color: #FFFCF5; width: 100%"><a href="./transaction.php"><img src="./asset/arrow.png" style="margin-right: 20px" alt=""></a>Add Product</h1>
        <form class="d-flex align-items-end flex-column mx-5 mt-3" action="add_product.php" method="POST" enctype="multipart/form-data">
            <label class="form-label text-left mt-5" style="font-family: PoppinsMedium; font-size:24px; color: #000000; width: 100%">Products Name</label>
            <input type="text" class="form-control" name="productName" style="background-color: #BABDE2; color: white; border: 1px solid #374375; height: 62px" placeholder="ex : semen putih">
            <label class="form-label text-left mt-5" style="font-family: PoppinsMedium; font-size:24px; color: #000000; width: 100%">Price</label>
            <input type="text" class="form-control" name="price" style="background-color: #BABDE2; color: white; border: 1px solid #374375; height: 62px" placeholder="ex : 50.000">
            <label class="form-label text-left mt-5" style="font-family: PoppinsMedium; font-size:24px; color: #000000; width: 100%">Photo (Optional)</label>
            <input type="file" class="form-control p-2" name="image" accept=".jpg, .png, .jpeg, .svg, .webp">
            <button type="submit" class="btn mt-5" style="background-color: #374375; color: white; width: 114px">Save</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const priceInput = document.querySelector('input[name="price"]');

        priceInput.addEventListener('input', function(e) {
            let value = e.target.value;
            value = value.replace(/\D/g, '');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            e.target.value = value;
        });
    });
</script>

<?php
require_once('./footer.php');
