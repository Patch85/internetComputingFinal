<?php
$dsn = 'mysql:host=localhost;dbname=music';
$user = 'admin';
$pass = 'pa55word';

$db = new PDO($dsn, $user, $pass);

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
