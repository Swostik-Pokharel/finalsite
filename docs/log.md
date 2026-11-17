# finalsite: log

One entry per task. Claude fills Built/Decisions/Concepts; I fill "Didn't understand".
This is the input for the /eod Q&A.

## 2026-11-18: project started
- Built: scaffold
- Decisions:
- Concepts:
- Didn't understand:
- Next: plan-mode vision interview

## 2026-11-18: condense assignment brief into docs/instructions.md
- Built: docs/instructions.md, a checklist version of "Assessment 2.html" plus its 8 case-study screenshots, and a gap list comparing the brief to our 6 wireframes.
- Decisions: put it in docs/ next to vision/log so CLAUDE.md's Docs list covers it; summarised the SneakerStore screenshots as an ASCII sketch so the images can go; listed wireframe gaps without deciding them (one task per session).
- Concepts: requirements checklist, CRUD (SELECT/INSERT/UPDATE/DELETE) + ORDER BY, primary key / foreign key (Products.categoryID → Categories), WCAG-style accessibility (contrast, alt text, keyboard nav, speechSynthesis), responsive design with Bootstrap.
- Didn't understand:
- Next: resolve the gaps in section 8, starting with what the Categories/Products tables represent; then fill docs/vision.md.

## 2026-11-18: build the whole site (roadmap steps 0–9 in one go)
- Built: site/ with 6 nav pages (Home, Albums, Tours, Fan Wall, Shop, About) + Account page; shared header/footer includes; style.css (dark high-contrast theme + print styles); JS for read-aloud, tracklist show/hide, tour lookup, fan-wall stack, sign-in/up, contact and shop validation; MySQL merch shop with SELECT/INSERT/UPDATE/DELETE/ORDER BY; site/README.md.
- Decisions:
  - All pages are .php so header/footer can be `include`d once (no copy-paste nav; covers the "include" requirement).
  - Homebrew PHP + MySQL instead of XAMPP. The PHP install broke MySQL 9.6, so we upgraded to 26.10 and re-initialised it; old data was moved to /opt/homebrew/var/mysql-9.6-backup (csit115/practise, no longer needed).
  - The site connects as `pfa_user` (only SELECT/INSERT/UPDATE/DELETE on one DB), not root: least privilege.
  - Prepared statements for every query; sort direction whitelisted because placeholders can't hold SQL keywords.
  - Validation twice: JS for speed, PHP because JS can be bypassed.
  - Delete is a POST form, not a link, so visiting a URL can't delete data. Post/Redirect/Get after every change.
  - Fan wall = stack (push newest, display top-down, shift oldest when full). Accounts store name+email only, never passwords.
  - Tour attendance/prices are labelled as estimates on the page.
- Concepts: PHP include/require_once, PDO, prepared statements & SQL injection, foreign key, UNIQUE constraint, DECIMAL for money, least privilege, Post/Redirect/Get, server vs client validation, htmlspecialchars/XSS, array_push, for loops, nested if/else, stack (LIFO), localStorage + JSON, DOM events (click, submit, change, input, keydown), aria-live/aria-expanded, skip link, focus-visible, speechSynthesis, Bootstrap grid/carousel/navbar collapse, @media print.
- Didn't understand:
- Next: user tests every page in a browser (mouse + keyboard + phone width + print preview), then step 11 test report and step 12 documents.
