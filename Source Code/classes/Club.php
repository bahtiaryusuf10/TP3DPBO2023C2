<?php

class Club extends DB
{
    function getClub()
    {
        // Mengambil data club
        $query = "SELECT * FROM clubs ORDER BY name ASC";

        return $this->execute($query);
    }

    function getClubById($id)
    {
        // Mengambil data club id
        $query = "SELECT * FROM clubs WHERE id = $id";

        return $this->execute($query);
    }

    function getClubJoin()
    {
        // Mengambil data dari club dan stadiumnya
        $query = "SELECT clubs.id, clubs.name, clubs.logo, clubs.coach, stadiums.name AS stadium FROM clubs 
                  JOIN stadiums ON clubs.stadium_id = stadiums.id";

        return $this->execute($query);
    }

    function searchClub($keyword)
    {
        // Mencari data berdasarkan nama club atau nama pelatih
        $query = "SELECT clubs.id, clubs.name, clubs.logo, clubs.coach, stadiums.name AS stadium FROM clubs 
                  JOIN stadiums ON clubs.stadium_id = stadiums.id 
                  WHERE clubs.name LIKE '%{$keyword}%' OR clubs.coach LIKE '%{$keyword}%'";

        return $this->execute($query);
    }

    function addClub($data, $file)
    {
        // Menambahkan data club
        $uploadDirectory = 'assets/images/logos/';
        $photoName = $file['logo']['name'];
        $photoPath = $uploadDirectory . $photoName;

        if (move_uploaded_file(
            $_FILES['logo']['tmp_name'],
            $photoPath
        )) {
            $name = $data['name'];
            $stadium_id = $data['stadium'];
            $coach = $data['coach'];
        } else {
            $photoName = 'noPhoto.png';
        }

        $query = "INSERT INTO clubs VALUES('', '$name', '$stadium_id', '$photoName', '$coach')";

        return $this->executeAffected($query);
    }

    function updateClub($id, $data, $file)
    {
        $uploadDirectory = 'assets/images/logos/';
        $photoName = $file['logo']['name'];
        $photoPath = $uploadDirectory . $photoName;

        $query1 = "SELECT logo FROM clubs WHERE id='$id'";
        $result = $this->executeSingleResult($query1);
        $previousPhotoName = $result['logo'];

        if ($photoName !== '') {
            if ($previousPhotoName !== 'noPhoto.png') {
                $previousPhotoPath = $uploadDirectory . $previousPhotoName;
                if (file_exists($previousPhotoPath)) {
                    unlink($previousPhotoPath);
                }
            }
            move_uploaded_file($_FILES['logo']['tmp_name'], $photoPath);
        } else {
            $photoName = $previousPhotoName;
        }

        $name = $data['name'];
        $stadium_id = $data['stadium'];
        $coach = $data['coach'];

        $query2 = "UPDATE clubs SET name='$name', stadium_id='$stadium_id', logo='$photoName', coach='$coach' WHERE id='$id'";

        return $this->executeAffected($query2);
    }

    function deleteClub($id)
    {
        $query1 = "SELECT logo FROM clubs WHERE id='$id'";
        $result = $this->executeSingleResult($query1);
        $previousPhotoPath = 'assets/images/logos/' . $result['logo'];

        if (file_exists($previousPhotoPath)) {
            unlink($previousPhotoPath);
        }

        // Menghapus data club
        $query = "DELETE FROM clubs WHERE id='$id'";

        return $this->executeAffected($query);
    }
}
