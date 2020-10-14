<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Nate Net</title>
</head>
<body>
    <div>
        <a href="assignmentlinks.html">Assignments</a>
    </div>
    <div class="row" id="HeaderRow">
        <div id="IntroSentence">
            I am Nathan, a Computer Science Major from Colorado Springs.
        </div>
    </div>
    <div class="row" id="ProfileRow">
        <div id="ProfilePicDiv">
            <img src="assets/ProfilePic.jpg" id="ProfilePic">
        </div>
        <div id="IntroParagraph">
        <p>
            I love Origami, music, gaming, hiking, programming and many 
            other things. I often will zone out as I am thinking of a new
            story or game idea.
        </p>
        <button onclick="ProfileButtonClicked()">
            Click Me!
        </button>
        </div>
    </div>
    <div>
        <?php echo date("Y/m/d"); ?>
    </div>
    <script src="home.js"></script>
</body>
</html>