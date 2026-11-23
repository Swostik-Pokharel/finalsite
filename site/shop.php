<?php
// =========================================================
// shop.php: Merch Manager (the brief's database section)
//   SELECT : list products for the chosen category
//   SORT   : ?sort=asc or ?sort=desc → ORDER BY productName
//   Links to ADD / MODIFY, and a DELETE form on every row
// =========================================================
require 'includes/database.php';

// ---------- Read the URL parameters ----------
// filter_input returns false/null if the value is missing or not a whole number
$categoryID = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
if (!$categoryID) {
    $categoryID = 1; // default: Vinyl
}

// Column names and ASC/DESC can't be bound as ? placeholders, so we WHITELIST them:
// only these exact strings can ever reach the SQL.
$sort = $_GET['sort'] ?? '';
if ($sort === 'asc') {
    $orderBy = 'productName ASC';
} elseif ($sort === 'desc') {
    $orderBy = 'productName DESC';
} else {
    $sort = '';
    $orderBy = 'productID';  // the order they were added
}

// ---------- SELECT all categories (for the sidebar) ----------
$categories = $db->query('SELECT categoryID, categoryName FROM Categories ORDER BY categoryID')->fetchAll();

// ---------- SELECT the current category's name ----------
$statement = $db->prepare('SELECT categoryName FROM Categories WHERE categoryID = :id');
$statement->execute([':id' => $categoryID]);
$category = $statement->fetch();
if (!$category) {
    // Someone typed a category id that doesn't exist: fall back to the first one
    $categoryID = $categories[0]['categoryID'];
    $category = $categories[0];
}

// ---------- SELECT the products in that category ----------
// :id is a PLACEHOLDER. PDO sends the value separately from the SQL text, so a
// visitor can't inject their own SQL (prevents SQL injection).
$statement = $db->prepare(
    "SELECT productID, productCode, productName, listPrice
     FROM Products
     WHERE categoryID = :id
     ORDER BY $orderBy"
);
$statement->execute([':id' => $categoryID]);
$products = $statement->fetchAll();

// ---------- Status message after add / modify / delete ----------
$messages = [
    'added'   => 'Product added.',
    'updated' => 'Product updated.',
    'deleted' => 'Product deleted.',
];
$msg = $_GET['msg'] ?? '';
$status = $messages[$msg] ?? '';

$pageTitle = 'Shop';
$currentPage = 'shop';
include 'includes/header.php';
?>

<h1>Merch Manager</h1>
<p class="lead">Browse the shop by category, or manage the product list below.</p>

<?php if ($status !== ''): ?>
    <p class="success-msg" role="status"><?php echo $status; ?></p>
<?php endif; ?>

<div class="row g-4">
    <!-- Category sidebar -->
    <aside class="col-md-3" aria-labelledby="cat-heading">
        <h2 id="cat-heading" class="h5">Categories</h2>
        <div class="list-group category-list">
            <?php foreach ($categories as $cat): ?>
                <?php $isCurrent = ($cat['categoryID'] == $categoryID); ?>
                <a href="shop.php?category_id=<?php echo $cat['categoryID']; ?><?php echo $sort ? '&sort=' . $sort : ''; ?>"
                   class="list-group-item list-group-item-action<?php echo $isCurrent ? ' active' : ''; ?>"
                   <?php echo $isCurrent ? 'aria-current="true"' : ''; ?>>
                    <?php echo htmlspecialchars($cat['categoryName']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </aside>

    <!-- Product list -->
    <section class="col-md-9" aria-labelledby="products-heading">
        <h2 id="products-heading" class="h4">
            <?php echo htmlspecialchars($category['categoryName']); ?>
            <?php if ($sort === 'asc'): ?><span class="tag ms-2">Sorted A→Z</span><?php endif; ?>
            <?php if ($sort === 'desc'): ?><span class="tag ms-2">Sorted Z→A</span><?php endif; ?>
        </h2>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th scope="col" class="d-none d-sm-table-cell">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col" class="text-end">Price</th>
                    <th scope="col"><span class="visually-hidden">Actions</span></th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($products) === 0): ?>
                    <tr><td colspan="4">No products in this category yet.</td></tr>
                <?php endif; ?>

                <?php for ($i = 0; $i < count($products); $i++): ?>
                    <?php $product = $products[$i]; ?>
                    <tr>
                        <td class="d-none d-sm-table-cell"><?php echo htmlspecialchars($product['productCode']); ?></td>
                        <td><?php echo htmlspecialchars($product['productName']); ?></td>
                        <td class="text-end">$<?php echo number_format($product['listPrice'], 2); ?></td>
                        <td class="actions">
                            <!-- DELETE uses a POST form (not a link) so a page visit or web crawler can't delete things -->
                            <form action="shop_delete.php" method="post" class="d-inline delete-form">
                                <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">
                                <input type="hidden" name="category_id" value="<?php echo $categoryID; ?>">
                                <button type="submit" class="btn btn-ghost btn-sm"
                                        aria-label="Delete <?php echo htmlspecialchars($product['productName']); ?>">Delete</button>
                            </form>
                            <a href="shop_edit_form.php?product_id=<?php echo $product['productID']; ?>"
                               class="btn btn-accent btn-sm"
                               aria-label="Modify <?php echo htmlspecialchars($product['productName']); ?>">Modify</a>
                        </td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>

        <!-- The brief asks for an Add button and two Sort buttons. They are links (each one just opens a page)
             styled as buttons with Bootstrap's btn classes, like the Modify button above. -->
        <ul class="list-unstyled d-flex flex-wrap gap-2">
            <li><a class="btn btn-accent btn-sm" href="shop_add_form.php?category_id=<?php echo $categoryID; ?>">➕ Add product</a></li>
            <li><a class="btn btn-ghost btn-sm" href="shop.php?category_id=<?php echo $categoryID; ?>&sort=asc">Sort products A→Z</a></li>
            <li><a class="btn btn-ghost btn-sm" href="shop.php?category_id=<?php echo $categoryID; ?>&sort=desc">Sort products Z→A</a></li>
            <?php if ($sort !== ''): ?>
                <li><a class="btn btn-ghost btn-sm" href="shop.php?category_id=<?php echo $categoryID; ?>">View product list (unsorted)</a></li>
            <?php endif; ?>
        </ul>
    </section>
</div>

<?php
$pageScript = 'shop.js';
include 'includes/footer.php';
?>
