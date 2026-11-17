<?php
$pageTitle = 'Fan Wall';
$currentPage = 'fanwall';
$pageScript = 'fanwall.js';
include 'includes/header.php';
?>

<h1>Fan wall</h1>
<p class="lead">What does Pink Floyd mean to you? The newest post always appears at the top.</p>

<section class="panel mb-4" aria-labelledby="wall-heading">
    <h2 id="wall-heading" class="h4">Latest posts</h2>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
            <tr><th scope="col">Rating</th><th scope="col">Song / album</th><th scope="col">Review</th><th scope="col">Posted by</th></tr>
            </thead>
            <tbody id="wall-body">
            <!-- rows built by js/fanwall.js -->
            </tbody>
        </table>
    </div>
    <p class="small text-muted mt-2 mb-0">Posts are saved in this browser only, and the wall keeps the latest
        <span id="max-posts"></span>.</p>
</section>

<section class="panel" aria-labelledby="post-heading">
    <h2 id="post-heading" class="h4">Contribute to the fan wall</h2>
    <form id="wall-form" novalidate>
        <div class="row g-3">
            <div class="col-sm-3">
                <label for="rating" class="form-label">Rating</label>
                <select id="rating" class="form-select">
                    <option value="">Choose…</option>
                    <option value="5">5 / 5</option>
                    <option value="4">4 / 5</option>
                    <option value="3">3 / 5</option>
                    <option value="2">2 / 5</option>
                    <option value="1">1 / 5</option>
                </select>
                <div class="error-msg" id="rating-error"></div>
            </div>
            <div class="col-sm-9">
                <label for="song" class="form-label">Song or album name</label>
                <input type="text" id="song" class="form-control" maxlength="60" placeholder="e.g. Time">
                <div class="error-msg" id="song-error"></div>
            </div>
            <div class="col-sm-8">
                <label for="review" class="form-label">Your review</label>
                <textarea id="review" class="form-control" rows="3" maxlength="200" aria-describedby="review-help"></textarea>
                <div id="review-help" class="form-text"><span id="char-count">0</span>/200 characters. Press Ctrl+Enter (⌘+Enter on Mac) to post.</div>
                <div class="error-msg" id="review-error"></div>
            </div>
            <div class="col-sm-4">
                <label for="author" class="form-label">Display name</label>
                <input type="text" id="author" class="form-control" maxlength="30" placeholder="Leave blank to post anonymously">
                <div class="error-msg" id="author-error"></div>
            </div>
        </div>
        <button type="submit" class="btn btn-accent mt-3">Post to the wall</button>
        <p id="wall-success" class="success-msg mt-3" role="status" hidden></p>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
