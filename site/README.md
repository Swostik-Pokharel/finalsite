# Pink Floyd Archives: install and run

An unofficial Pink Floyd fan site (NIT1101 Assessment 2). HTML, CSS, Bootstrap 5, JavaScript, PHP and MySQL.

## Requirements
- PHP 8+ with `pdo_mysql`, and MySQL 8+ (or XAMPP, which includes both)
- An internet connection (Bootstrap and the YouTube video load from the web)

## 1. Create the database
```bash
mysql -u root -p < sql/pinkfloyd_archives.sql
```
This creates the `pinkfloyd_archives` database, the `Categories` and `Products` tables, the sample data,
and a limited user `pfa_user` that the site connects with (see `includes/database.php`).
Running it again resets the shop to the sample data.

**XAMPP:** open phpMyAdmin, go to the *Import* tab, and choose `sql/pinkfloyd_archives.sql`.

## 2. Start the site
```bash
php -S localhost:8000 -t .      # run from inside this folder
```
Then open <http://localhost:8000>.
**XAMPP:** copy this folder into `htdocs/`, then open `http://localhost/<folder-name>/`.

## Pages
| Page | File | What to try |
|---|---|---|
| Home | `index.php` | Carousel, video, intro |
| Albums | `albums.php` | Click a cover or a linked title to show its tracklist |
| Tours | `tours.php` | Pick a year, then a tour |
| Fan Wall | `fanwall.php` | Post a review (the newest appears on top) |
| Shop | `shop.php` | Add / Modify / Delete / Sort products (MySQL) |
| About | `about.php` | Contact form, accessibility list, Acknowledgement of Country |
| Account | `account.php` | Sign up, then sign in. The header shows "Welcome, Name" |

Every page has a **Read page aloud** button (press Esc to stop) and a "Skip to main content" link (press Tab).

## Folder layout
```
index.php albums.php tours.php fanwall.php about.php account.php   pages
shop.php shop_add_form.php shop_add.php shop_edit_form.php
shop_edit.php shop_delete.php                                      database pages
includes/   header.php footer.php database.php product_validation.php
css/style.css   js/*.js   images/   sql/pinkfloyd_archives.sql
```
