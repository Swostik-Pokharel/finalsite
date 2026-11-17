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

## 2026-11-18: restyle in the original Pink_Floyd look + all albums clickable
- Built: rewrote css/style.css in the old site's style (Georgia serif, pink #ff5fa2 accent, prism rainbow strips on header/footer, uppercase letter-spaced nav/labels, pink-bar h2s, boxed lists with pink markers); centred brand header with a small top bar for sign-in/read-aloud; albums.php now has tracklists for all 9 albums, built from one PHP array.
- Decisions: only albums with a cover image appear in the cover grid, but every title in the ordered list opens its tracklist; replaced Bootstrap colour classes (btn-outline-light, badges) with theme classes (.btn-ghost, .tag) so one stylesheet controls the look; the prism strip has red and green, so the accessibility claim is now "colour is never the only signal" (icons, text, underline) rather than "no red/green".
- Concepts: CSS custom properties, border-image, `continue` in a loop, single source of data driving several views, WCAG contrast ratios, colour-not-the-only-signal rule.
- Didn't understand:
- Next: browser test pass, then the test report.

## 2026-11-18: 30-minute autonomous polish + testing pass
- Built:
  - tests/server-tests.sh (15 curl tests: CRUD, sort, server-side validation, SQL injection, XSS, faked ids) and tests/browser-tests.mjs (51 tests driving headless Chrome over the DevTools Protocol, no npm packages).
  - docs/test-report.md (66 tests + accessibility audit + manual checklist + bug log), docs/report-draft.md, docs/acknowledgements.md, docs/contribution.md, docs/cover-page.html; ticked 43/48 items in docs/instructions.md.
  - Polish: star ratings on the fan wall, tours starter hint, video caption, albums open from a #tracks-… link, Bootstrap bundled locally in site/vendor/ (works offline).
- Bugs fixed (11): invisible striped table rows; carousel caption over indicators; cramped shop table on phones; dark printouts; overstated contrast claim; crash on faked category id; false "updated" on missing product; read-aloud cutting off in Chrome / Esc not stopping it; share link wrong under XAMPP subfolders; regex lookbehind breaking older Safari; only 4 of 9 albums clickable (earlier).
- Decisions: kept the pink accent (WCAG AA, not AAA) and corrected the claim rather than changing the user's colour; local Bootstrap over CDN so the demo can't break without internet; tests live in tests/ (not submitted inside site/); report/contribution are drafts for Swostik to rewrite in their own words.
- Concepts: automated testing (functional, regression), Chrome DevTools Protocol, WCAG contrast formula, foreign-key errors, rowCount vs existence check, Web Speech API utterance queue, relative vs absolute URLs, browser compatibility (regex lookbehind), print media emulation, localStorage + JSON, aria-hidden decorative content.
- Didn't understand:
- Next: fill [brackets] in cover page/contribution, add image source URLs in acknowledgements, do manual checks M1–M8 in the test report, rewrite report draft in own words + screenshots, export docs to PDF, zip site/ and submit.
