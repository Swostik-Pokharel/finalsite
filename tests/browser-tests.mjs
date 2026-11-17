// =========================================================
// browser-tests.mjs: automated browser tests for Pink Floyd Archives
//
// Opens the site in headless Google Chrome, clicks / types like a visitor,
// and checks the result. No npm packages: it talks to Chrome directly
// through the Chrome DevTools Protocol using Node's built-in WebSocket.
//
// Run (site + MySQL must be running):   node tests/browser-tests.mjs
// Needs: Node 22+ and Google Chrome in /Applications.
// Note: it adds and then deletes one product ("E2E Test Tee").
// =========================================================

import { spawn } from 'node:child_process';
const CHROME = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const PORT = 9333;
const BASE = 'http://localhost:8000/';
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

const chrome = spawn(CHROME, ['--headless=new', '--disable-gpu', `--remote-debugging-port=${PORT}`,
  '--user-data-dir=/private/tmp/claude-501/chrome-e2e', '--window-size=1280,900', 'about:blank'], { stdio: 'ignore' });

let target;
for (let i = 0; i < 40 && !target; i++) {
  await sleep(250);
  try { target = (await (await fetch(`http://127.0.0.1:${PORT}/json/list`)).json()).find((t) => t.type === 'page'); } catch {}
}
const ws = new WebSocket(target.webSocketDebuggerUrl);
await new Promise((r) => (ws.onopen = r));

let id = 0; const pending = new Map(); const errors = [];
ws.onmessage = (m) => {
  const msg = JSON.parse(m.data);
  if (msg.id && pending.has(msg.id)) { pending.get(msg.id)(msg); pending.delete(msg.id); }
  if (msg.method === 'Runtime.exceptionThrown') errors.push(msg.params.exceptionDetails.exception?.description || msg.params.exceptionDetails.text);
  if (msg.method === 'Page.javascriptDialogOpening') send('Page.handleJavaScriptDialog', { accept: true });
};
const send = (method, params = {}) => new Promise((r) => { const i = ++id; pending.set(i, r); ws.send(JSON.stringify({ id: i, method, params })); });
await send('Page.enable'); await send('Runtime.enable');

async function go(path) { errors.length = 0; await send('Page.navigate', { url: BASE + path }); await sleep(1500); }
async function js(expr) {
  const r = await send('Runtime.evaluate', { expression: `(async()=>{${expr}})()`, awaitPromise: true, returnByValue: true });
  if (r.result.exceptionDetails) return 'EXCEPTION: ' + r.result.exceptionDetails.exception?.description;
  return r.result.result.value;
}
async function key(k, code, extra = {}) {
  await send('Input.dispatchKeyEvent', { type: 'keyDown', key: k, code, windowsVirtualKeyCode: extra.vk || 0, ...extra });
  await send('Input.dispatchKeyEvent', { type: 'keyUp', key: k, code, windowsVirtualKeyCode: extra.vk || 0 });
}

const results = [];
function check(idn, name, actual, expected) {
  const pass = JSON.stringify(actual) === JSON.stringify(expected);
  results.push({ idn, name, pass, actual, expected });
  console.log(`${pass ? 'PASS' : 'FAIL'} ${idn} ${name}${pass ? '' : `\n      expected ${JSON.stringify(expected)}\n      got      ${JSON.stringify(actual)}`}`);
}
// Helper injected into pages: set a field and fire events
const SET = `const set=(id,v)=>{const e=document.getElementById(id); if(e.type==='checkbox'){e.checked=v}else{e.value=v}; e.dispatchEvent(new Event('input',{bubbles:true})); e.dispatchEvent(new Event('change',{bubbles:true}));};
const errs=()=>[...document.querySelectorAll('.error-msg')].filter(e=>e.textContent).map(e=>e.id);
const submit=(id)=>document.getElementById(id).requestSubmit();`;

// ---------- every page loads with no JS errors ----------
await go('index.php'); await js(`localStorage.clear()`);
for (const p of ['index.php', 'albums.php', 'tours.php', 'fanwall.php', 'shop.php', 'about.php', 'account.php', 'shop_add_form.php']) {
  await go(p);
  check('L-' + p, `${p} loads with no JS errors and has nav + footer`, { errors: errors.slice(), nav: await js(`return document.querySelectorAll('.site-nav .nav-link').length`), aoc: await js(`return document.body.innerText.includes('Traditional Owners')`) }, { errors: [], nav: 6, aoc: true });
}

// ---------- home ----------
await go('index.php');
check('H1', 'Bootstrap loaded and carousel has 4 slides', await js(`return [typeof bootstrap, document.querySelectorAll('.carousel-item').length]`), ['object', 4]);
check('H2', 'All images have non-empty alt text (site-wide sample: home)', await js(`return [...document.images].every(i=>i.alt.trim().length>5)`), true);
check('H3', 'Video iframe has a title', await js(`return !!document.querySelector('iframe[title]')`), true);
await js(`document.querySelector('.carousel-control-next').click()`); await sleep(900);
check('H4', 'Next arrow moves the carousel to slide 2', await js(`return [...document.querySelectorAll('.carousel-item')].findIndex(e=>e.classList.contains('active'))`), 1);

// ---------- keyboard: skip link ----------
await go('albums.php');
await key('Tab', 'Tab', { vk: 9 });
check('K1', 'First Tab press focuses the "Skip to main content" link', await js(`return document.activeElement.className`), 'skip-link');

// ---------- albums ----------
check('A1', 'No tracklist shown on load', await js(`return [...document.querySelectorAll('.tracklist')].filter(t=>!t.hidden).length`), 0);
await js(`document.querySelector('.album-link[data-album="wywh"]').click()`); await sleep(300);
check('A2', 'Clicking "Wish You Were Here" (no cover) in the list shows its 5-track table', await js(`const t=document.getElementById('tracks-wywh'); return [t.hidden, t.querySelectorAll('tbody tr').length]`), [false, 5]);
await js(`document.querySelector('.album-cover[data-album="dsotm"]').click()`); await sleep(300);
check('A3', 'Clicking the Dark Side cover shows its table and hides the previous one', await js(`return [document.getElementById('tracks-dsotm').hidden, document.getElementById('tracks-wywh').hidden, document.querySelector('.album-cover[data-album="dsotm"]').getAttribute('aria-expanded')]`), [false, true, 'true']);
await js(`document.querySelector('.album-cover[data-album="dsotm"]').click()`); await sleep(300);
check('A4', 'Clicking the same cover again closes it', await js(`return [document.getElementById('tracks-dsotm').hidden, document.getElementById('tracks-hint').hidden]`), [true, false]);
check('A5', 'Ordered list has all 9 albums, each clickable', await js(`return document.querySelectorAll('ol .album-link').length`), 9);
await go('index.php'); await go('albums.php#tracks-animals');
check('A6', 'Opening albums.php#tracks-animals shows Animals straight away', await js(`return [document.getElementById('tracks-animals').hidden, document.querySelectorAll('.tracklist:not([hidden])').length]`), [false, 1]);

// ---------- tours ----------
await go('tours.php');
check('T1', 'Tour dropdown disabled until a year is picked', await js(`return document.getElementById('tour-name').disabled`), true);
await js(`${SET} set('tour-year','1988')`); await sleep(200);
check('T2', 'Year 1988 lists its 2 tours, details still hidden', await js(`const s=document.getElementById('tour-name'); return [s.disabled, s.options.length-1, document.getElementById('tour-details').hidden]`), [false, 2, true]);
await js(`${SET} const s=document.getElementById('tour-name'); set('tour-name', s.options[1].value)`); await sleep(200);
check('T3', 'Picking a tour fills in name, cities and setlist', await js(`return [document.getElementById('tour-details').hidden, document.getElementById('detail-name').textContent.includes('1988'), document.querySelectorAll('#detail-cities li').length>0, document.querySelectorAll('#detail-setlist li').length>0]`), [false, true, true, true]);
await js(`${SET} set('tour-year','1973')`); await sleep(200);
check('T4', 'A year with one tour auto-selects it and shows details', await js(`return [document.getElementById('tour-details').hidden, document.getElementById('detail-name').textContent]`), [false, 'The Dark Side of the Moon Tour (1973)']);
await js(`${SET} set('tour-year','')`); await sleep(200);
check('T5', 'Clearing the year hides details and disables the tour list', await js(`return [document.getElementById('tour-details').hidden, document.getElementById('tour-name').disabled]`), [true, true]);

// ---------- fan wall ----------
await go('fanwall.php');
check('F1', 'Wall starts with 2 starter posts', await js(`return document.querySelectorAll('#wall-body tr').length`), 2);
await js(`${SET} submit('wall-form')`); await sleep(200);
check('F2', 'Empty submit shows rating, song and review errors', await js(`${SET} return errs()`), ['rating-error', 'song-error', 'review-error']);
await js(`${SET} set('rating','5'); set('song','Time'); set('review','short')`);
await js(`${SET} submit('wall-form')`); await sleep(200);
check('F3', 'Review under 10 characters is rejected', await js(`${SET} return errs()`), ['review-error']);
await js(`${SET} set('review','Those clocks at the start get me every time.'); set('author','<b>x</b>')`);
await js(`${SET} submit('wall-form')`); await sleep(200);
check('F4', 'Display name with HTML characters is rejected', await js(`${SET} return errs()`), ['author-error']);
await js(`${SET} set('author','')`);
check('F5', 'Character counter updates on input', await js(`return document.getElementById('char-count').textContent`), '44');
await js(`document.getElementById('review').focus()`);
await key('Enter', 'Enter', { vk: 13, modifiers: 2 }); await sleep(300);
check('F6', 'Ctrl+Enter posts; new post is on top as "Anonymous fan"', await js(`const r=document.querySelector('#wall-body tr'); return [document.querySelectorAll('#wall-body tr').length, r.cells[1].textContent, r.cells[3].textContent]`), [3, 'Time', 'Anonymous fan']);
await go('fanwall.php');
check('F7', 'Post is still there after a page reload (localStorage)', await js(`return document.querySelector('#wall-body tr').cells[1].textContent`), 'Time');
for (let i = 0; i < 7; i++) {
  await js(`${SET} set('rating','3'); set('song','Song ${i}'); set('review','Review number ${i} for the stack test'); submit('wall-form')`);
}
await sleep(200);
check('F8', 'Stack is capped at 8: oldest dropped, newest on top', await js(`const rows=[...document.querySelectorAll('#wall-body tr')]; return [rows.length, rows[0].cells[1].textContent, rows.some(r=>r.cells[1].textContent==='Comfortably Numb')]`), [8, 'Song 6', false]);

// ---------- account ----------
await go('account.php');
await js(`${SET} submit('signup-form')`); await sleep(200);
check('U1', 'Empty sign-up shows errors on all required fields', await js(`${SET} return errs()`), ['up-name-error', 'up-email-error', 'up-dob-error', 'up-password-error', 'up-confirm-error', 'up-human-error']);
await js(`${SET} set('up-name','Sam Taylor'); set('up-email','sam@example.com'); set('up-dob', new Date(Date.now()-10*365*864e5).toISOString().slice(0,10)); set('up-phone','12345'); set('up-password','password'); set('up-confirm','password1'); set('up-human',true); submit('signup-form')`); await sleep(200);
check('U2', 'Under 13, bad phone, password without number, mismatch all caught', await js(`${SET} return errs()`), ['up-dob-error', 'up-phone-error', 'up-password-error', 'up-confirm-error']);
check('U3', 'First invalid field receives keyboard focus', await js(`return document.activeElement.id`), 'up-dob');
await js(`${SET} set('up-dob','1990-05-01'); set('up-phone','0412 345 678'); set('up-password','shine0n123'); set('up-confirm','shine0n123'); submit('signup-form')`); await sleep(300);
check('U4', 'Valid sign-up: success message, account saved without password', await js(`return [document.getElementById('signup-success').hidden, localStorage.getItem('pfa_accounts'), localStorage.getItem('pfa_signed_in')]`), [false, '[{"name":"Sam Taylor","email":"sam@example.com"}]', 'Sam']);
await sleep(1800);
check('U5', 'Redirects home and header shows "Welcome, Sam" + Log out', await js(`return [location.pathname, document.getElementById('account-area').innerText.replace(/\\s+/g,' ').trim()]`), ['/index.php', 'Welcome, Sam LOG OUT']);
await js(`document.querySelector('#account-area button').click()`); await sleep(1200);
check('U6', 'Log out restores Sign in / Sign up', await js(`return [localStorage.getItem('pfa_signed_in'), !!document.querySelector('#account-area a[href*="signin"]')]`), [null, true]);
await go('account.php');
await js(`${SET} set('up-name','Sam Taylor'); set('up-email','SAM@example.com'); set('up-dob','1990-05-01'); set('up-password','shine0n123'); set('up-confirm','shine0n123'); set('up-human',true); submit('signup-form')`); await sleep(200);
check('U7', 'Signing up again with the same email (any case) is blocked', await js(`return document.getElementById('up-email-error').textContent.includes('already registered')`), true);
await js(`${SET} set('in-email','nobody@example.com'); set('in-password','x'); submit('signin-form')`); await sleep(200);
check('U8', 'Sign in with an unknown email is rejected', await js(`return document.getElementById('in-email-error').textContent.includes('No account')`), true);
await js(`${SET} set('in-email','sam@example.com'); set('in-password','whatever1'); submit('signin-form')`); await sleep(1600);
check('U9', 'Sign in with a registered email welcomes the user', await js(`return document.getElementById('account-area').innerText.includes('Welcome, Sam')`), true);

// ---------- about ----------
await go('about.php');
await js(`${SET} submit('contact-form')`); await sleep(200);
check('C1', 'Empty contact form shows 4 errors', await js(`${SET} return errs()`), ['c-name-error', 'c-email-error', 'c-type-error', 'c-message-error']);
await js(`${SET} set('c-name','Alex'); set('c-email','alex@'); set('c-type','complaint'); set('c-message','Too short complaint'); submit('contact-form')`); await sleep(200);
check('C2', 'Bad email + complaint under 30 chars are rejected', await js(`${SET} return errs()`), ['c-email-error', 'c-message-error']);
await js(`${SET} set('c-email','alex@example.com'); set('c-message','The tour page is missing the 1994 Earls Court dates.'); submit('contact-form')`); await sleep(200);
check('C3', 'Valid message shows thank-you and clears the form', await js(`return [document.getElementById('contact-success').hidden, document.getElementById('c-name').value]`), [false, '']);

// ---------- read aloud ----------
check('R1', 'Read-aloud button present and speechSynthesis available', await js(`return [!!document.getElementById('read-aloud') && !document.getElementById('read-aloud').hidden, 'speechSynthesis' in window]`), [true, true]);

await js(`window.__n = 0; const real = speechSynthesis.speak.bind(speechSynthesis); speechSynthesis.speak = (u) => { window.__n++; real(u); }; document.getElementById('read-aloud').click();`);
await sleep(400);
check('R2', 'Click Read aloud: page queued sentence by sentence, button becomes "Stop reading"', await js(`return [window.__n > 5, document.getElementById('read-aloud').getAttribute('aria-pressed')]`), [true, 'true']);
await key('Escape', 'Escape', { vk: 27 }); await sleep(200);
check('R3', 'Esc stops reading and resets the button', await js(`return document.getElementById('read-aloud').getAttribute('aria-pressed')`), 'false');

// ---------- shop (JS side; PHP side tested with curl) ----------
await go('shop_add_form.php?category_id=2');
check('S1', 'Add form pre-selects the category you came from', await js(`return document.getElementById('category_id').value`), '2');
await js(`${SET} submit('product-form')`); await sleep(300);
check('S2', 'Empty add form is stopped by JS (stays on page, 3 errors)', [await js(`return location.pathname`), await js(`${SET} return errs()`)], ['/shop_add_form.php', ['code-error', 'name-error', 'price-error']]);
await js(`${SET} set('code','e2etest'); set('name','E2E Test Tee'); set('price','10'); submit('product-form')`); await sleep(1200);
check('S3', 'Valid add goes back to the list with "Product added." and the new row', await js(`return [location.search, document.body.innerText.includes('Product added.'), document.body.innerText.includes('E2E Test Tee')]`), ['?category_id=2&msg=added', true, true]);
await js(`const row=[...document.querySelectorAll('tbody tr')].find(r=>r.innerText.includes('E2E Test Tee')); row.querySelector('.delete-form').requestSubmit()`); await sleep(1200);
check('S4', 'Delete (after confirm dialog) removes the row', await js(`return [document.body.innerText.includes('Product deleted.'), document.body.innerText.includes('E2E Test Tee')]`), [true, false]);

const failed = results.filter((r) => !r.pass);
console.log(`\n${results.length - failed.length}/${results.length} passed`);

ws.close(); chrome.kill();
process.exit(0);
