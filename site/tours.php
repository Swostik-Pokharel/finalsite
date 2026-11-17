<?php
$pageTitle = 'Tours';
$currentPage = 'tours';
$pageScript = 'tours.js';
include 'includes/header.php';
?>

<h1>Tour lookup</h1>
<p class="lead">Pick a year, then a tour, and the details fill in below.</p>

<div class="panel mb-4">
    <form id="tour-form" class="row g-3" novalidate>
        <div class="col-sm-4">
            <label for="tour-year" class="form-label">Year</label>
            <select id="tour-year" class="form-select">
                <option value="">Choose a year…</option>
                <!-- options added by js/tours.js from the tours data -->
            </select>
        </div>
        <div class="col-sm-8">
            <label for="tour-name" class="form-label">Tours that year</label>
            <select id="tour-name" class="form-select" disabled>
                <option value="">Choose a year first</option>
            </select>
        </div>
    </form>
    <p class="note mt-3 mb-0">Not sure where to start? Try <strong>1980</strong> for The Wall tour, famous for
        building a real wall across the stage during the show.</p>
</div>

<!-- aria-live: screen readers announce the new details when they appear -->
<section id="tour-details" class="panel" aria-live="polite" hidden>
    <h2 id="detail-name" class="h3"></h2>
    <div class="row g-4">
        <div class="col-md-6">
            <h3 class="h6 text-uppercase">Cities covered</h3>
            <ul id="detail-cities"></ul>
        </div>
        <div class="col-md-6">
            <h3 class="h6 text-uppercase">Setlist highlights</h3>
            <ol id="detail-setlist"></ol>
        </div>
    </div>
    <dl class="row mb-0">
        <dt class="col-sm-5">Average attendance</dt>
        <dd class="col-sm-7" id="detail-attendance"></dd>
        <dt class="col-sm-5">Average ticket price (at the time)</dt>
        <dd class="col-sm-7" id="detail-price"></dd>
    </dl>
</section>

<p class="small text-muted mt-3">Attendance and ticket prices are rounded estimates for this student project, not official figures.</p>

<?php include 'includes/footer.php'; ?>
