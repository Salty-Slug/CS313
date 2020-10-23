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
                                        LEFT JOIN player p ON p.playerid = t.winningplayer
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
                <label for="roundName">Round Name: </label>
                <input type="text" name="roundName" id="roundName"><br>
                <label for="roundWinningPlayer">Winning Player: </label>
                <input type="text" name="roundWinningPlayer" id="roundWinningPlayer"><br>
                <label for="roundWinningCharacter">Winning Character: </label>
                <input type="text" name="roundWinningCharacter" id="roundWinningCharacter"><br>
                <input type="submit" value="Create" id="newRoundButton">
                <input type="hidden" value="<?php echo $selectedTournament ?>" id="selectedTournament">
            </form>
        </div>
    </div>
    <script src="roundhandler.js"></script>
</body>
</html>