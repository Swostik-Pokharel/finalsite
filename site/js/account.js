// =========================================================
// account.js: sign-in and sign-up validation
//
// There is no user table (the brief only needs MySQL for the shop), so:
//   sign up  → validates, then remembers {name, email} in localStorage
//   sign in  → validates, then looks the email up in that saved list
// Passwords are validated but NEVER saved. Storing passwords in the browser
// would be unsafe; a real site would hash them on the server.
// =========================================================

const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const ACCOUNTS_KEY = 'pfa_accounts';

function setError(id, message) {
    document.getElementById(id + '-error').textContent = message;
    document.getElementById(id).classList.toggle('is-invalid', message !== '');
}

function getAccounts() {
    return JSON.parse(localStorage.getItem(ACCOUNTS_KEY)) || [];
}

function value(id) {
    return document.getElementById(id).value.trim();
}

// Age in whole years from a yyyy-mm-dd string
function ageFrom(dateString) {
    const birth = new Date(dateString);
    const today = new Date();
    let age = today.getFullYear() - birth.getFullYear();
    const hadBirthdayThisYear =
        today.getMonth() > birth.getMonth() ||
        (today.getMonth() === birth.getMonth() && today.getDate() >= birth.getDate());
    if (!hadBirthdayThisYear) {
        age--;
    }
    return age;
}

// ---------- Sign up ----------
function validateSignup() {
    let ok = true;
    const name = value('up-name');
    const email = value('up-email');
    const dob = value('up-dob');
    const phone = value('up-phone').replace(/\s/g, ''); // ignore spaces
    const password = document.getElementById('up-password').value;
    const confirm = document.getElementById('up-confirm').value;

    // Name: required, letters/spaces/'/- only
    if (name === '') {
        setError('up-name', 'Please enter your full name.'); ok = false;
    } else if (!/^[A-Za-zÀ-ÿ' -]{2,}$/.test(name)) {
        setError('up-name', 'Use letters, spaces, apostrophes or hyphens.'); ok = false;
    } else {
        setError('up-name', '');
    }

    // Email: required, valid format, not already registered
    if (email === '') {
        setError('up-email', 'Please enter your email address.'); ok = false;
    } else {
        if (!EMAIL_PATTERN.test(email)) {
            setError('up-email', 'That email address doesn\'t look right.'); ok = false;
        } else {
            const exists = getAccounts().some(function (a) { return a.email === email.toLowerCase(); });
            if (exists) { setError('up-email', 'That email is already registered. Try signing in.'); ok = false; }
            else { setError('up-email', ''); }
        }
    }

    // Date of birth: required, not in the future, at least 13 years old (nested if/else)
    if (dob === '') {
        setError('up-dob', 'Please enter your date of birth.'); ok = false;
    } else {
        const age = ageFrom(dob);
        if (age < 0) {
            setError('up-dob', 'That date is in the future.'); ok = false;
        } else {
            if (age < 13) { setError('up-dob', 'Sorry, you need to be 13 or older.'); ok = false; }
            else if (age > 120) { setError('up-dob', 'Please check the year.'); ok = false; }
            else { setError('up-dob', ''); }
        }
    }

    // Phone: optional, but if given it must be an Australian-style 10 digits starting with 0, or +61
    if (phone !== '' && !/^(0\d{9}|\+61\d{9})$/.test(phone)) {
        setError('up-phone', 'Enter 10 digits starting with 0, or +61 then 9 digits.'); ok = false;
    } else {
        setError('up-phone', '');
    }

    // Password: at least 8 chars with a number
    if (password.length < 8) {
        setError('up-password', 'Password must be at least 8 characters.'); ok = false;
    } else if (!/\d/.test(password)) {
        setError('up-password', 'Password must include at least one number.'); ok = false;
    } else {
        setError('up-password', '');
    }

    // Confirm: must match
    if (confirm === '' || confirm !== password) {
        setError('up-confirm', 'Passwords don\'t match.'); ok = false;
    } else {
        setError('up-confirm', '');
    }

    // Checkbox
    if (!document.getElementById('up-human').checked) {
        setError('up-human', 'Please tick the box.'); ok = false;
    } else {
        setError('up-human', '');
    }
    return ok;
}

const signupForm = document.getElementById('signup-form');

// EVENT: submit
signupForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const successBox = document.getElementById('signup-success');
    successBox.hidden = true;

    if (!validateSignup()) {
        signupForm.querySelector('.is-invalid').focus();
        return;
    }

    const name = value('up-name');
    const accounts = getAccounts();
    accounts.push({ name: name, email: value('up-email').toLowerCase() }); // no password stored
    localStorage.setItem(ACCOUNTS_KEY, JSON.stringify(accounts));
    localStorage.setItem('pfa_signed_in', name.split(' ')[0]); // sign them straight in, first name only

    successBox.textContent = 'Welcome aboard, ' + name + '! You are now signed in.';
    successBox.hidden = false;
    signupForm.reset();
    setTimeout(function () { window.location.href = 'index.php'; }, 1500);
});

// ---------- Sign in ----------
const signinForm = document.getElementById('signin-form');

// EVENT: submit
signinForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const successBox = document.getElementById('signin-success');
    successBox.hidden = true;
    let ok = true;
    const email = value('in-email').toLowerCase();
    const password = document.getElementById('in-password').value;
    let account = null;

    if (email === '') {
        setError('in-email', 'Please enter your email address.'); ok = false;
    } else {
        if (!EMAIL_PATTERN.test(email)) {
            setError('in-email', 'That email address doesn\'t look right.'); ok = false;
        } else {
            account = getAccounts().find(function (a) { return a.email === email; });
            if (!account) { setError('in-email', 'No account found for that email in this browser. Please sign up first.'); ok = false; }
            else { setError('in-email', ''); }
        }
    }

    if (password === '') { setError('in-password', 'Please enter your password.'); ok = false; }
    else { setError('in-password', ''); }

    if (!ok) {
        signinForm.querySelector('.is-invalid').focus();
        return;
    }

    localStorage.setItem('pfa_signed_in', account.name.split(' ')[0]);
    successBox.textContent = 'Signed in. Welcome back, ' + account.name + '!';
    successBox.hidden = false;
    setTimeout(function () { window.location.href = 'index.php'; }, 1200);
});
