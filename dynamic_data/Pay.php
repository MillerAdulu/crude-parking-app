<?php
    session_start();
    $userId = $_SESSION["userId"];
    $bookId = $_GET["bookId"] . "<br>";
    require_once "../classes/Payment.php";
    $pay = new Payment;
    $pay->setReceiptId($bookId);
    $receiptId = $pay->getReceiptId();
    $pay->setPhoneNumber($userId);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Payments</title>
        <link href="../css/w3.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="w3-display-container">
            <form action="<?php echo htmlentities("ProcessPayment.php");?>" method="post" class="w3-display-middle w3-border w3-padding w3-round-large" style="margin-top: 250px;">
                <label class="w3-label">Receipt Id:</label>
                <input type="text" name="receiptId" value="<?php echo $receiptId ; ?>" class="w3-input"><br>
                <label for="paymentMethod" class="w3-label">Payment Method</label>
                <select name="paymentMethod" class="w3-select">
                    <option value="1">MPESA</option>
                    <option value="2">Visa</option>
                    <option value="3">Master Card</option>
                    <option value="4">Maestro</option>
                </select>
                <label class="w3-label">Phone Number</label>
                <input name="phoneNumber" type="text" value="<?php echo $pay->getPhoneNumber(); ?>" class="w3-input">
                <label class="pay">Amount</label>
                <input name="amount" value="<?php echo $pay->getCharges($receiptId); ?>" readonly class="w3-input">
                <input type="submit" value="Pay" class="w3-btn w3-margin w3-round-medium">
                <a href="../MyProfile.php" class="w3-btn w3-margin w3-round-medium">Cancel</a>
            </form>
        </div>
    </body>
</html>