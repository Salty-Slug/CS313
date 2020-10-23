<?php
    function console_log( $data ){
    echo '<script>';
    echo 'console.log("'. $data .'")';
    echo '</script>';
    }

    require 'dbconnect.php';

    $tourneyroundstmt = $db->prepare('SELECT  tr.tournamentid, tr.roundid, r.roundname, p.playername, charactername
                                    FROM tournamentround tr 
                                    JOIN round r ON r.roundid = tr.roundid
                                    JOIN player p ON p.playerid = r.winningplayer
                                    JOIN character c ON c.characterid = r.winningcharacter
                                    WHERE tr.tournamentid=:selectedtournament');
    $tourneyroundstmt->bindValue(':selectedtournament', $selectedTournament, PDO::PARAM_STR);
    $tourneyroundstmt->execute();
    $tourneyrounds = $tourneyroundstmt->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($tourneyrounds))
    {
        foreach ($tourneyrounds as $row)
        {
            console_log("entering round display");
            
            echo '<div><p><h2>' . $row['roundname'] . '</h2></p>' .
            '<p>Winner: ' . $row['playername'] . ' as ' . $row['charactername'] . 
            '<p>Other Players:</p><p>';
            
            $playercharroundstmt = $db->prepare('SELECT r.roundid, p.playername, c.charactername
                                                FROM playercharacterround pcr
                                                JOIN round r ON r.roundid = pcr.roundid
                                                JOIN player p ON p.playerid = pcr.playerid
                                                JOIN character c ON c.characterid = pcr.characterid
                                                WHERE pcr.roundid=:currentroundid');
            $playercharroundstmt->bindValue(':currentroundid', $row['roundid'], PDO::PARAM_STR);
            $playercharroundstmt->execute();
            
            foreach ($playercharroundstmt->fetchAll(PDO::FETCH_ASSOC) as $pcrrow)
            {
                echo '<p>' . $pcrrow['playername'] . ' as ' . $pcrrow['charactername'] . '</p>';
            }
            
            echo '</p></div>';
        }   
    }
?>