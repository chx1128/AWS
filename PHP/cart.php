<?php
if (isset($_COOKIE['id']) && $_COOKIE['id'] !== 'Guest') {
    $id = $_COOKIE['id'];

    if (session_status() === PHP_SESSION_ACTIVE) {
        session_write_close();
    }

    // Load Guest cart
    session_id('Guest');
    session_start();
    $guestCart = $_SESSION['cart'] ?? [];
    session_write_close();

    // Switch to user session
    session_id($id);
    session_start();

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = $guestCart;
    } else {
        foreach ($guestCart as $guestItem) {
            $merged = false;
            foreach ($_SESSION['cart'] as &$userItem) {
                if (
                    $userItem['hiddenID'] === $guestItem['hiddenID'] 
                ) {
                    $userItem['Qty'] += $guestItem['Qty'];
                    $merged = true;
                    break;
                }
            }
            if (!$merged) {
                $_SESSION['cart'][] = $guestItem;
            }
        }
    }

    // Clear guest cart
    session_write_close();
    session_id('Guest');
    session_start();
    unset($_SESSION['cart']);
    session_write_close();

    // Resume user session
    session_id($id);
    session_start();

} else {
    // Not logged in → treat as guest
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_write_close();
    }
    session_id('Guest');
    session_start();
}


if (isset($_POST['hiddenID'])) {
    $id = $_POST['hiddenID'];

    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['hiddenID'] === $id ) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex
            echo "Item removed.";
            exit;
        }
    }
    echo "Item not found.";
}
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cart</title>
        <style>
            *{
                margin: 0px;
                padding:0px;
            }
            html{
                max-width: 1550px;
                margin:auto;
            }
            .titlePart{
                width: 90%;
                margin:auto;
                margin-top: 40px;
            }
            .titlePart h1{
                font-size: 40px;
            }
            .cartContainer{
                width:90%;
                margin:auto;
                margin-top: 10px;
                margin-bottom: 50px;
                padding-top: 40px;
            }
            .productContainer{
                width:95%;
                height: 300px;
                margin:auto;
                margin-bottom: 50px;
                display:flex;
            }
            .imagePart{
                height: 300px;
                width:300px;
            }
            .detailsPart{
                height: 300px;
                width: 850px;
            }
            .totalPricingPart{
                height: 300px;
                width:150px;
            }
            img{
                width:300px;
                height:300px;
            }
            .detailsInner{
                width:80%;
                height:200px;
                margin:auto;
                margin-top:50px;
            }
            .totalPriceWrap{
                height: 200px;
                margin-top:20px;
                display:flex;
                align-items: center;
                justify-content: center;
            }
            .titleDisplay{
                display:flex;
                margin-top: 20px;
            }
            .productH2{
                width:84%;
                margin-top: 5px;
            }
            .totalH2{
                width:16%;
                margin-top: 5px;
            }
            .subtotalPart{
                display:flex;
                width:95%;
                margin:auto;
            }
            .subtotalH2{
                width:1150px;
                text-align: right;
            }
            .amountH2{
                width:150px;
                display:flex;
                align-items: center;
                justify-content: center;
            }
            .checkClass{
                margin-top: 150px;
                position:absolute;
            }
            .functionalPart{
                display:flex;
                align-items: center;
                width: 115px;
                justify-content: space-between;
                margin-top: 10px;
            }
            .functionalPart button{
                height:30px;
            }
            .functionButton{
                background-color:#F3F3F3;
                width:30px;
                height:30px;
                border:none;
                font-size:20px;
                cursor:pointer;
            }
            input[type="checkbox"] {
                width: 15px;  /* Checkbox width */
                height: 15px; /* Checkbox height */
                transform: scale(1.2);
                appearance: none;
                border: 2px solid #D9D9D9; /* Border color */
                outline: none;
                cursor: pointer;
                background-color: white;
                position:absolute;
                margin-top: 160px;
                margin-left: -5px;
            }
            input[type="checkbox"]:checked{
                background-color: #6EF35D;
            }
            .checkOutSection2{
                width: 98%;
                height: 50px;
                border:1px solid black;
                margin:auto;
                text-align: center;
                margin-top: 50px;
                margin-bottom: 50px;
                line-height: 50px;
                transition:0.3s;
                box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.05),
                    10px -10px 20px rgba(255, 255, 255, 0.9);
                border-radius: 5px;
            }
            .checkOutSection2:hover{
                background-color: rgb(245,245,245);
                border:1.5px solid black;

            }
            .checkOutSection2 button{
                font-family:'Georgia';
                transition:0.3s;
                border:1px solid black;
                box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.05),
                    10px -10px 20px rgba(255, 255, 255, 0.9);
                border-radius: 5px;
                background-color: transparent;
                font-size: 20px;
                leter-spacing:5px;
                cursor: pointer;
                border:none;
                width:100%;
                height:45px;
            }
            .custom-alert {
                position: fixed;
                width:300px;
                text-align: center;
                top: 25px;
                left: 50%;
                transform: translateX(-50%);
                background-color: #ff4d4d;
                color: white;
                padding: 15px 30px;
                border-radius: 5px;
                font-size: 1.2em;
                z-index: 9999;
                box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
                transition: opacity 0.3s ease-in-out;
            }
        </style>
    </head>
    <body>
        <?php
        include('../PHP/header.php');
        ?>
        <div class="titlePart">
            <h1>Cart</h1>
            <hr style="width:150px; margin-left: 0;margin-top:5px;">
            <div class="titleDisplay">
                <h1 class="productH2">Product</h1>
                <h1 class="totalH2">Total (RM)</h1>
            </div>
            <hr style="margin-top: 10px;">
        </div>
        <div class="cartContainer">
            <form action="../PHP/payment-method.php" method="post">
                <?php
                foreach ($_SESSION["cart"] as $key => $item) {
                    $checkboxID = $_SESSION["cart"][$key]["hiddenID"];
                    $value = $_SESSION["cart"][$key]["Price"] * $_SESSION["cart"][$key]["Qty"];
                    echo "<input type='checkbox' name='checkedItems[]' value='{$checkboxID}' class='checkClass' id='check_{$checkboxID}' onclick='saveChecked(\"{$checkboxID}\")'>";
                    echo "<label for='check_{$checkboxID}'>";
                    echo "<div class='productContainer'>";
                    echo "<div class='imagePart'>";
                    echo "<img src='../IMAGE/{$_SESSION["cart"][$key]["Image"]}' style='background-color:rgba(240,240,240,0.4);'>";
                    echo "</div>";
                    echo "<div class='detailsPart'>";
                    echo "<div class='detailsInner'>";
                    echo "<h2>{$_SESSION["cart"][$key]["Name"]}</h2>";
                    echo "<div class='functionalPart'>";
                    echo "<button class='functionButton' type='button' id='decrease_{$checkboxID}'"
                    . " onclick='quantityAdjust(\"{$checkboxID}\", this.id, {$_SESSION["cart"][$key]["Price"]})' name='decrease_quantity'>-</button>";

                    echo "<h2 id='quantity_{$checkboxID}'>{$_SESSION["cart"][$key]["Qty"]}</h2>";
                    echo "<input type='hidden' id='quantity2_{$checkboxID}' value='{$_SESSION["cart"][$key]["Qty"]}'>";

                    echo "<button class='functionButton' type='button' id='increase_{$checkboxID}'"
                    . " onclick='quantityAdjust(\"{$checkboxID}\", this.id, {$_SESSION["cart"][$key]["Price"]})' name='increase_quantity'>+</button>";
                    echo "<button type='button' onclick=\"deleteCartItem('{$item['hiddenID']}')\" style=\"border:none;background:transparent;cursor:pointer;\">";
                    echo "<i class='fa-solid fa-trash' style='font-size:20px;color:black;'></i>";
                    echo "</button>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='totalPricingPart'>";
                    echo "<h2 class='totalPriceWrap' id='h2_{$checkboxID}'>{$value}</h2>";
                    echo "</div>";
                    echo "</div>";
                    echo "</label>";
                }
                ?> 
                <hr style="margin-top:50px;margin-bottom: 15px;">
                <div class="subtotalPart">
                    <h2 class="subtotalH2">Subtotal : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>
                    <h2 class="amountH2" id="grandTotal" name="totalPrice">0.00</h2>
                </div>
                <div class="checkOutSection2">

                    <input type="hidden" id="try1hidden" name="custIDhere" value="<?php echo $id ?>">
                    <button type="submit" onclick="return checkOutChecking(event)">CHECKOUT</button>
                </div>
            </form>
        </div>
        <div style="height:200px;"></div>

<?php
include("../PHP/footer.php");
?>
        <div id="customAlert" style="display:none;" class="custom-alert">
            <p id="alertMessage"></p>
        </div>
        <script>
            function saveChecked(ID) {
                let checkbox = document.getElementById("check_" + ID);
                if (checkbox.checked) {
                    sessionStorage.setItem(ID, "checked");
                } else {
                    sessionStorage.removeItem(ID);
                }
                updateTotal();
            }

            function updateTotal() {
                let total = 0;
                document.querySelectorAll(".checkClass:checked").forEach((checkbox) => {
                    let PID = checkbox.value;
                    let priceElement = document.getElementById("h2_" + PID);
                    if (priceElement) {
                        let price = parseFloat(priceElement.innerText);
                        if (!isNaN(price)) {
                            total += price;
                        }
                    }
                });
                document.getElementById("grandTotal").innerText = total.toFixed(2);
                sessionStorage.setItem("grandTotal", total.toFixed(2));
            }
            function checkOutChecking(event) {
                let checkAmount = 0;
                document.querySelectorAll(".checkClass:checked").forEach((checkbox) => {
                    checkAmount++;
                });

                if (checkAmount == 0) {
                    event.preventDefault();
                    showCustomAlert("No Product selected.");
                    return false;
                }

                return true;
            }


            function quantityAdjust(uniqueValue, elementID, price) {
                let action = document.getElementById(elementID).getAttribute("name");
                let quantityInput = document.getElementById("quantity_" + uniqueValue);
                let totalPriceElem = document.getElementById("h2_" + uniqueValue);
                let quantity = parseInt(quantityInput.innerText);
                let priced = parseFloat(price);

                if (action === "decrease_quantity") {
                    if (quantity <= 1) {
                        alert("Minimum quantity is 1. Use delete button if you want to remove.");
                        return;
                    }
                    quantity--;
                } else if (action === "increase_quantity") {
                    quantity++;
                }

                // Update UI
                quantityInput.innerText = quantity;
                document.getElementById("quantity2_" + uniqueValue).value = quantity;
                totalPriceElem.innerText = (priced * quantity).toFixed(2);

                updateTotal();
            }
            function showCustomAlert(message) {
                const alertBox = document.getElementById("customAlert");
                const alertMessage = document.getElementById("alertMessage");

                alertMessage.textContent = message;
                alertBox.style.display = "block";

                setTimeout(() => {
                    alertBox.style.display = "none";
                }, 2000);
            }
            window.onload = function () {
                let total = 0;
                document.querySelectorAll(".checkClass").forEach((checkbox) => {
                    let ID = checkbox.id.replace("check_", "");
                    if (sessionStorage.getItem(ID) === "checked") {
                        checkbox.checked = true;
                        let priceElement = document.getElementById("h2_" + ID);
                        if (priceElement) {
                            let price = parseFloat(priceElement.innerText);
                            if (!isNaN(price)) {
                                total += price;
                            }
                        }
                    }
                });
                document.getElementById("grandTotal").innerText = total.toFixed(2);
                sessionStorage.setItem("grandTotal", total.toFixed(2));
            };
            function deleteCartItem(hiddenID) {
                if (!confirm("Are you sure you want to remove this item?"))
                    return;

                fetch("", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `hiddenID=${encodeURIComponent(hiddenID)}`
                })
                        .then(res => res.text())
                        .then(response => {
                            console.log(response);
                            location.reload(); // or remove item from DOM if you want it dynamic
                        });
            }

        </script>

    </body>
</html>
