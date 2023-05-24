<?php

class Matches extends DB
{
    function getMatches()
    {
        // Mengambil data match
        $query = "SELECT * FROM matches";

        return $this->execute($query);
    }

    function getMatchesById($id)
    {
        // Mengambil data match berdasarkan id
        $query = "SELECT matches.id, matches.date, home_club.name AS home_club, away_club.name AS away_club, stadiums.photo AS photo FROM matches 
                  INNER JOIN clubs AS home_club ON matches.home_club_id = home_club.id 
                  INNER JOIN clubs AS away_club ON matches.away_club_id = away_club.id 
                  INNER JOIN stadiums ON stadiums.id = home_club.stadium_id 
                  WHERE matches.id = $id";

        return $this->execute($query);
    }

    function getMatchesJoin()
    {
        // Mengambil data match dan klub yang bertanding
        $query = "SELECT matches.id, matches.date, home_club.name AS home_club, away_club.name AS away_club, stadiums.photo AS photo FROM matches 
                  INNER JOIN clubs AS home_club ON matches.home_club_id = home_club.id 
                  INNER JOIN clubs AS away_club ON matches.away_club_id = away_club.id 
                  INNER JOIN stadiums ON stadiums.id = home_club.stadium_id";

        return $this->execute($query);
    }

    function searchMatches($keyword)
    {
        // Mencari data berdasarkan nama match, nama klub, atau tanggal
        $query = "SELECT matches.id, matches.date, home_club.name AS home_club, away_club.name AS away_club, stadiums.photo AS photo FROM matches 
                  INNER JOIN clubs AS home_club ON matches.home_club_id = home_club.id 
                  INNER JOIN clubs AS away_club ON matches.away_club_id = away_club.id 
                  INNER JOIN stadiums ON stadiums.id = home_club.stadium_id 
                  WHERE home_club.name LIKE '%{$keyword}%' 
                  OR away_club.name LIKE '%{$keyword}%' 
                  OR matches.date LIKE '%{$keyword}%'";

        return $this->execute($query);
    }


    function addMatches($data)
    {

        $home_club = $data['home_club'];
        $away_club = $data['away_club'];
        $date = $data['date'];

        $query = "INSERT INTO matches VALUES('', '$home_club', '$away_club', '$date')";

        return $this->executeAffected($query);
    }

    function updateMatches($id, $data)
    {
        $home_club = $data['home_club'];
        $away_club = $data['away_club'];
        $date = $data['date'];

        $query = "UPDATE matches SET home_club_id = '$home_club', away_club_id = '$away_club', date = '$date' WHERE id = '$id'";

        return $this->executeAffected($query);
    }

    function deleteMatches($id)
    {
        $query = "DELETE FROM matches WHERE id = '$id'";

        return $this->executeAffected($query);
    }
}
