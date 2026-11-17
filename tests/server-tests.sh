#!/bin/bash
# =========================================================
# server-tests.sh: tests the PHP + MySQL side of the shop directly,
# by sending requests with curl (no browser, so no JavaScript checks).
# This proves the SERVER-side validation works even if JS is bypassed.
#
# Run (site + MySQL must be running):   bash tests/server-tests.sh
# It adds one product ("ptest"), modifies it, then deletes it again.
# =========================================================

B=http://localhost:8000
PASS=0; FAIL=0

q() { mysql --no-defaults -u root -N -e "$1" 2>/dev/null; }   # run SQL, print bare values

check() {   # check <id> <description> <actual> <expected>
    if [ "$3" == "$4" ]; then echo "PASS $1 $2"; PASS=$((PASS+1));
    else echo "FAIL $1 $2"; echo "      expected: $4"; echo "      got:      $3"; FAIL=$((FAIL+1)); fi
}

q "DELETE FROM pinkfloyd_archives.Products WHERE productCode='ptest'"   # clean up any earlier run

# SELECT + SORT
NAMES=$(curl -s "$B/shop.php?category_id=2&sort=asc" | grep -o '<td>[^<$]*</td>' | sed 's/<[^>]*>//g' | grep -v '^[a-z]*$' | head -4 | tr '\n' '|')
check D1 "SELECT Apparel sorted A-Z" "$NAMES" "Animals Flying Pig T-shirt|Prism Beanie|Prism T-shirt|The Wall Hoodie|"
NAMES=$(curl -s "$B/shop.php?category_id=2&sort=desc" | grep -o '<td>[^<$]*</td>' | sed 's/<[^>]*>//g' | grep -v '^[a-z]*$' | head -1)
check D2 "SORT Z-A puts The Wall Hoodie first" "$NAMES" "The Wall Hoodie"

# INSERT
LOC=$(curl -s -o /dev/null -w "%{redirect_url}" -d "category_id=3&code=ptest&name=Test Poster&price=12.50" $B/shop_add.php)
check D3 "INSERT valid product redirects with msg=added" "$LOC" "$B/shop.php?category_id=3&msg=added"
check D4 "INSERT row is really in MySQL" "$(q "SELECT CONCAT(productName,' ',listPrice) FROM pinkfloyd_archives.Products WHERE productCode='ptest'")" "Test Poster 12.50"

# Server-side validation (bypasses JS completely)
ERR=$(curl -s -d "category_id=3&code=bad code&name=&price=abc" $B/shop_add.php | grep -o '<li>[^<]*</li>' | wc -l | tr -d ' ')
check D5 "PHP rejects bad code, empty name, non-numeric price (3 errors)" "$ERR" "3"
ERR=$(curl -s -d "category_id=3&code=ptest&name=X&price=5" $B/shop_add.php | grep -o 'already used')
check D6 "PHP rejects a duplicate product code" "$ERR" "already used"

# UPDATE
ID=$(q "SELECT productID FROM pinkfloyd_archives.Products WHERE productCode='ptest'")
ERR=$(curl -s -d "product_id=$ID&category_id=3&name=Ok&price=-3" $B/shop_edit.php | grep -o 'more than \$0')
check D7 "PHP rejects a negative price on modify" "$ERR" 'more than $0'
curl -s -o /dev/null -d "product_id=$ID&category_id=3&name=Test Poster Modified&price=15" $B/shop_edit.php
check D8 "UPDATE changes name and price in MySQL" "$(q "SELECT CONCAT(productName,' ',listPrice) FROM pinkfloyd_archives.Products WHERE productID=$ID")" "Test Poster Modified 15.00"

# Security
H=$(curl -s "$B/shop.php?category_id=1%20OR%201=1" | tr -d '\n' | grep -o '<h2 id="products-heading" class="h4">[^<]*' | sed 's/.*>//' | tr -d ' ')
check D9 "SQL injection in category_id is ignored (falls back to Vinyl)" "$H" "Vinyl"
H=$(curl -s "$B/shop.php?category_id=1&sort=asc;DROP%20TABLE%20Products" | grep -c 'Sorted A')
check D10 "Unknown sort value is ignored (whitelist)" "$H" "0"
curl -s -o /dev/null "$B/shop_delete.php?product_id=$ID"
check D11 "DELETE via a plain link (GET) does nothing" "$(q "SELECT COUNT(*) FROM pinkfloyd_archives.Products WHERE productID=$ID")" "1"
curl -s -d "category_id=3&code=xss1&name=<script>alert(1)</script>&price=5" -o /dev/null $B/shop_add.php
PAGE=$(curl -s "$B/shop.php?category_id=3")
RAW=$(echo "$PAGE" | grep -c '<script>alert(1)')
ESC=$(echo "$PAGE" | grep -c '&lt;script&gt;alert(1)&lt;/script&gt;')
check D12 "HTML in a product name is escaped on output (no XSS)" "raw=$RAW escaped=$([ $ESC -gt 0 ] && echo yes)" "raw=0 escaped=yes"
q "DELETE FROM pinkfloyd_archives.Products WHERE productCode='xss1'"

ERR=$(curl -s -d "category_id=99&code=fktest&name=FK Test&price=5" $B/shop_add.php | grep -o 'category does not exist')
check D14 "A faked category id (99) gives an error message, not a crash" "$ERR" "category does not exist"
LOC=$(curl -s -o /dev/null -w "%{redirect_url}" -d "product_id=999999&category_id=1&name=Ghost&price=5" $B/shop_edit.php)
check D15 "Modifying a product that doesn't exist doesn't claim success" "$LOC" "$B/shop.php"

# DELETE
curl -s -o /dev/null -d "product_id=$ID&category_id=3" $B/shop_delete.php
check D13 "DELETE via POST removes the row" "$(q "SELECT COUNT(*) FROM pinkfloyd_archives.Products WHERE productID=$ID")" "0"

echo; echo "$PASS passed, $FAIL failed"
