<?php

class Stadium extends DB
{
    function getStadium()
    {
        // Mengambil data dari tabel stadiums
        $query = "SELECT * FROM stadiums";

        return $this->execute($query);
    }

    function getStadiumById($id)
    {
        // Mengambil data berdasarkan id
        $query = "SELECT * FROM stadiums WHERE id = $id";

        return $this->execute($query);
    }

    function searchStadium($keyword)
    {
        // Mencari data berdasarkan nama stadium atau lokasi
        $query = "SELECT * FROM stadiums WHERE stadiums.name LIKE '%{$keyword}%' OR stadiums.location LIKE '%{$keyword}%'";

        return $this->execute($query);
    }

    function addStadium($data, $file)
    {
        // Menambahkan data ke dalam tabel stadiums
        $uploadDirectory = 'assets/images/stadiums/';
        $photoName = $file['photo']['name'];
        $photoPath = $uploadDirectory . $photoName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            $name = $data['name'];
            $location = $data['location'];
        } else {
            $photoName = 'noPhoto.png';
        }

        $query = "INSERT INTO stadiums VALUES('', '$name', '$location', '$photoName')";

        return $this->executeAffected($query);
    }

    function updateStadium($id, $data, $file)
    {
        $uploadDirectory = 'assets/images/stadiums/';
        $photoName = $file['photo']['name'];
        $photoPath = $uploadDirectory . $photoName;

        $query1 = "SELECT photo FROM stadiums WHERE id='$id'";
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
        $location = $data['location'];

        $query2 = "UPDATE stadiums SET name='$name', location='$location', photo='$photoName' WHERE id='$id'";

        return $this->executeAffected($query2);
    }


    function deleteStadium($id)
    {
        $query1 = "SELECT photo FROM stadiums WHERE id='$id'";
        $result = $this->executeSingleResult($query1);
        $previousPhotoPath = 'assets/images/stadiums/' . $result['photo'];

        if (file_exists($previousPhotoPath)) {
            unlink($previousPhotoPath);
        }

        $query = "DELETE FROM stadiums WHERE id = $id";

        return $this->executeAffected($query);
    }
}
