<?php
    require 'dbconnect.php';

    $tournamentid = $_POST['tournamentid'];
    
    $tourneyrounddelete = $db->prepare('DELETE FROM tournamentround 
                                   WHERE tournamentid=:tournamentid');
    $tourneyrounddelete->bindValue(':tournamentid', $tournamentid, PDO::PARAM_STR);
    $tourneyrounddelete->execute();

    $tourneydelete = $db->prepare('DELETE FROM tournament 
                          WHERE tournamentid=:tournamentid');
    $tourneydelete->bindValue(':tournamentid', $tournamentid, PDO::PARAM_STR);
    $tourneydelete->execute();
?>