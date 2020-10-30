<?php 
    require 'dbconnect.php';

    $newTournamentName = htmlspecialchars($_POST['tournamentName']);
    $newTournamentGame = htmlspecialchars($_POST['gameName']);
    $tournamentSearch = htmlspecialchars($_POST['tournamentSearch']);

    if(!empty($newTournamentGame) && !empty($newTournamentName))
    {
        $stmt = $db->prepare('INSERT INTO Tournament (tournamentname, gameplayed)
                                VALUES (:newTournamentName, :newTournamentGame)');
        $stmt->execute(array(':newTournamentName' => $newTournamentName, 
                             ':newTournamentGame' => $newTournamentGame));
    }

    if(!empty($tournamentSearch))
    {
        $stmt = $db->prepare('SELECT  tournamentid, tournamentname 
                                FROM tournament 
                                WHERE LOWER(tournamentname) LIKE LOWER(:tournamentSearch)');
        $stmt->bindValue(':tournamentSearch', '%' . $tournamentSearch . '%', PDO::PARAM_STR);
        $stmt->execute();
    }
    else
    {
        $stmt = $db->prepare('SELECT  tournamentid, tournamentname 
                                FROM tournament');
        $stmt->execute();
    }
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
    {
        echo '<p><a href="tournamentdetails.php?tournamentid='. $row['tournamentid'] . '">' . $row['tournamentname'] . '</a>' . 
             '<button id="delete' . $row['tournamentid'] . '" onclick="deleteTournament(' . $row['tournamentid'] . ')">Delete</button>';
        echo '<p/>';
    }
?>