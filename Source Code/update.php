<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Player.php');
include('classes/Club.php');
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

$title = '';
$form = null;

// menangkap data yang akan diupdate
if (isset($_GET['id'])) {
    $id = $_GET['id']; // menangkap id yang akan diupdate
    if ($id > 0) { // jika id yang akan diupdate ada
        // ambil data player yang akan diupdate
        $player->getPlayerById($id);
        $data = $player->getResult();

        // variabel untuk menampung data position
        $dataPosition = null;
        $selectedOptionsPos = [];

        // menampilkan data position
        foreach ($arrayPosition as $positionData) {
            if (!in_array($positionData['name'], $selectedOptionsPos)) {
                $selectedOptionsPos[] = $positionData['name'];
                $selectedPosition = ($positionData['id'] == $data['position_id']) ? "selected" : null;
                $dataPosition .= '<option value="' . $positionData['id'] . '" ' . $selectedPosition . '>' . $positionData['name'] . '</option>';
            }
        }

        // variabel untuk menampung data club
        $dataClub = null;
        $selectedOptionsClub = [];

        // menampilkan data club
        foreach ($arrayClub as $clubData) {
            if (!in_array($clubData['name'], $selectedOptionsClub)) {
                $selectedOptionsClub[] = $clubData['name'];
                $selectedClub = ($clubData['id'] == $data['club_id']) ? "selected" : null;
                $dataClub .= '<option value="' . $clubData['id'] . '" ' . $selectedClub . '>' . $clubData['name'] . '</option>';
            }
        }

        // form update
        $form = '<div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="' . $data['name'] . '" required />
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input class="form-control" type="file" id="photo" name="photo"/>
        </div>
        <div class="mb-3">
            <label for="club">Club</label>
            <select class="form-select" aria-label="Club" id="club" name="club" required>
            ' . $dataClub . '
            </select>
        </div>
        <div class="mb-3">
            <label for="position">Position</label>
            <select class="form-select" aria-label="Position" id="position" name="position" required>
            ' . $dataPosition . '
            </select>
        </div>
        <div class="mb-3">
            <label for="jersey_number" class="form-label">Jersey Number</label>
            <input type="text" class="form-control" id="jersey_number" name="jersey_number" value="' . $data['jersey_number'] . '" required />
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" id="age" name="age" value="' . $data['age'] . '" required />
        </div>';

        $title = 'Player';
        $to_file = 'update.php?id=' . $data['id'] . '';

        $data_btn = 'btn-update-player';
    }
}

// menangkap data yang akan diupdate
if (isset($_POST['btn-update-player'])) {
    $id = $_GET['id']; // menangkap id yang akan diupdate
    // mengupdate data di database dengan data baru
    $player->getPlayerById($id);
    $data = $player->getResult();
    if ($player->updatePlayer($id, $_POST, $_FILES) > 0) {
        // jika update berhasil
        echo "<script>
            alert('Data updated successfully!');
            document.location.href = 'detail.php?id={$data['id']}';
        </script>";
    } else {
        // jika update gagal
        echo "<script>
            alert('Failed to update data!');
            document.location.href = 'detail.php?id={$data['id']}';
        </script>";
    }
}

// menutup koneksi database
$player->close();
$club->close();

// menampilkan halaman form update
$add = new Template('templates/skinform.html');

// mengisi template dengan data yang sudah diproses
$add->replace('TYPE', 'Update');
$add->replace('DATA_TITLE', $title);
$add->replace('TO_FILE', $to_file);
$add->replace('SET_FORM', $form);
$add->replace('DATA_BTN', $data_btn);
$add->replace('DATA_CLUB', $dataClub);

// menampilkan template
$add->write();
