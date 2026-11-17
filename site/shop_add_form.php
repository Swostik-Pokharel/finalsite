<?php
// =========================================================
// shop_add_form.php: the "Add product" form.
// Opened directly from shop.php, OR included by shop_add.php when
// validation fails (then $errors and $old are already set).
// =========================================================
require_once 'includes/database.php';
require_once 'includes/product_validation.php';

$errors = $errors ?? [];
$old = $old ?? [
    'category_id' => filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT) ?: 1,
    'code' => '', 'name' => '', 'price' => '',
];

$categories = $db->query('SELECT categoryID, categoryName FROM Categories ORDER BY categoryID')->fetchAll();

$pageTitle = 'Add product';
$currentPage = 'shop';
$pageScript = 'shop.js';
include 'includes/header.php';
?>

<div class="row g-4">
    <div class="col-md-3"><h1 class="h2">Add product</h1></div>
    <div class="col-md-6">
        <?php showErrors($errors); ?>
        <form action="shop_add.php" method="post" id="product-form" class="panel" novalidate>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['categoryID']; ?>"
                            <?php echo ($cat['categoryID'] == $old['category_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['categoryName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Code</label>
                <input type="text" name="code" id="code" class="form-control" maxlength="10"
                       value="<?php echo htmlspecialchars($old['code']); ?>" aria-describedby="code-help">
                <div id="code-help" class="form-text">Up to 10 letters or numbers, e.g. vdsotm.</div>
                <div class="error-msg" id="code-error"></div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" maxlength="255"
                       value="<?php echo htmlspecialchars($old['name']); ?>">
                <div class="error-msg" id="name-error"></div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">List price ($)</label>
                <input type="text" name="price" id="price" class="form-control" inputmode="decimal"
                       value="<?php echo htmlspecialchars($old['price']); ?>">
                <div class="error-msg" id="price-error"></div>
            </div>
            <button type="submit" class="btn btn-accent">Add product</button>
        </form>
    </div>
    <div class="col-md-3">
        <a href="shop.php?category_id=<?php echo (int) $old['category_id']; ?>">View product list</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
