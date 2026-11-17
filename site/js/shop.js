// =========================================================
// shop.js: client-side checks for the shop pages
//   1. Confirm before deleting a product
//   2. Validate the add / modify form before it is sent to PHP
// PHP validates again on the server (includes/product_validation.php).
// =========================================================

// ---------- 1. Confirm delete ----------
document.querySelectorAll('.delete-form').forEach(function (form) {
    // EVENT: submit
    form.addEventListener('submit', function (event) {
        const label = form.querySelector('button').getAttribute('aria-label'); // "Delete <name>"
        if (!confirm(label + '? This cannot be undone.')) {
            event.preventDefault(); // cancelled: don't send the form
        }
    });
});

// ---------- 2. Validate add / modify form ----------
const productForm = document.getElementById('product-form');

function setError(id, message) {
    document.getElementById(id + '-error').textContent = message;
    document.getElementById(id).classList.toggle('is-invalid', message !== '');
}

if (productForm) {
    productForm.addEventListener('submit', function (event) {
        let ok = true;
        const codeInput = document.getElementById('code'); // only on the add form
        const name = document.getElementById('name').value.trim();
        const price = document.getElementById('price').value.trim();

        if (codeInput) {
            const code = codeInput.value.trim();
            if (code === '') { setError('code', 'Product code is required.'); ok = false; }
            else if (!/^[a-z0-9]{1,10}$/i.test(code)) { setError('code', 'Up to 10 letters or numbers, no spaces.'); ok = false; }
            else { setError('code', ''); }
        }

        if (name === '') { setError('name', 'Product name is required.'); ok = false; }
        else { setError('name', ''); }

        if (price === '') {
            setError('price', 'Price is required.'); ok = false;
        } else {
            const number = Number(price);
            if (isNaN(number)) { setError('price', 'Price must be a number.'); ok = false; }
            else if (number <= 0) { setError('price', 'Price must be more than $0.'); ok = false; }
            else if (number > 9999.99) { setError('price', 'Price must be under $10,000.'); ok = false; }
            else { setError('price', ''); }
        }

        if (!ok) {
            event.preventDefault(); // stop the form going to PHP
            productForm.querySelector('.is-invalid').focus();
        }
    });
}
