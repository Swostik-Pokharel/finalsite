# Test report: Pink Floyd Archives

**Tested:** 2026-11-18 · Chrome (headless, 1280px and 375px) · PHP 8 built-in server · MySQL 26.10
**Result:** 66 automated functional tests + 8 accessibility checks, **all passed**. The manual checks in section 4 are still to be done by hand.

How to re-run (site and MySQL running):
```
bash tests/server-tests.sh        # PHP + MySQL, 15 tests
node tests/browser-tests.mjs      # real browser clicks, 51 tests
```

---

## 1. Database: PHP + MySQL (`tests/server-tests.sh`)
These send requests straight to PHP with no browser, so they prove the **server** checks work even if JavaScript is bypassed.

| ID | Feature | Input / action | Expected | Result |
|---|---|---|---|---|
| D1 | SELECT + sort | `shop.php?category_id=2&sort=asc` | Apparel listed A→Z | ✅ Pass |
| D2 | SORT desc | `sort=desc` | "The Wall Hoodie" first | ✅ Pass |
| D3 | INSERT | code `ptest`, name "Test Poster", price 12.50 | Redirect to list with "Product added." | ✅ Pass |
| D4 | INSERT | (check MySQL) | Row exists: Test Poster 12.50 | ✅ Pass |
| D5 | PHP validation | code "bad code", empty name, price "abc" | 3 error messages, nothing saved | ✅ Pass |
| D6 | PHP validation | duplicate code `ptest` | "code is already used" | ✅ Pass |
| D7 | PHP validation | modify price to -3 | "Price must be more than $0" | ✅ Pass |
| D8 | UPDATE | name "Test Poster Modified", price 15 | MySQL row updated | ✅ Pass |
| D9 | Security: SQL injection | `category_id=1 OR 1=1` | Ignored, shows Vinyl only | ✅ Pass |
| D10 | Security: whitelist | `sort=asc;DROP TABLE Products` | Ignored, table intact, list unsorted | ✅ Pass |
| D11 | Security: delete by link | GET `shop_delete.php?product_id=…` | Nothing deleted | ✅ Pass |
| D12 | Security: XSS | product name `<script>alert(1)</script>` | Shown as text, never runs | ✅ Pass |
| D13 | DELETE | POST product id | Row removed from MySQL | ✅ Pass |
| D14 | Robustness | faked `category_id=99` on add | "That category does not exist", no crash | ✅ Pass (fixed, see 5) |
| D15 | Robustness | modify `product_id=999999` | No false "Product updated" | ✅ Pass (fixed, see 5) |

## 2. Browser: JavaScript, layout, accessibility (`tests/browser-tests.mjs`)

### Every page
| ID | Test | Expected | Result |
|---|---|---|---|
| L1–L8 | Load all 8 pages (Home, Albums, Tours, Fan Wall, Shop, About, Account, Add product) | No JS errors, 6 nav links, Acknowledgement of Country in footer | ✅ Pass (8/8) |
| K1 | Press Tab once on page load | "Skip to main content" link gets focus | ✅ Pass |
| R1 | Read-aloud button | Button present, browser supports speech | ✅ Pass |
| R2 | Click Read aloud | Page queued sentence by sentence; button shows "Stop reading" | ✅ Pass |
| R3 | Press Esc while reading | Reading stops, button resets | ✅ Pass (fixed, see 5) |

### Home
| ID | Test | Expected | Result |
|---|---|---|---|
| H1 | Carousel | Bootstrap loaded, 4 slides | ✅ Pass |
| H2 | Images | Every image has meaningful alt text | ✅ Pass |
| H3 | Video | iframe has a title for screen readers | ✅ Pass |
| H4 | Click "next" arrow | Moves to slide 2 | ✅ Pass |

### Albums (page 2)
| ID | Test | Expected | Result |
|---|---|---|---|
| A1 | Page load | No tracklist visible | ✅ Pass |
| A2 | Click "Wish You Were Here" in the ordered list | Its 5-row table appears | ✅ Pass |
| A3 | Click the Dark Side cover | Its table shows, the previous one hides | ✅ Pass |
| A4 | Click the same cover again | Table closes (toggle) | ✅ Pass |
| A5 | Ordered list | All 9 albums clickable | ✅ Pass |
| A6 | Open `albums.php#tracks-animals` (e.g. from a link) | Animals tracklist already open | ✅ Pass |

### Tours
| ID | Test | Expected | Result |
|---|---|---|---|
| T1 | Page load | Tour dropdown disabled | ✅ Pass |
| T2 | Pick 1988 | 2 tours listed, details hidden | ✅ Pass |
| T3 | Pick a tour | Name, cities, setlist filled in | ✅ Pass |
| T4 | Pick 1973 (one tour) | Auto-selected, details shown | ✅ Pass |
| T5 | Clear the year | Details hidden, tour dropdown disabled | ✅ Pass |

### Fan wall (stack)
| ID | Test | Input | Expected | Result |
|---|---|---|---|---|
| F1 | Load | none | 2 starter posts | ✅ Pass |
| F2 | Submit empty | none | Rating, song, review errors | ✅ Pass |
| F3 | Short review | "short" | Rejected (min 10 chars) | ✅ Pass |
| F4 | Bad name | `<b>x</b>` | Rejected | ✅ Pass |
| F5 | Counter | type 44 chars | Shows 44 | ✅ Pass |
| F6 | Ctrl+Enter in review | valid post, no name | Posted on top as "Anonymous fan" | ✅ Pass |
| F7 | Reload page | n/a | Post still there (localStorage) | ✅ Pass |
| F8 | Post 7 more | n/a | 8 kept, newest on top, oldest gone | ✅ Pass |

### Sign up / sign in
| ID | Test | Input | Expected | Result |
|---|---|---|---|---|
| U1 | Submit empty sign-up | none | 6 required-field errors | ✅ Pass |
| U2 | Invalid sign-up | age 10, phone 12345, password "password", mismatched confirm | 4 specific errors | ✅ Pass |
| U3 | Focus | after U2 | Cursor jumps to first bad field | ✅ Pass |
| U4 | Valid sign-up | Sam Taylor, sam@example.com, 1990, 0412 345 678 | Success; saved name+email, **no password** | ✅ Pass |
| U5 | After sign-up | n/a | Redirect home, header "Welcome, Sam" + Log out | ✅ Pass |
| U6 | Log out | click | Sign in / Sign up return | ✅ Pass |
| U7 | Duplicate sign-up | SAM@example.com | "already registered" | ✅ Pass |
| U8 | Sign in, unknown email | nobody@example.com | "No account found" | ✅ Pass |
| U9 | Sign in, known email | sam@example.com | Header welcomes Sam | ✅ Pass |

### Contact form (About)
| ID | Test | Input | Expected | Result |
|---|---|---|---|---|
| C1 | Submit empty | none | 4 errors | ✅ Pass |
| C2 | Invalid | email "alex@", complaint of 19 chars | Email + "at least 30 characters" errors | ✅ Pass |
| C3 | Valid | proper email, 50-char complaint | Thank-you message, form cleared | ✅ Pass |

### Shop (JavaScript side)
| ID | Test | Expected | Result |
|---|---|---|---|
| S1 | "Add product" from Apparel | Category pre-selected as Apparel | ✅ Pass |
| S2 | Submit empty add form | JS stops it, 3 errors, stays on page | ✅ Pass |
| S3 | Valid add | Back to list, "Product added.", new row | ✅ Pass |
| S4 | Delete, confirm dialog → OK | "Product deleted.", row gone | ✅ Pass |

## 3. Responsive checks (screenshots)
| ID | Width | Page | Expected | Result |
|---|---|---|---|---|
| P1 | 1280px | All | Centred layout, nav in one row | ✅ Pass |
| P2 | 375px (phone) | Home | Nav collapses to "Menu", cards stack, no sideways scroll | ✅ Pass |
| P3 | 375px (phone) | Shop | Code column hidden, Delete/Modify stacked | ✅ Pass (fixed during testing, see 5) |
| P5 | 768px (tablet) | Home, Tours | Full nav in one row, panels full width, forms side by side | ✅ Pass |
| P4 | Print (emulated) | Albums with a tracklist open, Shop | White page, black text, no nav/buttons/forms, external links show their URL | ✅ Pass (fixed during testing, see 5) |

## 3b. Accessibility audit (automated, every page)
Checked on all 9 page states (7 pages + add/modify product forms) in Chrome:

| ID | Check | Result |
|---|---|---|
| AX1 | `<html lang>` set, page has a `<title>`, exactly one `<h1>` | ✅ Pass (9/9) |
| AX2 | Headings never skip a level (h1 → h2 → h3) | ✅ Pass |
| AX3 | Every input, select and textarea has a `<label>` | ✅ Pass |
| AX4 | Every button and link has an accessible name | ✅ Pass |
| AX5 | Every image has an `alt` attribute | ✅ Pass |
| AX6 | No duplicate `id`s; header, nav, main and footer landmarks present | ✅ Pass |
| AX7 | Colour contrast (WCAG formula) | ✅ Pass: body text 15.8:1 (AAA), pink accent 5.9–6.9:1 and muted text 6.0–7.1:1 (AA, needs 4.5:1), button text on pink 7.4:1 |
| AX8 | PHP server log after all test runs | ✅ No warnings, notices or 404s |
| AX9 | Site served from a subfolder (as in XAMPP `htdocs/finalsite/site/`) | ✅ Every internal link, image, script and stylesheet returns 200; shop redirects stay in the folder |

## 4. Manual checks (do these by hand, fill in Result)
| ID | Test | Steps | Expected | Result |
|---|---|---|---|---|
| M1 | Read aloud audio | Click "Read page aloud" on Home | Page is spoken; button says "Stop reading"; Esc stops | |
| M2 | Read selection | Highlight a paragraph, click Read aloud | Only that text is read | |
| M3 | Keyboard only | Use Tab / Shift+Tab / Enter through Albums and the shop | Every control reachable, pink focus ring visible | |
| M4 | Print on paper/PDF | ⌘P on Albums with a tracklist open | Same as P4 in the real print dialog | |
| M6 | Screen reader | VoiceOver (⌘F5) on Home | Images and carousel controls announced sensibly | |
| M7 | Shop modify | Modify a product in the browser | Form shows current values; saved values appear in list | |
| M8 | Video | Play the home video | Plays in the page | |

## 5. Bugs found and fixed during testing
| Bug | Cause | Fix |
|---|---|---|
| Every second row of the shop and fan wall tables was nearly invisible | Bootstrap's striped-row text colour (dark) overrode ours | Set `--bs-table-striped-color` etc. to our text colour in `style.css` |
| Carousel caption overlapped the slide indicators | Default caption position | Moved caption up (`bottom: 2.75rem`) |
| Shop table cramped on phones (names one word per line, Modify cut off) | 4 columns + 2 buttons in 375px | Hide Code column below 576px; stack the buttons |
| Printing: site title faint grey, shop rows and categories printed as dark bars | Screen colours leaking into the print stylesheet | Force black-on-white for brand, table cells and category list in `@media print` |
| About page claimed every colour passes 7:1 (AAA) | The pink accent is 5.9–6.9:1 | Corrected the claim to "body text ~16:1, every pair passes AA" |
| Adding a product with a faked category id crashed PHP (uncaught PDOException) | Foreign key rejected the INSERT | `shop_add.php` now checks the category exists first |
| Modifying a deleted/nonexistent product said "Product updated." | UPDATE of 0 rows isn't an error | `shop_edit.php` checks the product exists first |
| Esc didn't always stop read-aloud; long pages could cut off after ~15 s in Chrome | Relied on `speechSynthesis.speaking`; one long utterance | Own `isReading` flag; text queued sentence by sentence |
| Share button linked to `/index.php` (wrong under XAMPP subfolders) | Absolute path built from `location.origin` | Build the link relative to the current page with `new URL()` |
| Read-aloud splitter used a regex lookbehind, which older Safari can't parse (it would break all of main.js) | Modern-only regex feature | Rewritten with a plain `match()` pattern |
| Only 4 of 9 albums were clickable | Tracklists only existed for albums with covers | Tracklists for all 9; the list is generated from one PHP array |
