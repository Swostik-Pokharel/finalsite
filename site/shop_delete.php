<?php
// =========================================================
// shop_delete.php: DELETE one product (receives a POST from shop.php)
// =========================================================
require 'includes/database.php';

$productID  = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$categoryID = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT) ?: 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $productID) {
    $statement = $db->prepare('DELETE FROM Products WHERE productID = :id');
    $statement->execute([':id' => $productID]);
    header('Location: shop.php?category_id=' . $categoryID . '&msg=deleted');
} else {
    header('Location: shop.php?category_id=' . $categoryID);
}
exit();
