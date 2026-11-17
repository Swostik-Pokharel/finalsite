<?php
// =========================================================
// shop_edit_form.php: the "Modify product" form (name + price).
// Opened from the Modify button on shop.php, OR included by
// shop_edit.php when validation fails ($errors and $old already set).
// =========================================================
require_once 'includes/database.php';
require_once 'includes/product_validation.php';

$errors = $errors ?? [];

if (!isset($old)) {
    // First visit: load the product's current values from the database
    $productID = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
    $statement = $db->prepare('SELECT productID, categoryID, productName, listPrice FROM Products WHERE productID = :id');
    $statement->execute([':id' => $productID]);
    $product = $statement->fetch();

    if (!$product) {
        header('Location: shop.php'); // unknown or deleted product
        exit();
    }
    $old = [
        'product_id'  => $product['productID'],
        'category_id' => $product['categoryID'],
        'name'        => $product['productName'],
        'price'       => $product['listPrice'],
    ];
}

$pageTitle = 'Modify product';
$currentPage = 'shop';
$pageScript = 'shop.js';
include 'includes/header.php';
?>

<div class="row g-4">
    <div class="col-md-3"><h1 class="h2">Modify product</h1></div>
    <div class="col-md-6">
        <?php showErrors($errors); ?>
        <form action="shop_edit.php" method="post" id="product-form" class="panel" novalidate>
            <input type="hidden" name="product_id" value="<?php echo (int) $old['product_id']; ?>">
            <input type="hidden" name="category_id" value="<?php echo (int) $old['category_id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" maxlength="255"
                       value="<?php echo htmlspecialchars($old['name']); ?>">
                <div class="error-msg" id="name-error"></div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price ($)</label>
                <input type="text" name="price" id="price" class="form-control" inputmode="decimal"
                       value="<?php echo htmlspecialchars($old['price']); ?>">
                <div class="error-msg" id="price-error"></div>
            </div>
            <button type="submit" class="btn btn-accent">Save changes</button>
        </form>
    </div>
    <div class="col-md-3">
        <a href="shop.php?category_id=<?php echo (int) $old['category_id']; ?>">View product list</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
