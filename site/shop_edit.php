<?php
// =========================================================
// shop_edit.php: UPDATE a product's name and price (receives the edit form's POST)
// =========================================================
require 'includes/database.php';
require 'includes/product_validation.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: shop.php');
    exit();
}

$old = [
    'product_id'  => filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT),
    'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT) ?: 1,
    'name'        => trim($_POST['name'] ?? ''),
    'price'       => trim($_POST['price'] ?? ''),
];

// The product must be a whole number AND still exist (someone may have deleted it meanwhile)
$exists = false;
if ($old['product_id']) {
    $check = $db->prepare('SELECT COUNT(*) FROM Products WHERE productID = :id');
    $check->execute([':id' => $old['product_id']]);
    $exists = $check->fetchColumn() > 0;
}
if (!$exists) {
    header('Location: shop.php');
    exit();
}

$errors = validateProduct(null, $old['name'], $old['price']); // null = don't check the code

if (count($errors) > 0) {
    include 'shop_edit_form.php';
    exit();
}

// ---------- UPDATE ----------
$statement = $db->prepare(
    'UPDATE Products
     SET productName = :name, listPrice = :price
     WHERE productID = :id'
);
$statement->execute([
    ':name'  => $old['name'],
    ':price' => $old['price'],
    ':id'    => $old['product_id'],
]);

header('Location: shop.php?category_id=' . $old['category_id'] . '&msg=updated');
exit();
