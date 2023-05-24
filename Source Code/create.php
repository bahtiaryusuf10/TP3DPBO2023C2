<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Player.php');
include('classes/Club.php');
include('classes/Stadium.php');
include('classes/Matches.php');
include('classes/Template.php');

// membuat objek Player
$player = new Player($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$player->open();
$player->getPosition();

// membuat array position
$arrayPosition = [];
while ($position = $player->getResult()) {
    $arrayPosition[] = $position;
}

// membuat objek Club
$club = new Club($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$club->open();
$club->getClub();

// membuat array club
$arrayClub = [];
while ($clubs = $club->getResult()) {
    $arrayClub[] = $clubs;
}

// membuat objek Stadium
$stadium = new Stadium($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$stadium->open();
$stadium->getStadium();

// membuat array stadium
$arrayStadium = [];
while ($stadiums = $stadium->getResult()) {
    $arrayStadium[] = $stadiums;
}

$title = '';
$to_file = '';
$form = null;
$data_btn = '';

if (isset($_POST['add-Club'])) { // jika yang akan ditambahkan adalah club
    $title = 'Club';
    $to_file = 'club.php';

    // menampilkan form untuk menambah data club
    $form = '<div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Club Name" required />
            </div>
            <div class="mb-3">
                <label for="club">Stadium</label>
                <select class="form-select" aria-label="Stadium" id="stadium" name="stadium" required>
                DATA_STADIUM
                </select>
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input class="form-control" type="file" id="logo" name="logo" required />
            </div>
            <div class="mb-3">
                <label for="coach" class="form-label">Coach</label>
                <input type="text" class="form-control" id="coach" name="coach" placeholder="Enter Coach" required />
            </div>';

    $data_btn = 'btn-create-club';
} else if (isset($_POST['add-Stadium'])) { // jika yang akan ditambahkan adalah stadium
    $title = 'Stadium';
    $to_file = 'stadium.php';

    // menampilkan form untuk menambah data stadium
    $form = '<div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Stadium Name" required />
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" required />
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input class="form-control" type="file" id="photo" name="photo" required />
            </div>';

    $data_btn = 'btn-create-stadium';
} else if (isset($_POST['add-Match'])) { // jika yang akan ditambahkan adalah match
    $title = 'Match';
    $to_file = 'match.php';

    // menampilkan form untuk menambah data match
    $form = '<div class="mb-3">
                <label for="home_club">Home Club</label>
                <select class="form-select" aria-label="Home_club" id="home_club" name="home_club" required>
                DATA_CLUB
                </select>
            </div>
            <div class="mb-3">
                <label for="away_club">Away Club</label>
                <select class="form-select" aria-label="Away_club" id="away_club" name="away_club" required>
                DATA_CLUB
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date" required />
            </div>';

    $data_btn = 'btn-create-match';
} else if (isset($_POST['add-Player'])) { // jika yang akan ditambahkan adalah player
    $title = 'Player';
    $to_file = 'create.php';

    // menampilkan form untuk menambah data player
    $form = '<div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Player Name" required />
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input class="form-control" type="file" id="photo" name="photo" required />
            </div>
            <div class="mb-3">
                <label for="club">Club</label>
                <select class="form-select" aria-label="Club" id="club" name="club" required>
                DATA_CLUB
                </select>
            </div>
            <div class="mb-3">
                <label for="position">Position</label>
                <select class="form-select" aria-label="Position" id="position" name="position" required>
                DATA_POSITION
                </select>
            </div>
            <div class="mb-3">
                <label for="jersey_number" class="form-label">Jersey Number</label>
                <input type="text" class="form-control" id="jersey_number" name="jersey_number" placeholder="Enter Jersey Number" required />
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" placeholder="Enter Age" required />
            </div>';

    $data_btn = 'btn-create-player';
}

// menangkap data yang akan ditambahkan
if (isset($_POST['btn-create-player'])) {
    // menambahkan data ke database
    if ($player->addData($_POST, $_FILES) > 0) {
        // jika berhasil
        echo "<script>
            alert('Data added successfully!');
            document.location.href = 'index.php';
        </script>";
    } else {
        // jika gagal
        echo "<script>
            alert('Failed to add data!');
            document.location.href = 'index.php';
        </script>";
    }
}

$dataPosition = null;
$dataClub = null;
$dataStadium = null;

// menampilkan data position dengan bentuk dropdown
foreach ($arrayPosition as $positionData) {
    $dataPosition .= '<option value="' . $positionData['id'] . '">' . $positionData['name'] . '</option>';
}

// menampilkan data club dengan bentuk dropdown
foreach ($arrayClub as $clubData) {
    $dataClub .= '<option value="' . $clubData['id'] . '">' . $clubData['name'] . '</option>';
}

// menampilkan data stadium dengan bentuk dropdown
foreach ($arrayStadium as $stadiumData) {
    $dataStadium .= '<option value="' . $stadiumData['id'] . '">' . $stadiumData['name'] . '</option>';
}

// menutup koneksi database
$player->close();
$club->close();
$stadium->close();

// menampilkan halaman form create
$add = new Template('templates/skinform.html');

// mengisi template dengan data yang sudah diproses
$add->replace('TYPE', 'Add');
$add->replace('DATA_TITLE', $title);
$add->replace('TO_FILE', $to_file);
$add->replace('SET_FORM', $form);
$add->replace('DATA_BTN', $data_btn);
$add->replace('DATA_POSITION', $dataPosition);
$add->replace('DATA_CLUB', $dataClub);
$add->replace('DATA_STADIUM', $dataStadium);

// menampilkan template
$add->write();
