<?php

class Player extends DB
{
    function getPlayer()
    {
        // Mengambil data player
        $query = "SELECT * FROM players";

        return $this->execute($query);
    }

    function getPlayerById($id)
    {
        // Mengambil data player berdasarkan id
        $query = "SELECT players.*, clubs.name AS club, positions.name AS position FROM players 
                  JOIN clubs ON players.club_id = clubs.id 
                  JOIN positions ON players.position_id = positions.id 
                  WHERE players.id = $id";

        return $this->execute($query);
    }

    function getPlayerJoin()
    {
        // Mengambil data player dan klub tempat player bermain
        $query = "SELECT players.*, clubs.name AS club, positions.name AS position FROM players 
                  JOIN clubs ON players.club_id = clubs.id 
                  JOIN positions ON players.position_id = positions.id 
                  ORDER BY positions.id DESC";

        return $this->execute($query);
    }

    function getPlayerSort($typeOfSort = 'asc')
    {
        $query = "SELECT players.*, clubs.name AS club, positions.name AS position FROM players 
                  JOIN clubs ON players.club_id = clubs.id 
                  JOIN positions ON players.position_id = positions.id 
                  ORDER BY clubs.id $typeOfSort";
        // Mengambil data player dan klub tempat player bermain

        return $this->execute($query);
    }

    function getPosition()
    {
        // Mengambil data posisi player
        $query = "SELECT * FROM positions ORDER BY positions.id ASC";

        return $this->execute($query);
    }

    function searchPlayer($keyword)
    {
        // Mencari data berdasarkan nama player, posisi bermain, atau nama club
        $query = "SELECT players.*, clubs.name AS club, positions.name AS position FROM players 
                  JOIN clubs ON players.club_id = clubs.id 
                  JOIN positions ON players.position_id = positions.id 
                  WHERE players.name LIKE '%{$keyword}%' OR positions.name LIKE '%{$keyword}%' OR clubs.name LIKE '%{$keyword}%' ORDER BY positions.id DESC";

        return $this->execute($query);
    }

    function addData($data, $file)
    {
        // menyimpan data photo
        $uploadDirectory = 'assets/images/players/';
        $photoName = $file['photo']['name'];
        $photoPath = $uploadDirectory . $photoName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            $name = $data['name'];
            $club = $data['club'];
            $position = $data['position'];
            $jerseyNumber = $data['jersey_number'];
            $age = $data['age'];
        } else {
            $photoName = 'noPhoto.png';
        }

        $query = "INSERT INTO players VALUES('', '$name', '$photoName', '$club', $position, $jerseyNumber, $age);";

        return $this->executeAffected($query);
    }

    function updatePlayer($id, $data, $file)
    {
        $uploadDirectory = 'assets/images/players/';
        $photoName = $file['photo']['name'];
        $photoPath = $uploadDirectory . $photoName;

        $query1 = "SELECT photo FROM players WHERE id='$id'";
        $result = $this->executeSingleResult($query1);
        $previousPhotoName = $result['photo'];

        if ($photoName !== '') {
            if ($previousPhotoName !== 'noPhoto.png') {
                $previousPhotoPath = $uploadDirectory . $previousPhotoName;
                if (file_exists($previousPhotoPath)) {
                    unlink($previousPhotoPath);
                }
            }
            move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
        } else {
            $photoName = $previousPhotoName;
        }

        $name = $data['name'];
        $club_id = $data['club'];
        $position_id = $data['position'];
        $jerseyNumber = $data['jersey_number'];
        $age = $data['age'];

        $query2 = "UPDATE players SET name = '$name', photo = '$photoName',  club_id = '$club_id',position_id = '$position_id', jersey_number = '$jerseyNumber', age = '$age' WHERE id = '$id'";

        return $this->executeAffected($query2);
    }

    function deletePlayer($id)
    {
        $query1 = "SELECT photo FROM players WHERE id='$id'";
        $result = $this->executeSingleResult($query1);
        $previousPhotoPath = 'assets/images/players/' . $result['photo'];

        if (file_exists($previousPhotoPath)) {
            unlink($previousPhotoPath);
        }

        $query2 = "DELETE FROM players WHERE id='$id'";

        return $this->executeAffected($query2);
    }
}
