# Pink Floyd Archives: install and run

An unofficial Pink Floyd fan site (NIT1101 Assessment 2). HTML, CSS, Bootstrap 5, JavaScript, PHP and MySQL.

## Requirements
- PHP 8+ with `pdo_mysql`, and MySQL 8+ (or XAMPP, which includes both)
- An internet connection only for the embedded YouTube video (Bootstrap is included in `vendor/`)

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

## Running on Windows with XAMPP
1. Open the XAMPP Control Panel and start **Apache** and **MySQL**.
2. Open <http://localhost/phpmyadmin>, click **Import**, choose `sql/pinkfloyd_archives.sql`, click **Go**.
   Do this as the default `root` user with no database selected (the file creates the database and the `pfa_user` account itself).
3. Copy the **contents** of this folder (not the folder above it) into `C:\xampp\htdocs\pinkfloyd\`.
4. Open <http://localhost/pinkfloyd/>.

If something goes wrong:
| Problem | Fix |
|---|---|
| Shop says "Shop unavailable" | The SQL was not imported (step 2), or MySQL is not running |
| Apache will not start (port 80 busy) | Stop IIS/Skype, or change the port in XAMPP Config and add it to the URL, e.g. `localhost:8080/pinkfloyd/` |
| MySQL will not start (port 3306 busy) | Stop the other MySQL service, or change the port and add `;port=3307` to the DSN in `includes/database.php` |
| Page not found | The files are one folder too deep: `index.php` must sit directly inside `htdocs\pinkfloyd\` |
| Shop errors about the driver | Make sure `extension=pdo_mysql` is not commented out in `php.ini` |

XAMPP uses MariaDB instead of MySQL; the SQL file only uses features both support.

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
css/style.css   js/*.js   images/   sql/pinkfloyd_archives.sql   vendor/bootstrap/
```
