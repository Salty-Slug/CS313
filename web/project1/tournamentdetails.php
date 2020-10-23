<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Details</title>
</head>
<body>
    <?php
        function console_log( $data ){
        echo '<script>';
        echo 'console.log("'. $data .'")';
        echo '</script>';
        }

        require 'dbconnect.php';
        console_log("initializing");

        $selectedTournament = $_GET['tournamentid'];
        
        $tournementstmt = $db->prepare('SELECT  t.tournamentid, t.tournamentname, t.gameplayed, p.playername
                                        FROM tournament t
                                        JOIN player p ON p.playerid = t.winningplayer
                                        WHERE tournamentid=:selectedtournament');
        $tournementstmt->bindValue(':selectedtournament', $selectedTournament, PDO::PARAM_STR);
        $tournementstmt->execute();

        foreach ($tournementstmt->fetchAll(PDO::FETCH_ASSOC) as $row)
        {
            console_log("entering tournament display");
            echo '<h1>' . $row['tournamentname'] . '</h1>';
            echo '<div><p><b>Game Played: </b>' . $row['gameplayed'] . '</p>'; 

            if(!empty($row['playername']))
            {
                echo '<p><b>Winner: </b>' . $row['playername'] . '</p>';
            }
            else
            {
                echo '<form action="echo htmlspecialchars($_SERVER["PHP_SELF"]);" method="post">
                        <label for="winner">Input a winner: </label><input type="text" name="winner" id="winner"><br>
                        <input type="submit" value="Submit"> 
                      </form>';
            }
            echo '</div>';

            try
            {

                $tourneyroundstmt = $db->prepare('SELECT  tr.tournamentid, tr.roundid, r.roundname, p.playername, charactername
                                             FROM tournamentround tr 
                                             JOIN round r ON r.roundid = tr.roundid
                                             JOIN player p ON p.playerid = r.winningplayer
                                             JOIN character c ON c.characterid = r.winningcharacter
                                             WHERE tr.tournamentid=:selectedtournament');
                $tourneyroundstmt->bindValue(':selectedtournament', $selectedTournament, PDO::PARAM_STR);
                $tourneyroundstmt->execute();
                $tourneyrounds = $tourneyroundstmt->fetchAll(PDO::FETCH_ASSOC);
            }
            catch (PDOException $ex)
            {
              echo 'Error!: ' . $ex->getMessage();
              die();
            }

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
        }
    ?>
</body>
</html>