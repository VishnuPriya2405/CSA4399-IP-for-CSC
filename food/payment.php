<?php
// payment.php

session_start();

// Mock order details (in a real scenario, retrieve these from your database or session)
$orderDetails = [
    'totalPrice' => 50.00,
    'deliveryCharge' => 0.00,
    'items' => [
        ['item' => 'Pizza', 'price' => 25.00, 'count' => 1],
        ['item' => 'Pasta', 'price' => 25.00, 'count' => 1]
    ]
];

// Handling the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentMethod = $_POST['payment_method'] ?? '';
    $upiId = $_POST['upi_id'] ?? '';
    $bankName = $_POST['bank_name'] ?? '';
    $loginId = $_POST['login_id'] ?? '';
    $loginPassword = $_POST['login_password'] ?? '';
    $paymentPassword = $_POST['payment_password'] ?? '';
    $otp = $_POST['otp'] ?? '';
    $review = $_POST['review'] ?? '';
    $suggestion = $_POST['suggestion'] ?? '';

    // Mock payment processing
    $isPaymentSuccessful = true;

    if ($isPaymentSuccessful) {
        // Assuming payment was successful
        $_SESSION['payment_status'] = 'success';
        $_SESSION['super_coins'] = 50; // Reward super coins
        $_SESSION['review'] = $review;
        $_SESSION['suggestion'] = $suggestion;

        // Redirect to success page
        header('Location: payment_success.php');
        exit;
    } else {
        $_SESSION['payment_status'] = 'failure';
        // Redirect to failure page or display an error
        header('Location: payment_failure.php');
        exit;
    }
}
?>

<!-- Payment form -->
<form method="post" action="payment.php">
    <input type="hidden" name="payment_method" value="<?= htmlspecialchars($paymentMethod) ?>">
    
    <?php if ($paymentMethod === 'UPI'): ?>
        <input type="text" name="upi_id" placeholder="Enter Your UPI ID" required>
    <?php elseif ($paymentMethod === 'Net Banking'): ?>
        <input type="text" name="bank_name" placeholder="Enter Bank Name" required>
        <input type="text" name="login_id" placeholder="Login ID" required>
        <input type="password" name="login_password" placeholder="Login Password" required>
        <input type="password" name="payment_password" placeholder="Payment Password" required>
        <input type="text" name="otp" placeholder="Enter OTP" required>
    <?php endif; ?>

    <input type="submit" value="Proceed with Payment">
</form>

<?php if (isset($_SESSION['payment_status']) && $_SESSION['payment_status'] === 'success'): ?>
    <h2>Payment Successful!</h2>
    <p>You've earned <?= $_SESSION['super_coins'] ?> Super Coins!</p>
    <form method="post" action="submit_review.php">
        <label for="review">Rate Our Service:</label>
        <input type="radio" name="review" value="Good"> Good
        <input type="radio" name="review" value="Bad"> Bad
        <input type="radio" name="review" value="Excellent"> Excellent
        <br>
        <label for="suggestion">Any Suggestions?</label>
        <textarea name="suggestion" placeholder="Share your suggestions..."></textarea>
        <input type="submit" value="Submit">
    </form>
<?php endif; ?>
