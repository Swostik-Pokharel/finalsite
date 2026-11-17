// =========================================================
// about.js: contact form validation + share button
// =========================================================

const contactForm = document.getElementById('contact-form');
const contactSuccess = document.getElementById('contact-success');

// Simple email pattern: something@something.something
const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function setError(id, message) {
    document.getElementById(id + '-error').textContent = message;
    document.getElementById(id).classList.toggle('is-invalid', message !== '');
}

function validateContact() {
    let ok = true;
    const name = document.getElementById('c-name').value.trim();
    const email = document.getElementById('c-email').value.trim();
    const type = document.getElementById('c-type').value;
    const message = document.getElementById('c-message').value.trim();

    if (name === '') { setError('c-name', 'Please enter your name.'); ok = false; }
    else { setError('c-name', ''); }

    if (email === '') {
        setError('c-email', 'Please enter your email address.'); ok = false;
    } else {
        if (!EMAIL_PATTERN.test(email)) { setError('c-email', 'That email address doesn\'t look right.'); ok = false; }
        else { setError('c-email', ''); }
    }

    if (type === '') { setError('c-type', 'Please choose a message type.'); ok = false; }
    else { setError('c-type', ''); }

    // LOGIC RULE: complaints need more detail than general feedback
    const minLength = (type === 'complaint') ? 30 : 10;
    if (message === '') {
        setError('c-message', 'Please write a message.'); ok = false;
    } else {
        if (message.length < minLength) {
            setError('c-message', 'Please write at least ' + minLength + ' characters' +
                (type === 'complaint' ? ' so we can look into your complaint properly.' : '.'));
            ok = false;
        } else {
            setError('c-message', '');
        }
    }
    return ok;
}

// EVENT: submit
contactForm.addEventListener('submit', function (event) {
    event.preventDefault();
    contactSuccess.hidden = true;
    if (!validateContact()) {
        contactForm.querySelector('.is-invalid').focus();
        return;
    }
    const name = document.getElementById('c-name').value.trim();
    // No mail server in this project, so we confirm on screen instead of sending
    contactSuccess.textContent = 'Thanks, ' + name + '! Your message has been received. We aim to reply within 3 days.';
    contactSuccess.hidden = false;
    contactForm.reset();
});

// ---------- Share button ----------
const shareBtn = document.getElementById('share-btn');
const shareStatus = document.getElementById('share-status');

// EVENT: click
shareBtn.addEventListener('click', function () {
    const url = window.location.origin + '/index.php';
    // LOGIC: use the phone/OS share sheet if the browser has one, otherwise copy the link
    if (navigator.share) {
        navigator.share({ title: 'Pink Floyd Archives', url: url }).catch(function () { /* user cancelled */ });
    } else if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(function () {
            shareStatus.textContent = 'Link copied to your clipboard.';
        });
    } else {
        shareStatus.textContent = 'Copy this link: ' + url;
    }
});
