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
        $newWinner = $_GET['winner'];

        if(!empty($newWinner))
        {
            try
            {
                $playerstmt = $db->prepare('SELECT  playerid, playername
                                                FROM player
                                                WHERE playername=:winner');
                $playerstmt->bindValue(':winner', $newWinner, PDO::PARAM_STR);
                $playerstmt->execute();

                if(empty($playerstmt->fetchAll(PDO::FETCH_ASSOC)))
                {
                    $playerstmt = $db->prepare('INSERT INTO player(playername)
                                                VALUES :winner');
                    $playerstmt->bindValue(':winner', $newWinner, PDO::PARAM_STR);
                    $playerstmt->execute();

                    $newWinnerId = $db->lastInsertId('player_playerid_seq');
                }
                else
                {
                    $newWinnerId = $playerstmt->fetch(PDO::FETCH_ASSOC)['playerid'];

                }

                $winnerinsert = $db->prepare('UPDATE tournament
                                          SET winningplayer=:winner
                                          WHERE tournamentid=:tournamentid');
                $winnerinsert->bindValue(':winner', $newWinnerId, PDO::PARAM_STR);
                $winnerinsert->bindValue(':tournamentid', $selectedTournament, PDO::PARAM_STR);
                $winnerinsert->execute();
            }
            catch(PDOException $ex)
            {
              echo 'Error!: ' . $ex->getMessage() . '<br>';
            }
        }
        
        $tournementstmt = $db->prepare('SELECT  t.tournamentid, t.tournamentname, t.gameplayed, p.playername
                                        FROM tournament t
                                        LEFT JOIN player p ON p.playerid = t.winningplayer
                                        WHERE tournamentid=:selectedtournament');
        $tournementstmt->bindValue(':selectedtournament', $selectedTournament, PDO::PARAM_STR);
        $tournementstmt->execute();

        foreach($tournementstmt->fetchAll(PDO::FETCH_ASSOC) as $row)
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
                echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="GET">
                        <input type="hidden" value="' . $selectedTournament . '" id="tournamentid" name="tournamentid">
                        <label for="winner">Input a winner: </label><input type="text" name="winner" id="winner">
                        <input type="submit" value="Submit"> 
                        </form>';
            }
            echo '</div>';
        }
    ?>
    <div id="roundList">
    </div>
    <div>
        <h2> Add a New Round: </h2>
        <div>
            <form action="" method="post">
                <input type="hidden" value="<?php echo $selectedTournament ?>" id="selectedTournament">
                <label for="roundName">Round Name: </label>
                <input type="text" name="roundName" id="roundName"><br>
                <label for="roundWinningPlayer">Winning Player: </label>
                <input type="text" name="roundWinningPlayer" id="roundWinningPlayer"><br>
                <label for="roundWinningCharacter">Winning Character: </label>
                <input type="text" name="roundWinningCharacter" id="roundWinningCharacter"><br>
                Other Players: <br>
                <div id="otherPlayers">
                </div>
                <button id="addPlayerButton">Add Player</button>
                <input type="submit" value="Create" id="newRoundButton">
            </form>
        </div>
    </div>
    <script src="roundhandler.js"></script>
</body>
</html>