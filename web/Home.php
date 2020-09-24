<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Home.css">
    <title>Nate Net</title>
</head>
<body>
    <div class="row" id="HeaderRow">
        <div id="IntroSentence">
            I am Nathan, a Computer Science Major from Colorado Springs.
        </div>
    </div>
    <div class="row" id="ProfileRow">
        <div id="ProfilePicDiv">
            <img src="ProfilePic.jpg" id="ProfilePic">
        </div>
        <div id="IntroParagraph">
            I love Origami, music, gaming, hiking, programming and many 
            other things. I often will zone out as I am thinking of a new
            story or game idea.
        </div>
    </div>
    <div>
        <?php echo date_timestamp_get(); ?>
    </div>
</body>
</html>