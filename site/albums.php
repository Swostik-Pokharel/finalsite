<?php
$pageTitle = 'Albums';
$currentPage = 'albums';
$pageScript = 'albums.js';
include 'includes/header.php';

// Every album lives in this one PHP array, in chronological order.
// The ordered list, the cover grid and the tracklist tables are all built
// by looping over it, so adding an album means adding one entry here.
// 'image' => null means we have no cover picture, so it's not in the grid.
$albums = [
    'piper' => [
        'title' => 'The Piper at the Gates of Dawn', 'year' => 1967, 'image' => null, 'note' => 'UK release',
        'tracks' => [['Astronomy Domine', '4:12'], ['Lucifer Sam', '3:07'], ['Matilda Mother', '3:08'], ['Flaming', '2:46'],
                     ['Pow R. Toc H.', '4:26'], ['Take Up Thy Stethoscope and Walk', '3:05'], ['Interstellar Overdrive', '9:41'],
                     ['The Gnome', '2:13'], ['Chapter 24', '3:42'], ['The Scarecrow', '2:11'], ['Bike', '3:21']],
    ],
    'meddle' => [
        'title' => 'Meddle', 'year' => 1971, 'image' => null, 'note' => 'Full album',
        'tracks' => [['One of These Days', '5:57'], ['A Pillow of Winds', '5:10'], ['Fearless', '6:08'],
                     ['San Tropez', '3:43'], ['Seamus', '2:15'], ['Echoes', '23:31']],
    ],
    'pompeii' => [
        'title' => 'Live at Pompeii (film)', 'year' => 1972, 'image' => 'live-at-pompeii.jpg',
        'alt' => 'Live at Pompeii poster: a silhouetted drummer striking a giant gong against an orange sky',
        'note' => 'Concert film setlist',
        'tracks' => [['Echoes, Part 1', '—'], ['Careful with That Axe, Eugene', '—'], ['A Saucerful of Secrets', '—'],
                     ['One of These Days', '—'], ['Set the Controls for the Heart of the Sun', '—'], ['Echoes, Part 2', '—']],
    ],
    'dsotm' => [
        'title' => 'The Dark Side of the Moon', 'year' => 1973, 'image' => 'dark-side-prism.jpg',
        'alt' => 'The Dark Side of the Moon cover: white light entering a prism and leaving as a rainbow',
        'note' => 'Full album',
        'tracks' => [['Speak to Me', '1:08'], ['Breathe', '2:49'], ['On the Run', '3:45'], ['Time', '6:53'],
                     ['The Great Gig in the Sky', '4:44'], ['Money', '6:23'], ['Us and Them', '7:49'],
                     ['Any Colour You Like', '3:26'], ['Brain Damage', '3:46'], ['Eclipse', '2:12']],
    ],
    'wywh' => [
        'title' => 'Wish You Were Here', 'year' => 1975, 'image' => null, 'note' => 'Full album',
        'tracks' => [['Shine On You Crazy Diamond (Parts I–V)', '13:38'], ['Welcome to the Machine', '7:30'],
                     ['Have a Cigar', '5:08'], ['Wish You Were Here', '5:34'], ['Shine On You Crazy Diamond (Parts VI–IX)', '12:31']],
    ],
    'animals' => [
        'title' => 'Animals', 'year' => 1977, 'image' => null, 'note' => 'Full album',
        'tracks' => [['Pigs on the Wing (Part One)', '1:25'], ['Dogs', '17:04'], ['Pigs (Three Different Ones)', '11:25'],
                     ['Sheep', '10:20'], ['Pigs on the Wing (Part Two)', '1:23']],
    ],
    'wall' => [
        'title' => 'The Wall', 'year' => 1979, 'image' => 'the-wall.png',
        'alt' => 'The Wall cover: white bricks with the band name and title hand-written in red',
        'note' => 'Side one',
        'tracks' => [['In the Flesh?', '3:16'], ['The Thin Ice', '2:27'], ['Another Brick in the Wall, Part 1', '3:21'],
                     ['The Happiest Days of Our Lives', '1:46'], ['Another Brick in the Wall, Part 2', '3:59'], ['Mother', '5:32']],
    ],
    'division' => [
        'title' => 'The Division Bell', 'year' => 1994, 'image' => null, 'note' => 'Full album',
        'tracks' => [['Cluster One', '5:58'], ['What Do You Want from Me', '4:21'], ['Poles Apart', '7:04'], ['Marooned', '5:29'],
                     ['A Great Day for Freedom', '4:17'], ['Wearing the Inside Out', '6:49'], ['Take It Back', '6:12'],
                     ['Coming Back to Life', '6:19'], ['Keep Talking', '6:11'], ['Lost for Words', '5:14'], ['High Hopes', '8:32']],
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
<p>Select a cover or a title to see its tracklist. The full discography and official releases are on
    <a href="https://www.pinkfloyd.com/music/" target="_blank" rel="noopener">pinkfloyd.com (opens in a new tab)</a>.</p>

<div class="row g-4">
    <!-- Album covers: each one is a real <button> so it works with Tab + Enter -->
    <section class="col-lg-7" aria-labelledby="covers-heading">
        <h2 id="covers-heading">Album covers</h2>
        <div class="row g-3">
            <?php foreach ($albums as $id => $album): ?>
                <?php if ($album['image'] === null) { continue; } // no picture, so skip it in the grid ?>
                <div class="col-6">
                    <button type="button" class="album-cover" data-album="<?php echo $id; ?>"
                            aria-expanded="false" aria-controls="tracks-<?php echo $id; ?>">
                        <img src="images/<?php echo $album['image']; ?>" alt="<?php echo htmlspecialchars($album['alt']); ?>">
                    </button>
                    <p class="small text-center mt-1 mb-0"><?php echo $album['title']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Page 2 requirement: an ordered list. Every title opens its tracklist. -->
    <section class="col-lg-5" aria-labelledby="timeline-heading">
        <h2 id="timeline-heading">In chronological order</h2>
        <ol>
            <?php foreach ($albums as $id => $album): ?>
                <li><a href="#tracks-<?php echo $id; ?>" data-album="<?php echo $id; ?>" class="album-link">
                    <?php echo $album['title']; ?> (<?php echo $album['year']; ?>)</a></li>
            <?php endforeach; ?>
        </ol>
    </section>
</div>

<!-- Page 2 requirement: table with at least 4 rows. One per album, hidden until chosen (js/albums.js). -->
<section class="mt-2" aria-live="polite">
    <p id="tracks-hint" class="note">No album selected yet.</p>
    <?php foreach ($albums as $id => $album): ?>
        <div id="tracks-<?php echo $id; ?>" class="tracklist" hidden>
            <h2><?php echo $album['title']; ?> (<?php echo $album['year']; ?>)</h2>
            <div class="table-responsive">
                <table class="table mb-0">
                    <caption><?php echo $album['note']; ?></caption>
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
        </div>
    <?php endforeach; ?>
</section>

<?php include 'includes/footer.php'; ?>
