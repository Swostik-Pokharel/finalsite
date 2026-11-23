# Requirements map: Pink Floyd Archives

Each requirement from the NIT1101 Assessment 2 brief and where it is built. Paths are inside `site/`.
Checked against the code and re-tested on 2026-11-23 (66/66 automated tests passed, see `docs/test-report.md`).

## 1. Site structure

| Requirement | Where and how it is implemented |
|---|---|
| At least 6 interlinked pages | `index.php`, `albums.php`, `tours.php`, `fanwall.php`, `shop.php`, `about.php` (+ `account.php` and the shop add/edit pages). All are linked from the nav. |
| Same nav menu on every page | `includes/header.php:7` holds one array of nav links, looped into the menu at line 64. Every page `include`s this file, so the nav is identical everywhere and the current page is marked `aria-current="page"`. |
| Header, nav, main, footer on each page | `<header>`, `<nav>` and `<main>` in `includes/header.php:32,56,77`; `<footer>` in `includes/footer.php:3`. |
| One external CSS file, linked on every page | `css/style.css`, linked once in `includes/header.php:25` (after Bootstrap so our rules win). |
| Supporting files in separate folders | `css/`, `js/`, `images/`, `includes/`, `sql/`, `vendor/bootstrap/`. |

## 2. Page-specific requirements

| Requirement | Where and how it is implemented |
|---|---|
| **Home:** brand logo + tagline | `includes/header.php:50-52`: `images/logo.svg` plus the tagline "Shine on: every album, every tour, one archive." |
| **Home:** nav to all pages | Shared nav from `includes/header.php`. |
| **Home:** image carousel | `index.php:10`: Bootstrap carousel with 4 album images, indicators and prev/next buttons. |
| **Home:** short intro paragraph | `index.php:50-68`: "Welcome to the archive" section. |
| **Home:** theme-relevant video | `index.php:70-80`: embedded YouTube video (`iframe` with a `title` for screen readers). |
| **Page 2 (Albums):** table with 4+ rows | `albums.php:112`: tracklist table for each album (5–11 rows each), built with a PHP `for` loop. |
| **Page 2:** ordered list | `albums.php:96`: `<ol>` of all 9 albums in chronological order. |
| **Page 2:** external link | `albums.php:73`: link to pinkfloyd.com/music (opens in a new tab, says so in the text). |
| **Page 2:** image with alt text | `albums.php:85`: album covers, each with a descriptive `alt`. |
| **About:** description of brand / team | `about.php:10-29`: "Who runs it" and "A fan project" sections. |
| **About:** 3+ accessibility features | `about.php:31-48`: lists the 6 features the site actually implements (see section 5). |
| **About:** inclusive, respectful language | Text uses "fans", "visitors", "people"; listed at `about.php:44`. |
| **About:** Acknowledgement of Country | `about.php:50-56`, and in the footer of every page (`includes/footer.php:20-25`). |
| **About:** contact info / social links | `about.php:99-103` (Instagram, YouTube) and the footer (email, phone, official links). |

## 3. Content that must appear somewhere

| Requirement | Where and how it is implemented |
|---|---|
| Relevant picture and video | Carousel + video on `index.php`; album covers on `albums.php`. |
| Ordered and unordered lists | `<ol>`: `albums.php:96`, tour setlist `tours.php:41`. `<ul>`: `about.php:35`, tour cities `tours.php:37`, footer. |
| Tables | `albums.php:112` (tracklists), `fanwall.php:14` (fan posts), `shop.php:100` (products). |
| Sign-in and sign-up forms with JS validation | `account.php:15,35`; validated in `js/account.js` (`validateSignup()` line 42: name, email, age, password match; sign-in checks the account exists). |
| Contact / feedback / complaint form with JS validation | `about.php:63`; validated in `js/about.js:16` (`validateContact()`), errors shown next to each field. |
| Links to external pages | pinkfloyd.com, YouTube, Instagram on `albums.php`, `about.php` and the footer. |
| Attractive descriptive paragraph with UI elements | Intro panel and member cards on `index.php`; styled panels, tags and buttons from `css/style.css`. |

## 4. Bootstrap responsiveness

| Requirement | Where and how it is implemented |
|---|---|
| Works on mobile | Bootstrap grid (`col-sm-*`, `col-lg-*`), the nav collapses into a "Menu" button below 768px (`includes/header.php:56-62`), shop table scrolls in `.table-responsive`; extra phone rules in `css/style.css:350,377`. |
| Works on tablet | Same grid: columns stack or sit side by side depending on width (e.g. `index.php:51,70`). |
| Works in print | `@media print` in `css/style.css:358`: white background, black text, hides nav/buttons/carousel controls. |

## 5. JavaScript interactivity

| Requirement | Where and how it is implemented |
|---|---|
| 3+ event types | 5 used: `click` (`js/albums.js:41`, `js/main.js:20`), `submit` (`js/account.js:122`, `js/about.js:53`, `js/fanwall.js:118`, `js/shop.js:11`), `change` (`js/tours.js:84,113`), `input` (`js/fanwall.js:105`), `keydown` (`js/main.js:51`, Esc stops read-aloud). |
| 2+ logic rules | (1) Show/hide: clicking an album shows its tracklist and hides the others (`js/albums.js:11`). (2) Dynamic content: choosing a year then a tour fills in cities, setlist, attendance and price (`js/tours.js:122`). (3) Fan wall stack: newest post on top, oldest dropped when full (`js/fanwall.js:31`). (4) Header greets the signed-in user by name (`js/main.js`). |

## 6. Accessibility and inclusion (need 2+ technical, 1+ inclusion)

| Requirement | Where and how it is implemented |
|---|---|
| Accessible colour scheme (technical) | CSS variables in `css/style.css:10`; body text ~16:1 contrast, all pairs pass WCAG AA. Colour is never the only signal (errors have ⚠ + text, current page is underlined). |
| Read-aloud (technical) | "Read page aloud" button on every page (`includes/header.php:40`), `js/main.js:18` uses `speechSynthesis`; reads highlighted text if any; Esc stops it. |
| Alt text (technical) | Every `<img>` has a meaningful `alt`; the video `iframe` has a `title`. |
| Keyboard access (technical) | Skip link (`includes/header.php:30`), album covers are real `<button>`s, visible focus outlines, every form field has a `<label>`. |
| Inclusive language (inclusion) | Gender-neutral wording across the site ("fans", "visitors"); stated on `about.php:44`. |
| First Nations acknowledgement (inclusion) | `about.php:50` and every page's footer. |

## 7. Database (PHP + MySQL)

| Requirement | Where and how it is implemented |
|---|---|
| Tables `Categories` and `Products` (exact names/columns) | `sql/pinkfloyd_archives.sql:12,18`; `Products.categoryID` is a foreign key to `Categories`. |
| 3 categories with sample products | `sql/pinkfloyd_archives.sql:30-35`: Vinyl, Apparel, Posters, 13 products. |
| DB connected to a PHP page | `includes/database.php` (PDO, least-privilege user `pfa_user`), used by `shop.php:8`. |
| SELECT products for a chosen category | `shop.php:45`: prepared statement; categories in the sidebar switch the list. |
| INSERT ("Add" form) | Form `shop_add_form.php:28` → `shop_add.php:55` (prepared `INSERT`). |
| DELETE (button per row) | POST form per row `shop.php:122` (JS confirm in `js/shop.js:13`) → `shop_delete.php:11`. |
| UPDATE (Modify → edit name + price → Save) | Modify opens `shop_edit_form.php:41` (list hidden, form shown) → `shop_edit.php:40` (prepared `UPDATE`). |
| ORDER BY (sort A→Z and Z→A) | Links at `shop.php:140-141`; direction picked from a whitelist at `shop.php:20-26`, never taken raw from the URL. |
| "View list" link on each sub-screen | `shop_add_form.php:63`, `shop_edit_form.php:60`, and `shop.php:143` after sorting. |
| Input validation | JS in `js/shop.js`, and again in PHP in `includes/product_validation.php:11` (JS can be bypassed). |

## 8. Programming concepts the marker looks for

| Concept | Where |
|---|---|
| for loop | `albums.php:116` (PHP), `js/tours.js:64`, `js/fanwall.js:42` |
| Arrays | `$albums` in `albums.php`, `$navItems` in `includes/header.php:7`, `tours` array in `js/tours.js` |
| Nested if/else | `includes/product_validation.php:35-46` (price checks), `js/account.js:54-66` |
| PHP `include` | Every page: `include 'includes/header.php'` / `footer.php` |
| Stack or queue | Fan wall stack: `push()` / `shift()` in `js/fanwall.js:31-34` |
| Input validation | `js/account.js`, `js/about.js`, `js/fanwall.js`, `js/shop.js`, `includes/product_validation.php` |
| Bootstrap, JS, PHP, CSS, HTML, SQL | `vendor/bootstrap/`, `js/`, `*.php`, `css/style.css`, `sql/pinkfloyd_archives.sql` |

## 9. Submission items

| Requirement | Status / file |
|---|---|
| Approved wireframes | `Project-wireframe.zip` ✅ |
| Install / usage instructions | `site/README.md` (incl. XAMPP steps) ✅ |
| Test report with test cases | `docs/test-report.md` ✅ (manual checks M1–M8 still to do by hand) |
| Acknowledgement of external sources | `docs/acknowledgements.md` (add image source URLs) |
| A4 cover page | `docs/cover-page.html`: fill in brackets, print to PDF, sign ❌ |
| Contribution report + meeting minutes | `docs/contribution.md`: draft, fill in brackets ❌ |
| Written report | `docs/report-draft.md`: rewrite in own words + screenshots ❌ |
| Full name + student ID shown | On the cover page ❌ |
| Zip of the site folder | Zip `site/` before submitting ❌ |
