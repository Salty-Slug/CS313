<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="shoppingcart.css">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>
    <div id="checkoutInfoDiv">
        <div>Please provide your address</div>
        <div id="formLabelDiv">
            <div id="labelDiv">
                <label for="address1Input">Address Line 1</label>
                <label for="address2Input">Address Line 2</label>
                <label for="cityInput">City</label>
                <label for="stateInput">State/Province</label>
                <label for="zipInput">Zip/Postal Code</label>
                <label for="countryInput">Country</label>
            </div>
            <div id="checkoutFormDiv">
                <form action="confirmation.php" method="POST">
                    <?php 
                        $toes = htmlspecialchars($_POST["toes"]);
                        $nose = htmlspecialchars($_POST["nose"]);
                        $foes = htmlspecialchars($_POST["foes"]);
                        $joes = htmlspecialchars($_POST["joes"]);
                    ?>
                    <input type="hidden" name="toes" value="<?php echo $toes; ?>">
                    <input type="hidden" name="nose" value="<?php echo $nose; ?>">
                    <input type="hidden" name="foes" value="<?php echo $foes; ?>">
                    <input type="hidden" name="joes" value="<?php echo $joes; ?>">
                    <input type="text" id="address1Input" name="address1"><br>
                    <input type="text" id="address2Input" name="address2"><br>
                    <input type="text" id="cityInput" name="city"><br>
                    <input type="text" id="stateInput" name="state"><br>
                    <input type="text" id="zipInput" name="zip"><br>
                    <input type="text" id="countryInput" name="country"><br>
                    <input type="submit" value="Confirm" id="confirmationButton">
                </form>
            </div>
        </div>
    </div>
</body>
</html>