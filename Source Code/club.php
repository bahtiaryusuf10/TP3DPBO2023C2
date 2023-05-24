<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Club.php');
include('classes/Stadium.php');
include('classes/Template.php');

// membuat objek club
$club = new Club($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$club->open();
$club->getClub();

// membuat objek stadium
$stadium = new Stadium($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$stadium->open();
$stadium->getStadium();

// membuat array stadium
$arrayStadium = [];
while ($stadiums = $stadium->getResult()) {
    $arrayStadium[] = $stadiums;
}

$mainTitle = 'Club'; // judul

// cari club
if (isset($_POST['search-in-table'])) {
    // methode mencari data club
    $club->searchClub($_POST['search-' . $mainTitle]);
} else {
    // method menampilkan data club
    $club->getClubJoin();
}

// menangkap data yang akan ditambahkan
if (isset($_POST['btn-create-club'])) {
    // menyimpan data yang ditambahkan ke database
    if ($club->addClub($_POST, $_FILES) > 0) {
        // jika berhasil
        echo "<script>
                alert('Data added successfully!');
                document.location.href = 'club.php';
            </script>";
    } else {
        // jika gagal
        echo "<script>
                 alert('Failed to add data!');
                document.location.href = 'club.php';
            </script>";
    }
}

// membuat objek template
$view = new Template('templates/skintabel.html');

// membuat tabel club list
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Logo</th>
<th scope="row">Club Name</th>
<th scope="row">Stadium</th>
<th scope="row">Coach</th>
<th scope="row">Action</th>
</tr>';

$data = null;
$no = 1;
$formLabel = 'club';

while ($clubData = $club->getResult()) {
    // menampilkan setiap data match
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td><img src="assets/images/logos/' . $clubData['logo'] . '" class="card-img-top" alt="' . $clubData['logo'] . '"></td>
    <td>' . $clubData['name'] . '</td>
    <td>' . $clubData['stadium'] . '</td>
    <td>' . $clubData['coach'] . '</td>
    <td style="font-size: 22px;">
        <a type="button" data-bs-toggle="modal" data-bs-target="#update-' . $mainTitle . '-' . $clubData['id'] . '"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="club.php?delete=' . $clubData['id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
    </td>
    </tr>';

    // variabel untuk menampung data stadium
    $dataStadium = null;
    $selectedOptions = [];

    // menampilkan data stadium
    foreach ($arrayStadium as $stadiumData) {
        if (!in_array($stadiumData['name'], $selectedOptions)) {
            $selectedOptions[] = $stadiumData['name'];
            $selectedStadium = ($stadiumData['name'] == $clubData['stadium']) ? "selected" : null;
            $dataStadium .= '<option value="' . $stadiumData['id'] . '" ' . $selectedStadium . '>' . $stadiumData['name'] . '</option>';
        }
    }

    // form berbentuk modal untuk memperbarui data club
    $data .= '<div class="modal fade" id="update-' . $mainTitle . '-' . $clubData['id'] . '" tabindex="-1" aria-labelledby="update-' . $mainTitle . '-' . $clubData['id'] . '-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="update-' . $mainTitle . '-' . $clubData['id'] . '-label">Update ' . $mainTitle . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="club.php?id=' . $clubData['id'] . '" method="POST" id="form-update' . $clubData['id'] . '" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="' . $clubData['name'] . '" placeholder="Enter Club Name" required />
                    </div>
                    <div class="mb-3">
                        <label for="stadium">Home Club</label>
                        <select class="form-select" aria-label="Stadium" id="stadium" name="stadium" required>
                        ' . $dataStadium . '
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <div class="input-group">
                            <input class="form-control" type="file" id="logo" name="logo" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="coach" class="form-label">Coach</label>
                        <input type="text" class="form-control" id="coach" name="coach" value="' . $clubData['coach'] . '" placeholder="Enter Coach" required />
                    </div>
                </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn" style="background-color: #a9dbcf; color: #2e4f4f" name="btn-update-club" id="btn-update-club" form="form-update' . $clubData['id'] . '">Update Club</button>
                </div>
            </div>
        </div>
    </div>';

    $no++;
}

// pengaturan footer agar tetap di bawah walaupun datanya sedikit
$footer = null;

if ($no > 5) {
    $footer .= '
    <script>
      window.addEventListener("DOMContentLoaded", function () {
        document.getElementById("footer").classList.add("non-fixed");
      });
    </script>
    ';
}

// menangkap data yang akan diperbarui
if (isset($_POST['btn-update-club'])) {
    $id = $_GET['id']; // menangkap id club yang akan diperbarui
    // memperbarui data di database dengan data baru
    if ($club->updateClub($id, $_POST, $_FILES) > 0) {
        // jika berhasil
        echo "<script>
                alert('Data updated successfully!');
                document.location.href = 'club.php';
            </script>";
    } else {
        // jika gagal
        echo "<script>
                alert('Failed to update data!');
                document.location.href = 'club.php';
            </script>";
    }
}

// menangkap data yang akan dihapus
if (isset($_GET['delete'])) {
    $id = $_GET['delete']; // menangkap id club yang akan dihapus
    if ($id > 0) {
        // menghapus data di database
        if ($club->deleteClub($id) > 0) {
            // jika berhasil
            echo "<script>
                alert('Data deleted successfully!');
                document.location.href = 'club.php';
            </script>";
        } else {
            // jika gagal
            echo "<script>
                alert('Failed to delete data!');
                document.location.href = 'club.php';
            </script>";
        }
    }
}

// menutup koneksi database
$club->close();
$stadium->close();

// mengisi template dengan data yang sudah diproses
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('SET_COLOR_1', '#a9dbcf');
$view->replace('SET_COLOR_2', 'white');
$view->replace('SET_COLOR_3', 'white');
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->replace('SET_FOOTER', $footer);

// menampilkan template
$view->write();
