<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Details</title>
</head>
<body>
    <?php
        require 'dbconnect.php';

        $selectedTournament = $_GET['tournamentid'];
        
        $tournementstmt = $db->prepare('SELECT  tournamentid, tournamentname, gameplayed, winningplayer 
                                        FROM tournament 
                                        WHERE tournamentid=:selectedtournament');
        $tournementstmt->bindValue(':selectedtournament', $selectedTournament, PDO::PARAM_STR);
        $tournementstmt->execute();

        foreach ($tournementstmt->fetchAll(PDO::FETCH_ASSOC) as $row)
        {
            echo '<h1>' . $row['tournamentname'] . '</h1>';
            echo '<div> Game Played: ' . $row['gameplayed'] . '</div>'; 

            if(!empty($row['winningplayer']))
            {
                echo '<div>Winner: ' . $row['winningplayer'] . '</div>';
            }
            else
            {
                echo '<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <label for="winner">Input a winner: </label><input type="text" name="winner" id="winner"><br>
                        <input type="submit" value="Submit"> 
                      </form>';
            }

            // TODO: Loop through all the rounds, and then loop through to get the players and characters from each round
            $tourneyroundstmt = $db->prepare('SELECT  tr.tournamentid, tr.roundid, r.roundname, p.playername, charactername
                                             FROM tournamentround tr 
                                             JOIN round r ON r.roundid = tr.roundid
                                             JOIN player p ON p.playerid = r.winningplayer
                                             JOIN character c ON c.characterid = r.winningcharacter
                                             WHERE tr.tournamentid=:selectedtournament');
            $tourneyroundstmt->bindValue(':selectedtournament', $selectedTournament, PDO::PARAM_STR);
            $tourneyroundstmt->execute();

            foreach ($tourneyroundstmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            {
                
                echo '<div><p><h2>' . $row['r.roundname'] . '</h2></p>' .
                     '<p>Winner: ' . $row['p.playername'] . ' as ' . $row['c.charactername'] . 
                     '<p>Other Players:</p><p>';

                    $playercharroundstmt = $db->prepare('SELECT r.roundid, c.charactername, p.playername
                                                         FROM playercharacterround pcr
                                                         JOIN round r ON r.roundid = pcr.roundid
                                                         JOIN player p ON p.playerid = pcr.playerid
                                                         JOIN character c ON c.characterid = pcr.characterid
                                                         WHERE pcr.roundid=:currentroundid');
                    $playercharroundstmt->bindValue(':currentroundid', $row['tr.roundid'], PDO::PARAM_STR);
                    $playercharroundstmt->execute();

                    foreach ($playercharroundstmt->fetchAll(PDO::FETCH_ASSOC) as $pcrrow)
                    {
                        echo '<p>' . $pcrrow['p.playername'] . ' as ' . $pcrrow['c.charactername'] . '</p>';
                    }

                echo '</p></div>';
            }

        }
    ?>
</body>
</html>