<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="shoppingcart.css">
    <title>Confirmation</title>
</head>
<body>
    <?php 
        $toes = htmlspecialchars($_POST["toes"]);
        $nose = htmlspecialchars($_POST["nose"]);
        $foes = htmlspecialchars($_POST["foes"]);
        $joes = htmlspecialchars($_POST["joes"]);

        $address1 = htmlspecialchars($_POST["address1"]);
        $address2 = htmlspecialchars($_POST["address2"]);
        $city = htmlspecialchars($_POST["city"]);
        $state = htmlspecialchars($_POST["state"]);
        $zip = htmlspecialchars($_POST["zip"]);
        $country = htmlspecialchars($_POST["country"]);
    ?>
    <h1>Confirm Your Order</h1>
    <div id="confirmationInfoDiv">
        <div>
            <ul>
                <li>Toes: <?php echo $toes; ?></li>
                <li>Nose: <?php echo $nose; ?></li>
                <li>Foes: <?php echo $foes; ?></li>
                <li>Joes: <?php echo $joes; ?></li>
            </ul>
        </div>
        <div>
            <?php echo "Address: " . $address1 . " " . $address2 . "<br>" . $city . ", " . $state . " " . $zip . "<br>" . $country; ?>
        </div>
    </div>
</body>
</html>