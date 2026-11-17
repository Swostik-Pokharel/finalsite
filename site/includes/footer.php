</main>

<footer class="site-footer mt-5">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-4">
                <h2 class="h6">Contact us</h2>
                <ul class="list-unstyled small mb-0">
                    <li>Email: <a href="mailto:hello@pinkfloydarchives.example">hello@pinkfloydarchives.example</a></li>
                    <li>Phone: <a href="tel:+61400000000">+61 400 000 000</a></li>
                    <li><a href="about.php#contact">Feedback or complaint form</a></li>
                    <li>Official band links:
                        <a href="https://www.pinkfloyd.com" target="_blank" rel="noopener">pinkfloyd.com</a> ·
                        <a href="https://www.youtube.com/@pinkfloyd" target="_blank" rel="noopener">YouTube</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 text-md-center small">
                <p class="mb-2">Unofficial fan site. Not affiliated with Pink Floyd or their labels.
                    Album artwork belongs to its respective owners.</p>
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Pink Floyd Archives</p>
            </div>
            <div class="col-md-4">
                <h2 class="h6">Acknowledgement of Country</h2>
                <p class="small mb-0">We acknowledge the Traditional Owners of the land on which this website was
                    created and pay our respects to Elders past and present. We extend that respect to all
                    Aboriginal and Torres Strait Islander peoples who visit this site.</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
<?php
// A page can ask for its own script by setting $pageScript before including the footer.
if (isset($pageScript)) {
    echo '<script src="js/' . $pageScript . '"></script>' . "\n";
}
?>
</body>
</html>
