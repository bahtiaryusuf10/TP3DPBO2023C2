<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Club.php');
include('classes/Stadium.php');
include('classes/Player.php');
include('classes/Template.php');

$player = new Player($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$player->open();

$data = nulL;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $player->getPlayerById($id);
        $row = $player->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">' . $row['name'] . ' Details</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/players/' . $row['photo'] . '" class="img-thumbnail" alt="' . $row['photo'] . '"style="width: 241px; height: auto;">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Name</td>
                                    <td>:</td>
                                    <td>' . $row['name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Club</td>
                                    <td>:</td>
                                    <td>' . $row['club'] . '</td>
                                </tr>
                                <tr>
                                    <td>Position</td>
                                    <td>:</td>
                                    <td>' . $row['position'] . '</td>
                                </tr>
                                <tr>
                                    <td>Jersey Number</td>
                                    <td>:</td>
                                    <td>' . $row['jersey_number'] . '</td>
                                </tr>
                                <tr>
                                    <td>Age</td>
                                    <td>:</td>
                                    <td>' . $row['age'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="update.php?id=' . $row['id'] . '"><button type="button" class="btn btn-warning text-white">Update</button></a>
                <a href="index.php?delete=' . $row['id'] . '"><button type="button" class="btn btn-danger">Delete</button></a>
            </div>';
    }
}

$player->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('PLAYER_DETAILS', $data);
$detail->write();
