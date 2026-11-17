// =========================================================
// fanwall.js: fan reviews kept in a STACK
//
// A stack is "last in, first out" (LIFO): like a pile of plates, the
// newest one goes on top and is the first one you see.
//   push() puts a post on top.
//   We display from the top down, so the newest post is first.
//   When the stack is full we drop the OLDEST post (the bottom) with shift().
// The stack is saved in localStorage so posts survive a page refresh.
// =========================================================

const MAX_POSTS = 8;
const STORAGE_KEY = 'pfa_fanwall';

// Starter posts so the wall isn't empty the first time
const starterPosts = [
    { rating: 5, song: 'Comfortably Numb', review: 'That second guitar solo still gives me chills.', author: 'nightowl' },
    { rating: 4, song: 'Time', review: 'Greatest song of all time, those clocks at the start!', author: 'user1' }
];

// Load the stack (or the starter posts if nothing is saved yet)
let stack = JSON.parse(localStorage.getItem(STORAGE_KEY)) || starterPosts;

const wallBody = document.getElementById('wall-body');
const form = document.getElementById('wall-form');
const review = document.getElementById('review');
const charCount = document.getElementById('char-count');
const success = document.getElementById('wall-success');
document.getElementById('max-posts').textContent = MAX_POSTS;

function pushPost(post) {
    stack.push(post);                 // newest on top
    if (stack.length > MAX_POSTS) {
        stack.shift();                // full, so remove the oldest from the bottom
    }
    localStorage.setItem(STORAGE_KEY, JSON.stringify(stack));
}

function renderWall() {
    wallBody.innerHTML = '';
    // Loop from the TOP of the stack (last index) down to the bottom (index 0)
    for (let i = stack.length - 1; i >= 0; i--) {
        const post = stack[i];
        const row = document.createElement('tr');

        // Rating cell: stars for looks (hidden from screen readers) + "4/5" as text
        const ratingCell = document.createElement('td');
        const stars = document.createElement('span');
        stars.className = 'stars';
        stars.setAttribute('aria-hidden', 'true');
        stars.textContent = '★'.repeat(post.rating) + '☆'.repeat(5 - post.rating) + ' ';
        ratingCell.append(stars, post.rating + '/5');
        row.appendChild(ratingCell);

        // Other cells built with textContent so a visitor can't inject HTML into the page
        [post.song, post.review, post.author].forEach(function (value) {
            const cell = document.createElement('td');
            cell.textContent = value;
            row.appendChild(cell);
        });
        wallBody.appendChild(row);
    }
}

function setError(id, message) {
    document.getElementById(id + '-error').textContent = message;
    document.getElementById(id).classList.toggle('is-invalid', message !== '');
}

// Returns true if the form is OK. Uses nested if/else as the brief asks.
function validate() {
    let ok = true;
    const rating = document.getElementById('rating').value;
    const song = document.getElementById('song').value.trim();
    const text = review.value.trim();
    const author = document.getElementById('author').value.trim();

    if (rating === '') { setError('rating', 'Please choose a rating.'); ok = false; }
    else { setError('rating', ''); }

    if (song === '') {
        setError('song', 'Please name a song or album.'); ok = false;
    } else {
        if (song.length < 2) { setError('song', 'That name looks too short.'); ok = false; }
        else { setError('song', ''); }
    }

    if (text === '') {
        setError('review', 'Please write a short review.'); ok = false;
    } else {
        if (text.length < 10) { setError('review', 'Reviews need at least 10 characters.'); ok = false; }
        else { setError('review', ''); }
    }

    // Display name is optional, but if given it must be letters, numbers, spaces, _ or -
    if (author !== '' && !/^[\w -]+$/.test(author)) {
        setError('author', 'Use letters, numbers, spaces, _ or - only.'); ok = false;
    } else {
        setError('author', '');
    }
    return ok;
}

// EVENT: input. Live character counter.
review.addEventListener('input', function () {
    charCount.textContent = review.value.length;
});

// EVENT: keydown. Ctrl+Enter / Cmd+Enter submits from inside the textarea.
review.addEventListener('keydown', function (event) {
    if (event.key === 'Enter' && (event.ctrlKey || event.metaKey)) {
        event.preventDefault();
        form.requestSubmit(); // triggers the submit handler below, including validation
    }
});

// EVENT: submit
form.addEventListener('submit', function (event) {
    event.preventDefault(); // stay on the page, we handle it in JS
    success.hidden = true;
    if (!validate()) {
        form.querySelector('.is-invalid').focus(); // take keyboard users to the first problem
        return;
    }
    const authorValue = document.getElementById('author').value.trim();
    pushPost({
        rating: Number(document.getElementById('rating').value),
        song: document.getElementById('song').value.trim(),
        review: review.value.trim(),
        author: authorValue === '' ? 'Anonymous fan' : authorValue
    });
    renderWall();
    form.reset();
    charCount.textContent = '0';
    success.textContent = 'Thanks! Your post is now at the top of the wall.';
    success.hidden = false;
});

renderWall();
