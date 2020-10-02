<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="shoppingcart.css">
    <title>View Cart</title>
</head>
<body>
    <h1>Your Cart</h1>
    <div id=viewCartDiv>
        <div>Adjust the number of items before checkout</div>
        <div id="formLabelDiv">
            <div id="labelDiv">
                <label for="toesInput">Toes</label>
                <label for="noseInput">Nose</label>
                <label for="foesInput">Foes</label>
                <label for="joesInput">Joes</label>
            </div>
            <div id="formDiv">
                <form action="checkout.php" method="POST">
                    <?php 
                        $toes = htmlspecialchars($_POST["toes"]);
                        $nose = htmlspecialchars($_POST["nose"]);
                        $foes = htmlspecialchars($_POST["foes"]);
                        $joes = htmlspecialchars($_POST["joes"]);
                    ?>
                    <input type="number" min="0" id="toesInput" name="toes" class="numberInput" placeholder="0" value="<?php echo $toes; ?>"><br>
                    <input type="number" min="0" id="noseInput" name="nose" class="numberInput" placeholder="0" value="<?php echo $nose; ?>"><br>
                    <input type="number" min="0" id="foesInput" name="foes" class="numberInput" placeholder="0" value="<?php echo $foes; ?>"><br>
                    <input type="number" min="0" id="joesInput" name="joes" class="numberInput" placeholder="0" value="<?php echo $joes; ?>">
                    <input type="submit" value="Checkout" id="checkoutButton">
                </form>
            </div>
        </div>
    </div>
</body>
</html>