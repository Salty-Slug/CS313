<?php
    require 'dbconnect.php';

    $tournamentid = $_POST['tournamentid'];
    
    $stmt = $db->prepare('DELETE FROM tournament 
                          WHERE tournamentid=:tournamentid');
    $stmt->bindValue(':tournamentid', $tournamentid, PDO::PARAM_STR);
    $stmt->execute();
?>