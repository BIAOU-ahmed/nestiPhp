

<?php
if(isset($_POST['order'])){
    $orderId = (INT) trim($_POST['order']);
    $order = OrdersDao::findById($orderId);
    $orderLines = $order->getOrderLines();
    
    foreach($orderLines as $lines){
        ?>
       <h1> <?=$lines->getArticle()->getUnitQuantity().' '.$lines->getArticle()->getUnit()->getName().' de '.$lines->getArticle()->getProduct()->getName() ." x ".$lines->getQuantity() ?>  </h1>
       <?php
    }
}