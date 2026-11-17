<?php
$pageTitle = 'Albums';
$currentPage = 'albums';
$pageScript = 'albums.js';
include 'includes/header.php';

// Tracklists live in a PHP array so we can loop over them instead of
// hand-writing four almost identical tables.
$albums = [
    'dsotm' => [
        'title' => 'The Dark Side of the Moon', 'year' => 1973, 'image' => 'dark-side-prism.jpg',
        'alt' => 'The Dark Side of the Moon cover: white light entering a prism and leaving as a rainbow',
        'note' => 'Full album',
        'tracks' => [['Speak to Me', '1:08'], ['Breathe', '2:49'], ['On the Run', '3:45'], ['Time', '6:53'],
                     ['The Great Gig in the Sky', '4:44'], ['Money', '6:23'], ['Us and Them', '7:49'],
                     ['Any Colour You Like', '3:26'], ['Brain Damage', '3:46'], ['Eclipse', '2:12']],
    ],
    'pompeii' => [
        'title' => 'Live at Pompeii', 'year' => 1972, 'image' => 'live-at-pompeii.jpg',
        'alt' => 'Live at Pompeii poster: a silhouetted drummer striking a giant gong against an orange sky',
        'note' => 'Concert film setlist',
        'tracks' => [['Echoes, Part 1', '—'], ['Careful with That Axe, Eugene', '—'], ['A Saucerful of Secrets', '—'],
                     ['One of These Days', '—'], ['Set the Controls for the Heart of the Sun', '—'], ['Echoes, Part 2', '—']],
    ],
    'wall' => [
        'title' => 'The Wall', 'year' => 1979, 'image' => 'the-wall.png',
        'alt' => 'The Wall cover: white bricks with the band name and title hand-written in red',
        'note' => 'Side one',
        'tracks' => [['In the Flesh?', '3:16'], ['The Thin Ice', '2:27'], ['Another Brick in the Wall, Part 1', '3:21'],
                     ['The Happiest Days of Our Lives', '1:46'], ['Another Brick in the Wall, Part 2', '3:59'], ['Mother', '5:32']],
    ],
    'echoes' => [
        'title' => 'Echoes: The Best of Pink Floyd', 'year' => 2001, 'image' => 'echoes.jpg',
        'alt' => 'Echoes cover: a surreal room of windows within windows opening onto a river',
        'note' => 'Disc one, first five tracks',
        'tracks' => [['Astronomy Domine', '4:10'], ['See Emily Play', '2:50'], ['The Happiest Days of Our Lives', '1:46'],
                     ['Another Brick in the Wall, Part 2', '4:00'], ['Echoes', '16:30']],
    ],
];
?>

<h1>Albums</h1>
<p class="lead">Select a cover to see its tracklist. Full discography and official releases are on
    <a href="https://www.pinkfloyd.com/music/" target="_blank" rel="noopener">pinkfloyd.com (opens in a new tab)</a>.</p>

<div class="row g-4">
    <!-- Album covers: each one is a real <button> so it works with Tab + Enter -->
    <section class="col-lg-7" aria-labelledby="covers-heading">
        <div class="panel">
            <h2 id="covers-heading" class="h4">Album cover selection</h2>
            <div class="row g-3">
                <?php foreach ($albums as $id => $album): ?>
                    <div class="col-6">
                        <button type="button" class="album-cover" data-album="<?php echo $id; ?>"
                                aria-expanded="false" aria-controls="tracks-<?php echo $id; ?>">
                            <img src="images/<?php echo $album['image']; ?>" alt="<?php echo htmlspecialchars($album['alt']); ?>">
                        </button>
                        <p class="small text-center mt-1 mb-0"><?php echo $album['title']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Page 2 requirement: an ordered list (chronological discography highlights) -->
    <section class="col-lg-5" aria-labelledby="timeline-heading">
        <div class="panel h-100">
            <h2 id="timeline-heading" class="h4">Albums in chronological order</h2>
            <ol>
                <li>The Piper at the Gates of Dawn (1967)</li>
                <li>Meddle (1971)</li>
                <li><a href="#tracks-pompeii" data-album="pompeii" class="album-link">Live at Pompeii (1972, film)</a></li>
                <li><a href="#tracks-dsotm" data-album="dsotm" class="album-link">The Dark Side of the Moon (1973)</a></li>
                <li>Wish You Were Here (1975)</li>
                <li>Animals (1977)</li>
                <li><a href="#tracks-wall" data-album="wall" class="album-link">The Wall (1979)</a></li>
                <li>The Division Bell (1994)</li>
                <li><a href="#tracks-echoes" data-album="echoes" class="album-link">Echoes: The Best of Pink Floyd (2001)</a></li>
            </ol>
            <p class="small text-muted mb-0">Linked titles open their tracklist below.</p>
        </div>
    </section>
</div>

<!-- Page 2 requirement: table with at least 4 rows. One per album, hidden until chosen (js/albums.js). -->
<section class="mt-4" aria-live="polite">
    <p id="tracks-hint" class="text-muted">No album selected yet.</p>
    <?php foreach ($albums as $id => $album): ?>
        <div id="tracks-<?php echo $id; ?>" class="panel tracklist" hidden>
            <h2 class="h4"><?php echo $album['title']; ?> (<?php echo $album['year']; ?>)</h2>
            <table class="table table-striped mb-0">
                <caption class="text-muted"><?php echo $album['note']; ?></caption>
                <thead><tr><th scope="col">#</th><th scope="col">Track</th><th scope="col">Length</th></tr></thead>
                <tbody>
                <?php for ($i = 0; $i < count($album['tracks']); $i++): ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $album['tracks'][$i][0]; ?></td>
                        <td><?php echo $album['tracks'][$i][1]; ?></td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</section>

<?php include 'includes/footer.php'; ?>
