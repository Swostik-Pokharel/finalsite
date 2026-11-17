<?php
// =========================================================
// product_validation.php: SERVER-SIDE validation for shop forms.
// JS (js/shop.js) checks first for a fast response, but JS can be turned
// off or bypassed, so PHP must check again before touching the database.
//
// Returns an ARRAY of error messages. An empty array means the input is valid.
// $code is null when editing (the edit form only changes name and price).
// =========================================================

function validateProduct($code, $name, $price)
{
    $errors = [];

    // Product code: only checked when adding
    if ($code !== null) {
        if ($code === '') {
            array_push($errors, 'Product code is required.');
        } else {
            if (strlen($code) > 10) {
                array_push($errors, 'Product code must be 10 characters or fewer.');
            } elseif (!preg_match('/^[a-z0-9]+$/i', $code)) {
                array_push($errors, 'Product code can only contain letters and numbers.');
            }
        }
    }

    // Name
    if ($name === '') {
        array_push($errors, 'Product name is required.');
    } elseif (strlen($name) > 255) {
        array_push($errors, 'Product name is too long.');
    }

    // Price: nested if/else. Must be present, then numeric, then in range.
    if ($price === '') {
        array_push($errors, 'Price is required.');
    } else {
        if (!is_numeric($price)) {
            array_push($errors, 'Price must be a number.');
        } else {
            if ($price <= 0) {
                array_push($errors, 'Price must be more than $0.');
            } elseif ($price > 9999.99) {
                array_push($errors, 'Price must be under $10,000.');
            }
        }
    }

    return $errors;
}

// Print the error array as a list (used by both forms)
function showErrors($errors)
{
    if (count($errors) === 0) {
        return;
    }
    echo '<div class="success-msg mb-3" role="alert"><p class="mb-1"><strong>⚠ Please fix the following:</strong></p><ul class="mb-0">';
    for ($i = 0; $i < count($errors); $i++) {
        echo '<li>' . htmlspecialchars($errors[$i]) . '</li>';
    }
    echo '</ul></div>';
}
