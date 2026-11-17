// =========================================================
// main.js: runs on EVERY page (loaded from includes/footer.php)
//   1. Read-aloud button (accessibility feature #2, text-to-speech)
//   2. Header account area: "Welcome, Name" + Logout, or Sign in / Sign up
// =========================================================

// ---------- 1. Read aloud ----------
const readBtn = document.getElementById('read-aloud');

function stopReading() {
    window.speechSynthesis.cancel();
    readBtn.setAttribute('aria-pressed', 'false');
    readBtn.textContent = '🔊 Read page aloud';
}

if ('speechSynthesis' in window) {
    // EVENT: click
    readBtn.addEventListener('click', function () {
        // LOGIC: toggle. If already speaking, stop; otherwise start.
        if (window.speechSynthesis.speaking) {
            stopReading();
        } else {
            // If the visitor highlighted some text, read just that; otherwise read the main content.
            const selected = window.getSelection().toString().trim();
            const text = selected !== '' ? selected : document.getElementById('main').innerText;

            const speech = new SpeechSynthesisUtterance(text);
            speech.lang = 'en-AU';
            speech.rate = 1;
            speech.onend = stopReading; // reset the button when it finishes by itself

            window.speechSynthesis.speak(speech);
            readBtn.setAttribute('aria-pressed', 'true');
            readBtn.textContent = '⏹ Stop reading';
        }
    });

    // EVENT: keydown. The Escape key stops reading from anywhere on the page.
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && window.speechSynthesis.speaking) {
            stopReading();
        }
    });
} else {
    // Older browsers without speech support: hide the button instead of showing a broken one
    readBtn.hidden = true;
}

// ---------- 2. Account area in the header ----------
// There is no real login server: the brief only needs the database for the shop.
// account.js saves the signed-in name in localStorage; here we read it back.
const accountArea = document.getElementById('account-area');
const signedInName = localStorage.getItem('pfa_signed_in');

if (signedInName) {
    // DYNAMIC CONTENT: replace the Sign in / Sign up buttons
    accountArea.innerHTML = '';

    const welcome = document.createElement('span');
    welcome.className = 'me-1';
    welcome.textContent = 'Welcome, ' + signedInName; // textContent, not innerHTML: safe from injected HTML

    const logoutBtn = document.createElement('button');
    logoutBtn.type = 'button';
    logoutBtn.className = 'btn btn-outline-light btn-sm';
    logoutBtn.textContent = 'Log out';
    logoutBtn.addEventListener('click', function () {
        localStorage.removeItem('pfa_signed_in');
        window.location.reload();
    });

    accountArea.append(welcome, logoutBtn);
}
