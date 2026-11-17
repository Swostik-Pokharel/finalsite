<?php
$pageTitle = 'Sign in or sign up';
$currentPage = 'account'; // not in the nav, reached from the header buttons
$pageScript = 'account.js';
include 'includes/header.php';
?>

<h1>Your account</h1>
<p class="lead">Sign up for the monthly newsletter and to post on the fan wall under your own name.</p>

<div class="row g-4">
    <section class="col-lg-5" aria-labelledby="signin-heading">
        <div class="panel h-100" id="signin">
            <h2 id="signin-heading" class="h4">Sign in</h2>
            <form id="signin-form" novalidate>
                <div class="mb-3">
                    <label for="in-email" class="form-label">Email address</label>
                    <input type="email" id="in-email" class="form-control" autocomplete="email">
                    <div class="error-msg" id="in-email-error"></div>
                </div>
                <div class="mb-3">
                    <label for="in-password" class="form-label">Password</label>
                    <input type="password" id="in-password" class="form-control" autocomplete="current-password">
                    <div class="error-msg" id="in-password-error"></div>
                </div>
                <button type="submit" class="btn btn-accent">Sign in</button>
                <p id="signin-success" class="success-msg mt-3" role="status" hidden></p>
            </form>
        </div>
    </section>

    <section class="col-lg-7" aria-labelledby="signup-heading">
        <div class="panel h-100" id="signup">
            <h2 id="signup-heading" class="h4">Sign up</h2>
            <form id="signup-form" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="up-name" class="form-label">Full name</label>
                        <input type="text" id="up-name" class="form-control" autocomplete="name">
                        <div class="error-msg" id="up-name-error"></div>
                    </div>
                    <div class="col-sm-6">
                        <label for="up-email" class="form-label">Email address</label>
                        <input type="email" id="up-email" class="form-control" autocomplete="email">
                        <div class="error-msg" id="up-email-error"></div>
                    </div>
                    <div class="col-sm-6">
                        <label for="up-dob" class="form-label">Date of birth</label>
                        <input type="date" id="up-dob" class="form-control" autocomplete="bday" aria-describedby="dob-help">
                        <div id="dob-help" class="form-text">You need to be 13 or older to sign up.</div>
                        <div class="error-msg" id="up-dob-error"></div>
                    </div>
                    <div class="col-sm-6">
                        <label for="up-phone" class="form-label">Phone number <span class="text-muted">(optional)</span></label>
                        <input type="tel" id="up-phone" class="form-control" autocomplete="tel" placeholder="04xx xxx xxx">
                        <div class="error-msg" id="up-phone-error"></div>
                    </div>
                    <div class="col-sm-6">
                        <label for="up-password" class="form-label">Password</label>
                        <input type="password" id="up-password" class="form-control" autocomplete="new-password" aria-describedby="pw-help">
                        <div id="pw-help" class="form-text">At least 8 characters, including a number.</div>
                        <div class="error-msg" id="up-password-error"></div>
                    </div>
                    <div class="col-sm-6">
                        <label for="up-confirm" class="form-label">Confirm password</label>
                        <input type="password" id="up-confirm" class="form-control" autocomplete="new-password">
                        <div class="error-msg" id="up-confirm-error"></div>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="up-human">
                            <label class="form-check-label" for="up-human">I'm not a robot</label>
                        </div>
                        <div class="error-msg" id="up-human-error"></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-accent mt-3">Register</button>
                <p id="signup-success" class="success-msg mt-3" role="status" hidden></p>
            </form>
        </div>
    </section>
</div>

<p class="small text-muted mt-3">Demo note: accounts are remembered in this browser only. Passwords are checked
    for strength but never stored.</p>

<?php include 'includes/footer.php'; ?>
