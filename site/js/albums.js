// =========================================================
// albums.js: show/hide a tracklist when an album is chosen
// LOGIC RULE: only one tracklist is visible at a time.
// =========================================================

const covers = document.querySelectorAll('.album-cover');
const listLinks = document.querySelectorAll('.album-link');
const tracklists = document.querySelectorAll('.tracklist');
const hint = document.getElementById('tracks-hint');

function showAlbum(albumId) {
    const target = document.getElementById('tracks-' + albumId);
    const alreadyOpen = !target.hidden;

    // Hide every tracklist and mark every cover as closed
    for (let i = 0; i < tracklists.length; i++) {
        tracklists[i].hidden = true;
    }
    for (let i = 0; i < covers.length; i++) {
        covers[i].setAttribute('aria-expanded', 'false');
    }

    // Clicking the album that is already open closes it (toggle)
    if (alreadyOpen) {
        hint.hidden = false;
        return;
    }

    target.hidden = false;
    hint.hidden = true;
    document.querySelector('.album-cover[data-album="' + albumId + '"]').setAttribute('aria-expanded', 'true');
    target.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// EVENT: click on a cover
covers.forEach(function (cover) {
    cover.addEventListener('click', function () {
        showAlbum(cover.dataset.album);
    });
});

// EVENT: click on a title in the ordered list
listLinks.forEach(function (link) {
    link.addEventListener('click', function (event) {
        event.preventDefault(); // stop the jump, showAlbum() scrolls smoothly instead
        const target = document.getElementById('tracks-' + link.dataset.album);
        if (target.hidden) {
            showAlbum(link.dataset.album);
        } else {
            target.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    });
});
