<?php
    function console_log( $data ){
    echo '<script>';
    echo 'console.log("'. $data .'")';
    echo '</script>';
    }

    require 'dbconnect.php';
    
    $selectedTournament = $_POST['tournamentid'];
    $newRoundName = $_POST['roundname'];
    $newRoundWinningPlayer = $_POST['roundwinningplayer'];
    $newRoundWinningCharacter = $_POST['roundwinningcharacter'];
    $newRoundOtherPlayers = json_decode($_POST['otherplayers']);

    if(!empty($newRoundName) && !empty($newRoundWinningCharacter) && !empty($newRoundWinningPlayer))
    {
        try
        {
            //Get Player or make a new one
            $playerstmt = $db->prepare('SELECT  playerid, playername
                                            FROM player
                                            WHERE playername=:winner');
            $playerstmt->bindValue(':winner', $newRoundWinningPlayer, PDO::PARAM_STR);
            $playerstmt->execute();

            $winningplayerarray = $playerstmt->fetch(PDO::FETCH_ASSOC);

            if(empty($winningplayerarray))
            {
                $playerstmt = $db->prepare('INSERT INTO player(playername)
                                            VALUES (:winner)');
                $playerstmt->bindValue(':winner', $newRoundWinningPlayer, PDO::PARAM_STR);
                $playerstmt->execute();

                $newRoundWinningPlayerId = $db->lastInsertId('player_playerid_seq');
            }
            else
            {
                $newRoundWinningPlayerId = $winningplayerarray['playerid'];

            }

            //Get Character or make a new one
            $characterstmt = $db->prepare('SELECT  characterid, charactername
                                            FROM character
                                            WHERE charactername=:winningchar');
            $characterstmt->bindValue(':winningchar', $newRoundWinningCharacter, PDO::PARAM_STR);
            $characterstmt->execute();

            $winningcharacterarray = $characterstmt->fetch(PDO::FETCH_ASSOC);

            if(empty($winningcharacterarray))
            {
                $characterstmt = $db->prepare('INSERT INTO character(charactername)
                                            VALUES (:winningchar)');
                $characterstmt->bindValue(':winningchar', $newRoundWinningCharacter, PDO::PARAM_STR);
                $characterstmt->execute();

                $newRoundWinningCharacterId = $db->lastInsertId('character_characterid_seq');
            }
            else
            {
                $newRoundWinningCharacterId = $winningcharacterarray['characterid'];
            }

            //New Round
            $roundstmt = $db->prepare('INSERT INTO round(roundname, winningplayer, winningcharacter)
                                       VALUES (:roundname, :winningplayer, :winningcharacter)');
            $roundstmt->execute(array(':roundname' => $newRoundName, 
                                      ':winningplayer' => $newRoundWinningPlayerId,
                                      ':winningcharacter' => $newRoundWinningCharacterId));
            $newRoundId = $db->lastInsertId('round_roundid_seq');

            //New TournamentRound
            $tourneyroundstmt = $db->prepare('INSERT INTO tournamentround(tournamentid, roundid)
                                              VALUES (:tournamentid, :roundid)');
            $tourneyroundstmt->execute(array(':tournamentid' => $selectedTournament, 
                                             ':roundid' => $newRoundId,));

            //New PlayerCharacterRound for the winner
            $playercharacterroundstmt = $db->prepare('INSERT INTO playercharacterround(playerid, characterid, roundid)
                                                      VALUES (:playerid, :characterid, :roundid)');
            $playercharacterroundstmt->execute(array(':playerid' => $newRoundWinningPlayerId, 
                                                     ':characterid' => $newRoundWinningCharacterId,
                                                     ':roundid' => $newRoundId));

            //New PlayerCharacterRound for other players
            foreach($newRoundOtherPlayers as $playercharacter)
            {
                //Get Player or make a new one
                $playerstmt = $db->prepare('SELECT  playerid, playername
                                            FROM player
                                            WHERE playername=:player');
                $playerstmt->bindValue(':player', $playercharacter[0], PDO::PARAM_STR);
                $playerstmt->execute();

                $playerarray = $playerstmt->fetch(PDO::FETCH_ASSOC);

                if(empty($playerarray))
                {
                    $playerstmt = $db->prepare('INSERT INTO player(playername)
                                                VALUES (:player)');
                    $playerstmt->bindValue(':player', $playercharacter[0], PDO::PARAM_STR);
                    $playerstmt->execute();

                    $newRoundPlayerId = $db->lastInsertId('player_playerid_seq');
                }
                else
                {
                    $newRoundPlayerId = $playerarray['playerid'];
                }

                //Get Character or make a new one
                $characterstmt = $db->prepare('SELECT  characterid, charactername
                                                FROM character
                                                WHERE charactername=:charactername');
                $characterstmt->bindValue(':charactername', $playercharacter[1], PDO::PARAM_STR);
                $characterstmt->execute();

                $characterarray = $characterstmt->fetch(PDO::FETCH_ASSOC);

                if(empty($characterarray))
                {
                    $characterstmt = $db->prepare('INSERT INTO character(charactername)
                                                   VALUES (:charactername)');
                    $characterstmt->bindValue(':charactername', $playercharacter[1], PDO::PARAM_STR);
                    $characterstmt->execute();

                    $newRoundCharacterId = $db->lastInsertId('character_characterid_seq');
                }
                else
                {
                    $newRoundCharacterId = $characterarray['characterid'];
                }

                $playercharacterroundstmt = $db->prepare('INSERT INTO playercharacterround(playerid, characterid, roundid)
                                                      VALUES (:playerid, :characterid, :roundid)');
                $playercharacterroundstmt->execute(array(':playerid' => $newRoundPlayerId, 
                                                      ':characterid' => $newRoundCharacterId,
                                                      ':roundid' => $newRoundId));
            }
        }
        catch(PDOException $ex)
        {
            echo 'Error!: ' . $ex->getMessage() . '<br>';
        }
    }

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
            '<p>All Players:</p><p>';
            
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