<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Matches.php');
include('classes/Club.php');
include('classes/Template.php');

// membuat objek match
$matches = new Matches($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$matches->open();
$matches->getMatches();

// membuat objek club
$club = new Club($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$club->open();
$club->getClub();

// membuat array club
$arrayClub = [];
while ($clubs = $club->getResult()) {
    $arrayClub[] = $clubs;
}

$mainTitle = 'Match'; // judul

// cari match
if (isset($_POST['search-in-table'])) {
    // methode mencari data match
    $matches->searchMatches($_POST['search-' . $mainTitle]);
} else {
    // method menampilkan data match
    $matches->getMatchesJoin();
}

// menangkap data yang akan ditambahkan
if (isset($_POST['btn-create-match'])) {
    // menyimpan data home dan away club
    $homeClub = $_POST['home_club'];
    $awayClub = $_POST['away_club'];

    // *aturan untuk match adalah club tidak boleh 
    // jika home club dan away club sama, maka tidak akan ditambahkan
    if ($homeClub == $awayClub) {
        // jika sama
        echo "<script>
                alert('You cannot choose the same club!');
                document.location.href = 'match.php';
            </script>";
    } else {
        // jika tidak sama
        // menyimpan data yang ditambahkan ke database
        if ($matches->addMatches($_POST) > 0) {
            // jika berhasil
            echo "<script>
                    alert('Data added successfully!');
                    document.location.href = 'match.php';
                </script>";
        } else {
            // jika gagal
            echo "<script>
                    alert('Failed to add data!');
                    document.location.href = 'match.php';
                </script>";
        }
    }
}

// membuat objek template
$view = new Template('templates/skintabel.html');

// membuat tabel match list
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Stadium</th>
<th scope="row">Match</th>
<th scope="row">Date</th>
<th scope="row">Action</th>
</tr>';

$data = null;
$no = 1;
$formLabel = 'matches';

while ($matchData = $matches->getResult()) {
    // menampilkan setiap data match
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td style="text-align: center;">
    <img src="assets/images/stadiums/' . $matchData['photo'] . '" class="card-img-top" alt="' . $matchData['photo'] . '"style="width: 350px; height: auto;">
    </td>
    <td>' . $matchData['home_club'] . ' vs ' . $matchData['away_club'] . '</td>
    <td>' . date('d-m-Y', strtotime($matchData['date'])) . '</td>
    <td style="font-size: 22px;">
        <a type="button" data-bs-toggle="modal" data-bs-target="#update-' . $mainTitle . '-' . $matchData['id'] . '"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="match.php?delete=' . $matchData['id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
    </td>
    </tr>';

    // variabel untuk menampung data club
    $dataClub1 = null;
    $dataClub2 = null;
    $selectedOptions = [];

    // menampilkan data club
    foreach ($arrayClub as $clubData) {
        if (!in_array($clubData['name'], $selectedOptions)) {
            $selectedOptions[] = $clubData['name'];
            $selectedHomeClub = ($clubData['name'] == $matchData['home_club']) ? "selected" : null;
            $selectedAwayClub = ($clubData['name'] == $matchData['away_club']) ? "selected" : null;
            $dataClub1 .= '<option value="' . $clubData['id'] . '" ' . $selectedHomeClub . '>' . $clubData['name'] . '</option>';
            $dataClub2 .= '<option value="' . $clubData['id'] . '" ' . $selectedAwayClub . '>' . $clubData['name'] . '</option>';
        }
    }

    // form berbentuk modal untuk memperbarui data match
    $data .= '<div class="modal fade" id="update-' . $mainTitle . '-' . $matchData['id'] . '" tabindex="-1" aria-labelledby="update-' . $mainTitle . '-' . $matchData['id'] . '-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="update-' . $mainTitle . '-' . $matchData['id'] . '-label">Update ' . $mainTitle . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="match.php?id=' . $matchData['id'] . '" method="POST" id="form-update' . $matchData['id'] . '" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="home_club">Home Club</label>
                        <select class="form-select" aria-label="Home_club" id="home_club" name="home_club" required>
                        ' . $dataClub1 . '
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="away_club">Away Club</label>
                        <select class="form-select" aria-label="Away_club" id="away_club" name="away_club" required>
                        ' . $dataClub2 . '
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date" value="' . $matchData['date'] . '" required />
                    </div>
                </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn" style="background-color: #a9dbcf; color: #2e4f4f" name="btn-update-match" id="btn-update-match" form="form-update' . $matchData['id'] . '">Update Match</button>
                </div>
            </div>
        </div>
    </div>';

    $no++;
}

// pengaturan footer agar tetap di bawah walaupun datanya sedikit
$footer = null;

if ($no > 3) {
    $footer .= '
    <script>
      window.addEventListener("DOMContentLoaded", function () {
        document.getElementById("footer").classList.add("non-fixed");
      });
    </script>
    ';
}

// menangkap data yang akan diupdate
if (isset($_POST['btn-update-match'])) {
    $id = $_GET['id']; // menangkap id match yang akan diupdate
    // memperbarui data di database dengan data baru
    if ($matches->updateMatches($id, $_POST) > 0) {
        // jika berhasil
        echo "<script>
                alert('Data updated successfully!');
                document.location.href = 'match.php';
            </script>";
    } else {
        // jika gagal
        echo "<script>
                alert('Failed to update data!');
                document.location.href = 'match.php';
            </script>";
    }
}

// menangkap data yang akan dihapus
if (isset($_GET['delete'])) {
    $id = $_GET['delete']; // menangkap id match yang akan dihapus
    if ($id > 0) {
        // menghapus data dari database
        if ($matches->deleteMatches($id) > 0) {
            // jika berhasil
            echo "<script>
                alert('Data deleted successfully!');
                document.location.href = 'match.php';
            </script>";
        } else {
            // jika gagal
            echo "<script>
                alert('Failed to delete data!');
                document.location.href = 'match.php';
            </script>";
        }
    }
}

// menutup koneksi database
$matches->close();
$club->close();

// mengisi template dengan data yang sudah diproses
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('SET_COLOR_2', 'white');
$view->replace('SET_COLOR_1', 'white');
$view->replace('SET_COLOR_3', '#a9dbcf');
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->replace('SET_FOOTER', $footer);

// menampilkan template
$view->write();
