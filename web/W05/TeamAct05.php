<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Activity 05</title>
</head>
<body>
    <h1>Scripture Resources</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      Book Search: <input type="text" name="bookSearch">
      <input type="submit" value="Submit"> 
    </form>
    <?php 
        try
        {
        $dbUrl = getenv('DATABASE_URL');
        
        $dbOpts = parse_url($dbUrl);
        
        $dbHost = $dbOpts["host"];
        $dbPort = $dbOpts["port"];
        $dbUser = $dbOpts["user"];
        $dbPassword = $dbOpts["pass"];
        $dbName = ltrim($dbOpts["path"],'/');
        
        $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
        
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $ex)
        {
        echo 'Error!: ' . $ex->getMessage();
        die();
        }

        $bookSearch = $_POST['bookSearch'];

        $stmt = $db->prepare('SELECT scriptureid, book, chapter, verse, content FROM scripture WHERE book=:bookSearch');
        $stmt->bindValue(':bookSearch', $bookSearch, PDO::PARAM_STR);
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
        {
            if($bookSearch == $row['book'])
            {
                echo '<p><a href="ScriptureDetails.php?scriptureId='. $row['scriptureid'] . '"><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b></a>';
                echo '<p/>';
            }
        }
    ?>
</body>
</html>