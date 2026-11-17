// =========================================================
// tours.js: dependent dropdowns (year → tour → details)
// LOGIC RULE: dynamic content update from a JS data structure.
// =========================================================

// An ARRAY of OBJECTS: our "database" for tours (the brief only needs MySQL for the shop).
const tours = [
    {
        year: 1973, name: 'The Dark Side of the Moon Tour',
        cities: ['London', 'New York', 'Chicago', 'Montreal'],
        setlist: ['Breathe', 'Time', 'Money', 'Us and Them', 'Eclipse'],
        attendance: 15000, price: '£2'
    },
    {
        year: 1975, name: 'Wish You Were Here Tour',
        cities: ['Vancouver', 'Los Angeles', 'Pittsburgh', 'Knebworth'],
        setlist: ['Shine On You Crazy Diamond', 'Have a Cigar', 'Wish You Were Here', 'Echoes'],
        attendance: 40000, price: '$7'
    },
    {
        year: 1977, name: 'In the Flesh Tour (Animals)',
        cities: ['Dortmund', 'London', 'Chicago', 'Montreal'],
        setlist: ['Sheep', 'Pigs on the Wing', 'Dogs', 'Pigs (Three Different Ones)', 'Wish You Were Here'],
        attendance: 50000, price: '$10'
    },
    {
        year: 1980, name: 'The Wall Tour',
        cities: ['Los Angeles', 'New York', 'London', 'Dortmund'],
        setlist: ['In the Flesh?', 'Another Brick in the Wall, Part 2', 'Hey You', 'Comfortably Numb', 'Run Like Hell'],
        attendance: 15000, price: '$15'
    },
    {
        year: 1987, name: 'A Momentary Lapse of Reason Tour (North America)',
        cities: ['Ottawa', 'New York', 'Los Angeles', 'Toronto'],
        setlist: ['Learning to Fly', 'Sorrow', 'Time', 'Money', 'Comfortably Numb'],
        attendance: 55000, price: '$20'
    },
    {
        year: 1988, name: 'A Momentary Lapse of Reason Tour (World)',
        cities: ['Sydney', 'Melbourne', 'Tokyo', 'Versailles'],
        setlist: ['Shine On You Crazy Diamond', 'Learning to Fly', 'One Slip', 'Run Like Hell'],
        attendance: 45000, price: 'A$35'
    },
    {
        year: 1988, name: 'Delicate Sound of Thunder recordings',
        cities: ['Long Island (Nassau Coliseum)'],
        setlist: ['Signs of Life', 'Learning to Fly', 'Sorrow', 'Comfortably Numb'],
        attendance: 17000, price: '$25'
    },
    {
        year: 1994, name: 'The Division Bell Tour',
        cities: ['Miami', 'Toronto', 'Rome', 'London (Earls Court)'],
        setlist: ['Astronomy Domine', 'High Hopes', 'Coming Back to Life', 'Wish You Were Here', 'Comfortably Numb'],
        attendance: 60000, price: '$45'
    }
];

const yearSelect = document.getElementById('tour-year');
const tourSelect = document.getElementById('tour-name');
const details = document.getElementById('tour-details');

// Fill the year dropdown with each year once (no duplicates even though 1988 has two tours)
const years = [];
for (let i = 0; i < tours.length; i++) {
    if (!years.includes(tours[i].year)) {
        years.push(tours[i].year);
    }
}
years.forEach(function (year) {
    yearSelect.add(new Option(year, year));
});

// Helper: empty a list and refill it from an array
function fillList(listElement, items) {
    listElement.innerHTML = '';
    items.forEach(function (item) {
        const li = document.createElement('li');
        li.textContent = item;
        listElement.appendChild(li);
    });
}

// EVENT: change on the year dropdown
yearSelect.addEventListener('change', function () {
    details.hidden = true;
    tourSelect.innerHTML = '';

    if (yearSelect.value === '') {
        tourSelect.add(new Option('Choose a year first', ''));
        tourSelect.disabled = true;
        return;
    }

    // Keep only the tours from the chosen year
    const matches = tours.filter(function (tour) {
        return tour.year === Number(yearSelect.value);
    });

    tourSelect.add(new Option('Choose a tour…', ''));
    matches.forEach(function (tour) {
        tourSelect.add(new Option(tour.name, tour.name));
    });
    tourSelect.disabled = false;

    // Only one tour that year? Pick it automatically to save a click.
    if (matches.length === 1) {
        tourSelect.value = matches[0].name;
        showTour(matches[0]);
    }
});

// EVENT: change on the tour dropdown
tourSelect.addEventListener('change', function () {
    const tour = tours.find(function (t) { return t.name === tourSelect.value; });
    if (tour) {
        showTour(tour);
    } else {
        details.hidden = true;
    }
});

function showTour(tour) {
    document.getElementById('detail-name').textContent = tour.name + ' (' + tour.year + ')';
    fillList(document.getElementById('detail-cities'), tour.cities);
    fillList(document.getElementById('detail-setlist'), tour.setlist);
    document.getElementById('detail-attendance').textContent = '~' + tour.attendance.toLocaleString() + ' per show';
    document.getElementById('detail-price').textContent = tour.price;
    details.hidden = false;
}
