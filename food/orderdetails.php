<?php
session_start();

// Assuming order details are stored in the session
$orderDetails = isset($_SESSION['orderDetails']) ? $_SESSION['orderDetails'] : array();

// Sample data structure for orderDetails
$orderDetails = array_merge(array(
    'items' => array(),
    'totalPrice' => 0,
    'deliveryCharge' => 0,
    'address' => 'Not provided',
    'expectedDeliveryDate' => '1-2 Hours',
    'deliveryBoy' => 'Vishnu',
    'deliverynum' => '9652792879',
    'ordernum' => '2410091514120507',
), $orderDetails);
?>

