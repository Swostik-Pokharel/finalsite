# Pink Floyd Archives: Assessment 2 report (DRAFT)

> **Draft for Swostik to rewrite in your own words.** Every fact below matches the code as of 2026-11-18.
> Add screenshots where marked 📷. Target is about 1000 words *equivalent*: tables and screenshots count.

## 1. Theme selection
I chose the **music artist** theme and built an unofficial fan archive for **Pink Floyd**. Three reasons:
- **The content fits every requirement.** Albums suit tables and ordered lists, tours suit dynamic lookups, and merchandise naturally suits a database with categories and prices.
- **Strong visual identity.** The *Dark Side of the Moon* prism gives the site a recognisable look (the rainbow strip and prism logo) without copying a template.
- **Personal interest.** I know the music well, so I could focus on the technical work rather than researching content.

The approved wireframes defined six pages. Where the wireframes and the brief differed (for example, the home wireframe had no video or carousel), I followed the brief.

## 2. Site overview
📷 *Home page screenshot*

| # | Page | Purpose | Key brief requirements met |
|---|---|---|---|
| 1 | Home | Introduce the band and site | Logo + tagline, nav, Bootstrap carousel, intro paragraph, embedded video |
| 2 | Albums | Discography | Ordered list of 9 albums, tracklist **tables** (5–11 rows), images with alt text, external link |
| 3 | Tours | Tour history | JavaScript lookup: year → tour → cities (`<ul>`), setlist, attendance |
| 4 | Fan Wall | Community reviews | Validated form, table, **stack** data structure |
| 5 | Shop | Merch manager | **MySQL**: SELECT, INSERT, UPDATE, DELETE, ORDER BY |
| 6 | About | Creator, accessibility, contact | Description, accessibility list, inclusive language, Acknowledgement of Country, contact form, social links |
| – | Account | Sign in / sign up | Both forms with JavaScript validation |

**Structure.** Every page is a `.php` file that `include`s a shared `header.php` and `footer.php`. The navigation menu, header and footer exist in exactly one place, so every page stays consistent and the brief's *include statement* requirement is met. There is one external stylesheet (`css/style.css`), loaded after Bootstrap so its rules take priority, and files are organised into `css/`, `js/`, `images/`, `includes/` and `sql/` folders.

## 3. Responsive design
Bootstrap 5's grid, collapsing navbar and carousel make the layout responsive. 📷 *Phone and desktop side by side*
- **Phone (375px):** the nav collapses to a "Menu" button, columns stack, and the shop hides its Code column and stacks its buttons.
- **Tablet (768px):** full nav row, single-column panels.
- **Print:** a `@media print` stylesheet switches to black on white, hides the nav, buttons and forms, and prints external link addresses.

## 4. JavaScript interactivity
| Requirement | Implementation |
|---|---|
| **Event types (5 used, 3 required)** | `click` (album covers, read aloud, log out, share), `submit` (all forms), `change` (tour dropdowns), `input` (character counter), `keydown` (Ctrl+Enter to post, Esc to stop reading) |
| **Logic rules (2 required)** | Show/hide tracklists (only one open at a time, toggle); dependent dropdowns that auto-select when a year has one tour; contact form requiring 30+ characters for complaints but 10 for feedback; header switching between "Sign in" and "Welcome, Name"; stack capped at 8 posts |
| **Form validation** | Sign up (name pattern, email format and uniqueness, age 13+, Australian phone format, password strength, matching confirmation, checkbox), sign in, contact, fan wall, shop add/modify. Errors appear beside each field and keyboard focus moves to the first problem. |
| **Data structures** | Tours: array of objects. Fan wall: a **stack** (newest pushed on top and displayed first; when full, the oldest is removed), saved to `localStorage` as JSON. |

**Design decision:** login is simulated in the browser because the brief only requires MySQL for products. Passwords are validated but never stored. A real site would hash them on the server.

## 5. Accessibility and inclusion
All six listed features are implemented (the brief requires three):
1. **Colour:** body text has a 15.8:1 contrast ratio and every colour pair passes WCAG AA. Colour is never the only signal: errors also use a ⚠ icon and text.
2. **Read aloud:** a header button on every page uses the Web Speech API (`speechSynthesis`) to read the page, or only the highlighted text. Esc stops it.
3. **Alt text:** every image has a descriptive alt, and the video iframe has a title.
4. **Keyboard:** a skip link, a visible pink focus ring, `<label>` on every field, real `<button>` elements, and `aria-expanded` / `aria-live` for content that changes.
5. **Inclusive language:** "fans", "visitors" and "people"; anonymous posting allowed.
6. **Acknowledgement of Country:** in every footer and on the About page.

## 6. Database
📷 *Shop list and Add form*

```
Categories (categoryID PK, categoryName)
Products   (productID PK, categoryID FK, productCode UNIQUE, productName, listPrice DECIMAL(10,2))
```
Three categories (Vinyl, Apparel, Posters) with 13 sample products. Following the SneakerStore case study, the UI is split into small PHP files: list (`shop.php`), add form and handler, modify form and handler, and delete handler.

**Security measures**
- **Prepared statements** for every query, so input can never change the SQL (prevents SQL injection).
- The sort direction is **whitelisted** (`ASC`/`DESC`), because placeholders cannot hold SQL keywords.
- The site connects as **`pfa_user`**, which can only SELECT, INSERT, UPDATE and DELETE in this one database (least privilege), not as root.
- **Validation runs twice:** JavaScript for instant feedback, and PHP (`includes/product_validation.php`) because JavaScript can be bypassed. Errors are collected with `array_push` and printed with a `for` loop.
- All output is escaped with `htmlspecialchars` (prevents XSS). Delete only works through POST, and every change redirects afterwards (Post/Redirect/Get), so refreshing never repeats an action.

## 7. Testing
66 automated tests and 8 accessibility checks, **all passing** (full table in the test report):
- 15 server tests send requests straight to PHP (including SQL injection and XSS attempts).
- 51 browser tests drive Chrome: clicking, typing, submitting forms, and checking the results.

Testing found and fixed eleven bugs, including invisible striped table rows, a crash on a faked category id, read-aloud stopping early in Chrome, and dark printouts.

## 8. Limitations and future work
- The shop manager has no real admin login. Anyone with the link can edit products. A `users` table with hashed passwords and PHP sessions would fix this.
- Fan wall posts and accounts live in one browser only. Moving them to MySQL would share them between visitors.
- There is no shopping cart or payments; a real store would add a cart and a payment provider.

## 9. Use of AI
Claude (Anthropic) was used as a coding assistant, as the assessment allows. I reviewed, ran and tested all of the code and can explain every part of it. `docs/log.md` records each session's decisions.
