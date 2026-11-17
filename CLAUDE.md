# finalsite

## What it is
Pink Floyd Archives: unofficial fan site for NIT1101 Assessment 2 (solo). Brief condensed in docs/instructions.md; the brief beats the wireframes.

## Stack
HTML, Bootstrap 5.3.3 (local copy in site/vendor/), one external css/style.css, vanilla JS, PHP 8 (PDO), MySQL. No build step.
Only Categories/Products are in MySQL (merch shop). Login, fan wall and tours are JS + localStorage.

## Run / test
- DB (resets data): `mysql --no-defaults -u root < site/sql/pinkfloyd_archives.sql`
  (`--no-defaults` because ~/.my.cnf sets a root password; never read that file)
- Server: `php -S localhost:8000 -t site`, then open http://localhost:8000
- Lint: `php -l site/*.php`, `node --check site/js/*.js`
- Tests: `bash tests/server-tests.sh` (15), `node tests/browser-tests.mjs` (51, headless Chrome via CDP, no npm). Keep docs/test-report.md in sync.

## Conventions
- Every page is .php and does `include 'includes/header.php'` / `footer.php`; set `$pageTitle`, `$currentPage`, optional `$pageScript` first.
- All SQL via prepared statements; ORDER BY direction is whitelisted, never interpolated from input.
- Escape output with htmlspecialchars (PHP) / textContent (JS).
- Colours only via the CSS variables in style.css (style follows the old Pink_Floyd site); colour never the only signal.
- Comment code in plain language: the user must explain every line in the demo.

## Docs
- docs/instructions.md: the assignment brief, condensed (checklist)
- docs/vision.md: why and what
- docs/log.md: session log (append an entry after each task)
- site/README.md: install/run guide (part of the submission)
