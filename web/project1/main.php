<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find A Tourney</title>
</head>
<body>
    <h1>Find a Tournement</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <label for="tournamentSearch">Search: </label><input type="text" name="tournamentSearch" id="tournamentSearch">
      <input type="submit" value="Search"> 
    </form>
    <?php 
        require 'dbconnect.php';

        $tournamentSearch = $_POST['tournamentSearch'];;
        if(!empty($tournamentSearch))
        {
            $stmt = $db->prepare('SELECT  tournamentid, tournamentname 
                                  FROM tournament 
                                  WHERE tournamentname=:tournamentSearch');
            $stmt->bindValue(':tournamentSearch', $tournamentSearch, PDO::PARAM_STR);
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
            echo '<p><a href="tournamentdetails.php?tournamentid='. $row['tournamentid'] . '">' . $row['tournamentname'] . '</a>';
            echo '<p/>';
        }
    ?>
    <div>
        Make a new tournement:
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="tournementName">Tournament Name: </label><input type="text" name="tournementName" id="tournementName"><br>
            <label for="gameName">Game Name: </label><input type="text" name="gameName" id="gameName"><br>
            <input type="submit" value="Create">
        </form>
    </div>
</body>
</html>