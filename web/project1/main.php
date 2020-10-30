<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tournament.css">
    <title>Find A Tourney</title>
</head>
<body>
    <h1>Find a Tournement</h1>
    <form action="" method="post">
      <label for="tournamentSearch">Search: </label><input type="text" name="tournamentSearch" id="tournamentSearch">
      <input type="submit" value="Search" id="searchTournamentButton"> 
    </form>
    <div id="tournamentList">

    </div>
    <div>
        <h1> Make a New Tournement: </h1>
        <form action="" method="post">
            <label for="tournamentName">Tournament Name: </label><input type="text" name="tournamentName" id="tournamentName"><br>
            <label for="gameName" id="gameNameLabel">Game Name: </label><input type="text" name="gameName" id="gameName"><br>
            <input type="submit" value="Create" id="newTournamentButton">
        </form>
    </div>
    <script src="tournamenthandler.js"></script>
</body>
</html>