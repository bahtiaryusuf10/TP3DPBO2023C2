<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Stadium.php');
include('classes/Template.php');

// membuat objek stadium
$stadium = new Stadium($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$stadium->open();
$stadium->getStadium();

$mainTitle = 'Stadium'; // judul

// cari stadium
if (isset($_POST['search-in-table'])) {
    // methode mencari data stadium
    $stadium->searchStadium($_POST['search-' . $mainTitle]);
} else {
    // method menampilkan data stadium
    $stadium->getStadium();
}

// menangkap data yang akna ditambahkan
if (isset($_POST['btn-create-stadium'])) {
    // menyimpan data yang ditambahkan ke database
    if ($stadium->addStadium($_POST, $_FILES) > 0) {
        // jika berhasil
        echo "<script>
                alert('Data added successfully!');
                document.location.href = 'stadium.php';
            </script>";
    } else {
        // jika gagal
        echo "<script>
                alert('Failed to add data!');
                document.location.href = 'stadium.php';
            </script>";
    }
}

// membuat objek template
$view = new Template('templates/skintabel.html');

// membuat tabel stadium list
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Photo</th>
<th scope="row">Stadium Name</th>
<th scope="row">Location</th>
<th scope="row">Action</th>
</tr>';

$data = null;
$no = 1;
$formLabel = 'stadium';

while ($stadiumData = $stadium->getResult()) {
    // menampilkan setiap data stadium
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td><img src="assets/images/stadiums/' . $stadiumData['photo'] . '" class="card-img-top" alt="' . $stadiumData['photo'] . '"style="width: 350px; height: auto;"></td>
    <td>' . $stadiumData['name'] . '</td>
    <td>' . $stadiumData['location'] . '</td>
    <td style="font-size: 22px;">
        <a type="button" data-bs-toggle="modal" data-bs-target="#update-' . $mainTitle . '-' . $stadiumData['id'] . '"><i class="bi bi-pencil-square text-warning"></i></a>
        &nbsp;<a href="stadium.php?delete=' . $stadiumData['id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';

    // form berbentuk modal untuk memperbarui data stadium
    $data .= '<div class="modal fade" id="update-' . $mainTitle . '-' . $stadiumData['id'] . '" tabindex="-1" aria-labelledby="update-' . $mainTitle . '-' . $stadiumData['id'] . '-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="update-' . $mainTitle . '-' . $stadiumData['id'] . '-label">Update ' . $mainTitle . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="stadium.php?id=' . $stadiumData['id'] . '" method="POST" id="form-update' . $stadiumData['id'] . '" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="' . $stadiumData['name'] . '" placeholder="Enter Stadium Name" required />
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" value="' . $stadiumData['location'] . '" placeholder="Enter Location" required />
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <div class="input-group">
                            <input class="form-control" type="file" id="photo" name="photo" />
                        </div>
                    </div>
                </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn" style="background-color: #a9dbcf; color: #2e4f4f" name="btn-update-stadium" id="btn-update-stadium" form="form-update' . $stadiumData['id'] . '">Update Stadium</button>
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
if (isset($_POST['btn-update-stadium'])) {
    $id = $_GET['id']; // menangkap id stadium yang akan diperbarui
    // memperbarui data di database dengan data baru
    if ($stadium->updateStadium($id, $_POST, $_FILES) > 0) {
        // jika berhasil
        echo "<script>
                    alert('Data updated successfully!');
                    document.location.href = 'stadium.php';
                </script>";
    } else {
        // jika gagal
        echo "<script>
                alert('Failed to update data!');
                document.location.href = 'stadium.php';
            </script>";
    }
}

// menangkap data yang akan dihapus
if (isset($_GET['delete'])) {
    $id = $_GET['delete']; // menangkap id stadium yang akan dihapus
    if ($id > 0) {
        // menghapus data dari database
        if ($stadium->deleteStadium($id) > 0) {
            // jika berhasil
            echo "<script>
                alert('Data deleted successfully!');
                document.location.href = 'stadium.php';
            </script>";
        } else {
            // jika gagal
            echo "<script>
                alert('Failed to delete data!');
                document.location.href = 'stadium.php';
            </script>";
        }
    }
}

// menutup koneksi database
$stadium->close();

// mengisi template dengan data yang sudah diproses
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('SET_COLOR_1', 'white');
$view->replace('SET_COLOR_2', '#a9dbcf');
$view->replace('SET_COLOR_3', 'white');
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->replace('SET_FOOTER', $footer);

// menampilkan template
$view->write();
