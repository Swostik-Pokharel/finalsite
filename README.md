# Pink Floyd Archives

An unofficial Pink Floyd fan site: albums, tour history, a fan wall and a database-driven merch shop.
Built for **NIT1101 Web Development, Assessment 2** (music artist theme).

**Stack:** HTML · CSS · Bootstrap 5 · JavaScript · PHP 8 (PDO) · MySQL

---

## Quick start

```bash
# 1. Create the database, tables, sample data and the site's DB user
mysql -u root -p < site/sql/pinkfloyd_archives.sql

# 2. Run the site
php -S localhost:8000 -t site
```
Open **http://localhost:8000**. Using XAMPP instead? See [`site/README.md`](site/README.md).

---

## What's inside

| Page | What it does |
|---|---|
| **Home** | Bootstrap carousel of album art, band intro, embedded video, member cards |
| **Albums** | Chronological album list. Click a cover to reveal its tracklist table |
| **Tours** | Pick a year, then a tour: cities, setlist, attendance and ticket price fill in live |
| **Fan Wall** | Post a rating and review. The newest post sits on top (a stack), saved in the browser |
| **Shop** | Merch manager on MySQL: **view, add, modify, delete and sort** products by category |
| **About** | Creator info, accessibility features, Acknowledgement of Country, contact form |
| **Account** | Sign up / sign in with full JavaScript validation; the header greets you by name |

### Accessibility and inclusion
- High-contrast dark theme with amber and blue accents (no red/green pairs)
- **Read page aloud** button on every page (Web Speech API, Esc to stop)
- Meaningful alt text on every image, and a titled video
- Fully keyboard-usable: skip link, visible focus rings, labelled form fields
- Inclusive, gender-neutral language
- Acknowledgement of Country in every footer

### Security
- Every SQL query uses **prepared statements** (no SQL injection)
- Sort direction is **whitelisted**, never taken raw from the URL
- The site connects as a **least-privilege MySQL user**, not root
- Input is validated in **JavaScript and again in PHP**
- Output is escaped (`htmlspecialchars` / `textContent`) to prevent XSS
- Deletes go through POST, and every change redirects afterwards (Post/Redirect/Get)

---

## Project structure

```
finalsite/
├── site/                     ← the website (this folder gets submitted)
│   ├── index.php  albums.php  tours.php  fanwall.php  about.php  account.php
│   ├── shop.php  shop_add_form.php  shop_add.php
│   │   shop_edit_form.php  shop_edit.php  shop_delete.php
│   ├── includes/             shared header, footer, DB connection, validation
│   ├── css/style.css         the one external stylesheet
│   ├── js/                   one script per page + main.js for every page
│   ├── images/
│   └── sql/pinkfloyd_archives.sql
├── docs/
│   ├── instructions.md       the assignment brief as a checklist
│   ├── vision.md
│   └── log.md                build log, session by session
└── Project-wireframe.zip     approved wireframes
```

---

## Database

```
Categories (categoryID PK, categoryName)
Products   (productID PK, categoryID FK → Categories, productCode UNIQUE, productName, listPrice)
```
Three categories (**Vinyl**, **Apparel**, **Posters**) with 13 sample products.
Re-running the SQL file resets the shop to the sample data.

---

*Unofficial fan project, not affiliated with Pink Floyd or their labels. Album artwork belongs to its respective owners.*
