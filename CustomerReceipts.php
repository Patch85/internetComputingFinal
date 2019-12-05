<?php
    // Start a session
    session_start();
    // Set initial variables
    $dsn = 'mysql:host=localhost;dbname=music';
    // musicman has global privileges for the music database
    // make sure to create and use a more limited user for customer access
    $dbUsername = 'musicman';
    $dbPassword = 'bQC_2AFWpq46M4N';
    //  Attempt to connect to the database
    try {
        $db = new PDO($dsn, $dbUsername, $dbPassword);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo " <p>An error occurred while connecting to the database: $error_message</p>";
        die();
    }

//session_start();
//$_SESSION['acctNum'] = 1;

$queryGetOrderNumbers = "SELECT *
                         FROM orders
                         WHERE accountNumber=".$_SESSION['acctNum'];
$statementGetOrderNums = $db->prepare($queryGetOrderNumbers);
$statementGetOrderNums->execute();
$orderNums = $statementGetOrderNums->fetchall();
$statementGetOrderNums->closeCursor();

?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <p>Here are your past receipts</p>
    <table border="1">
      <tr>
        <th>Order number</th>
        <th>Account number</th>
        <th>Product Number</th>
        <th>Price</th>
        <th>Quantity</th>
      </tr>

      <?php foreach($orderNums as $orderNum) {
        $QueryGetOrders = "SELECT *
                           FROM order_items
                           WHERE orderNumber=".$orderNum['orderNumber'];
        $statementGetOrders = $db->prepare($QueryGetOrders);
        $statementGetOrders->execute();
        $Orders = $statementGetOrders->fetchall();
        $statementGetOrders->closeCursor();

        foreach($Orders as $Order) {
         ?>
      <tr>
        <td> <?php echo $orderNum['orderNumber']; ?> </td>
        <td> <?php echo $orderNum['accountNumber']; ?> </td>
        <td> <?php echo $Order['productNumber']; ?> </td>
        <td> <?php echo $Order['price']; ?> </td>
        <td> <?php echo $Order['quantity']; ?> </td>
      </tr>
    <?php }
        } ?>
    </table>

  </body>
</html>
