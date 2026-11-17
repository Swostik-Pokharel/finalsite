<?php
// =========================================================
// shop_add.php: INSERT a new product (receives the add form's POST)
// =========================================================
require 'includes/database.php';
require 'includes/product_validation.php';

// Only accept form submissions, not someone typing the URL
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: shop.php');
    exit();
}

// Read and tidy the input
$old = [
    'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT),
    'code'  => trim($_POST['code'] ?? ''),
    'name'  => trim($_POST['name'] ?? ''),
    'price' => trim($_POST['price'] ?? ''),
];

$errors = validateProduct($old['code'], $old['name'], $old['price']);

// Category must be a real one
if (!$old['category_id']) {
    array_push($errors, 'Please choose a category.');
    $old['category_id'] = 1;
}

// Code must not already exist (the column is UNIQUE, but a friendly message beats an SQL error)
if (count($errors) === 0) {
    $check = $db->prepare('SELECT COUNT(*) FROM Products WHERE productCode = :code');
    $check->execute([':code' => $old['code']]);
    if ($check->fetchColumn() > 0) {
        array_push($errors, 'That product code is already used. Please pick another.');
    }
}

// Errors? Show the form again with the messages and what they typed.
if (count($errors) > 0) {
    include 'shop_add_form.php';
    exit();
}

// ---------- INSERT ----------
$statement = $db->prepare(
    'INSERT INTO Products (categoryID, productCode, productName, listPrice)
     VALUES (:category_id, :code, :name, :price)'
);
$statement->execute([
    ':category_id' => $old['category_id'],
    ':code'  => $old['code'],
    ':name'  => $old['name'],
    ':price' => $old['price'],
]);

// Redirect after POST: refreshing the list page won't re-submit the form
header('Location: shop.php?category_id=' . $old['category_id'] . '&msg=added');
exit();
