<?php
$pageTitle = 'About';
$currentPage = 'about';
$pageScript = 'about.js';
include 'includes/header.php';
?>

<h1>About this archive</h1>

<!-- Page 6 requirement: description of the brand / team -->
<section class="panel mb-4" aria-labelledby="creator-heading">
    <h2 id="creator-heading" class="h4">Who runs it</h2>
    <div class="d-flex flex-column flex-sm-row gap-4 align-items-sm-center">
        <div class="avatar flex-shrink-0" role="img" aria-label="Initials of the site creator">SP</div>
        <div>
            <h3 class="h5 mb-1">Swostik Pokharel, creator and admin</h3>
            <p class="mb-0">A student web developer and long-time listener. The goal of Pink Floyd Archives is a
                friendly, accessible home where anyone can explore the band's music, whether this is their first
                album or their fiftieth listen.</p>
        </div>
    </div>
</section>

<section class="panel mb-4" aria-labelledby="disclaimer-heading">
    <h2 id="disclaimer-heading" class="h4">A fan project</h2>
    <p class="mb-0">This is an archive run by a fan. It is not an attempt to copy the band's work, and it is not
        affiliated with Pink Floyd or their labels. Album artwork belongs to its owners, and the official home of
        the band is <a href="https://www.pinkfloyd.com" target="_blank" rel="noopener">pinkfloyd.com (opens in a new tab)</a>.</p>
</section>

<!-- Page 6 requirement: at least 3 accessibility features (we list what the site implements) -->
<section class="panel mb-4" aria-labelledby="a11y-heading">
    <h2 id="a11y-heading" class="h4">Accessibility and inclusion</h2>
    <p>Everyone should be able to enjoy this site. Here is what we have built in:</p>
    <ul>
        <li><strong>High-contrast colours:</strong> light text on a dark background, with amber and blue accents
            and no red/green colour pairs, so the site stays readable for people with colour blindness.</li>
        <li><strong>Read aloud:</strong> the "Read page aloud" button in the header reads the page (or any text
            you highlight) using your browser's text-to-speech. Press Esc to stop.</li>
        <li><strong>Alt text:</strong> every image has a description for screen readers, and the video has a title.</li>
        <li><strong>Keyboard friendly:</strong> press Tab on any page to reach the "Skip to main content" link.
            Every button, link and form field can be used without a mouse and has a visible focus outline.</li>
        <li><strong>Inclusive language:</strong> we write for "fans", "visitors" and "people", and we never assume
            anyone's gender, culture or background.</li>
        <li><strong>Acknowledgement of Country:</strong> shown below and in the footer of every page.</li>
    </ul>
</section>

<!-- Page 6 requirement: Acknowledgement of Country (First Nations) -->
<section class="panel mb-4" aria-labelledby="aoc-heading">
    <h2 id="aoc-heading" class="h4">Acknowledgement of Country</h2>
    <p class="mb-0">We acknowledge the Traditional Owners of the land on which this website was created and pay
        our respects to Elders past and present. We recognise the continuing connection of Aboriginal and Torres
        Strait Islander peoples to land, waters, music and culture.</p>
</section>

<div class="row g-4">
    <!-- Contact / feedback / complaint form, validated in js/about.js -->
    <section class="col-lg-7" aria-labelledby="contact-heading">
        <div class="panel h-100" id="contact">
            <h2 id="contact-heading" class="h4">Contact, feedback or complaints</h2>
            <form id="contact-form" novalidate>
                <div class="mb-3">
                    <label for="c-name" class="form-label">Your name</label>
                    <input type="text" id="c-name" class="form-control" autocomplete="name">
                    <div class="error-msg" id="c-name-error"></div>
                </div>
                <div class="mb-3">
                    <label for="c-email" class="form-label">Email address</label>
                    <input type="email" id="c-email" class="form-control" autocomplete="email">
                    <div class="error-msg" id="c-email-error"></div>
                </div>
                <div class="mb-3">
                    <label for="c-type" class="form-label">Type of message</label>
                    <select id="c-type" class="form-select">
                        <option value="">Choose…</option>
                        <option value="feedback">Feedback</option>
                        <option value="question">Question</option>
                        <option value="complaint">Complaint</option>
                    </select>
                    <div class="error-msg" id="c-type-error"></div>
                </div>
                <div class="mb-3">
                    <label for="c-message" class="form-label">Message</label>
                    <textarea id="c-message" class="form-control" rows="4"></textarea>
                    <div class="error-msg" id="c-message-error"></div>
                </div>
                <button type="submit" class="btn btn-accent">Send message</button>
                <p id="contact-success" class="success-msg mt-3" role="status" hidden></p>
            </form>
        </div>
    </section>

    <!-- Page 6 requirement: contact information / social links + support the project -->
    <section class="col-lg-5" aria-labelledby="social-heading">
        <div class="panel h-100">
            <h2 id="social-heading" class="h4">Find us and support the project</h2>
            <ul class="list-unstyled">
                <li>Email: <a href="mailto:hello@pinkfloydarchives.example">hello@pinkfloydarchives.example</a></li>
                <li>Instagram: <a href="https://www.instagram.com/pinkfloyd/" target="_blank" rel="noopener">@pinkfloyd (official band account)</a></li>
                <li>YouTube: <a href="https://www.youtube.com/@pinkfloyd" target="_blank" rel="noopener">Pink Floyd official channel</a></li>
            </ul>
            <p>Want to help the archive grow? Buy something from the <a href="shop.php">merch shop</a> or share
                the site with a friend.</p>
            <button type="button" id="share-btn" class="btn btn-outline-light">Share this site</button>
            <p id="share-status" class="small mt-2 mb-0" role="status"></p>
        </div>
    </section>
</div>

<?php include 'includes/footer.php'; ?>
