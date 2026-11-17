<?php
$pageTitle = 'Home';
$currentPage = 'index';
include 'includes/header.php';
?>

<h1 class="visually-hidden">Pink Floyd Archives home</h1>

<!-- Page 1 requirement: image carousel (Bootstrap) -->
<div id="homeCarousel" class="carousel slide mb-4" data-bs-ride="carousel" aria-label="Featured album art">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
    </div>
    <div class="carousel-inner rounded-3">
        <div class="carousel-item active">
            <img src="images/dark-side-prism.jpg" class="d-block w-100"
                 alt="The Dark Side of the Moon cover: a beam of white light passing through a glass prism and splitting into a rainbow">
            <div class="carousel-caption"><h2 class="h5">The Dark Side of the Moon (1973)</h2></div>
        </div>
        <div class="carousel-item">
            <img src="images/the-wall.png" class="d-block w-100"
                 alt="The Wall cover: a plain white brick wall with the words Pink Floyd The Wall hand-written in red">
            <div class="carousel-caption"><h2 class="h5">The Wall (1979)</h2></div>
        </div>
        <div class="carousel-item">
            <img src="images/live-at-pompeii.jpg" class="d-block w-100"
                 alt="Silhouette of a drummer striking a large gong against a glowing orange background, from Live at Pompeii">
            <div class="carousel-caption"><h2 class="h5">Live at Pompeii (1972)</h2></div>
        </div>
        <div class="carousel-item">
            <img src="images/echoes.jpg" class="d-block w-100"
                 alt="Echoes compilation cover: a surreal scene of windows within windows looking out onto a river">
            <div class="carousel-caption"><h2 class="h5">Echoes: The Best of Pink Floyd (2001)</h2></div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous slide</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next slide</span>
    </button>
</div>

<div class="row g-4">
    <!-- Page 1 requirement: short introduction to the brand -->
    <section class="col-lg-6" aria-labelledby="intro-heading">
        <div class="panel h-100">
            <h2 id="intro-heading">Welcome to the archive</h2>
            <p><strong>Pink Floyd</strong> formed in London in 1965 and pushed rock music into long, atmospheric,
                experimental territory. Their albums play as complete journeys rather than collections of singles,
                and they remain one of the most influential bands in rock history.</p>
            <p>Pink Floyd Archives is a fan-made space for listeners old and new: browse the
                <a href="albums.php">albums</a>, look up <a href="tours.php">past tours</a>, share your favourite
                track on the <a href="fanwall.php">fan wall</a>, or pick up something from the
                <a href="shop.php">merch shop</a>.</p>
            <p class="mb-0">
                <span class="tag">15 studio albums</span>
                <span class="tag">250M+ records sold</span>
                <span class="tag">Rock and Roll Hall of Fame, 1996</span>
            </p>
        </div>
    </section>

    <!-- Page 1 requirement: at least one relevant video -->
    <section class="col-lg-6" aria-labelledby="video-heading">
        <div class="panel h-100">
            <h2 id="video-heading">Watch</h2>
            <div class="ratio ratio-16x9">
                <iframe src="https://www.youtube-nocookie.com/embed/k9ynZnEBtvw"
                        title="Pink Floyd music video (YouTube)"
                        allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <p class="note mt-3 mb-0">New to the band? <em>The Dark Side of the Moon</em> is the classic starting
                point: play it start to finish, ideally with headphones. Then explore the
                <a href="albums.php#tracks-dsotm">full tracklist</a>.</p>
        </div>
    </section>
</div>

<section class="mt-4" aria-labelledby="members-heading">
    <h2 id="members-heading">The members</h2>
    <div class="row g-3">
        <div class="col-sm-6 col-lg">
            <div class="card member-card h-100"><div class="card-body">
                <h3 class="h5">Syd Barrett</h3>
                <p class="card-text small mb-0">Founding guitarist, singer and songwriter (1965–1968).</p>
            </div></div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="card member-card h-100"><div class="card-body">
                <h3 class="h5">Roger Waters</h3>
                <p class="card-text small mb-0">Bass, vocals, and the main lyricist of the 1970s albums.</p>
            </div></div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="card member-card h-100"><div class="card-body">
                <h3 class="h5">David Gilmour</h3>
                <p class="card-text small mb-0">Guitar and vocals from 1968, later led the band.</p>
            </div></div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="card member-card h-100"><div class="card-body">
                <h3 class="h5">Richard Wright</h3>
                <p class="card-text small mb-0">Keyboards and vocals, the band's atmospheric sound.</p>
            </div></div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="card member-card h-100"><div class="card-body">
                <h3 class="h5">Nick Mason</h3>
                <p class="card-text small mb-0">Drummer, and the only member on every album.</p>
            </div></div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
