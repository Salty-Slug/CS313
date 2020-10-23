refreshRoundList();

document.getElementById("newRoundButton").addEventListener("click", function(event) {
    event.preventDefault();
    refreshRoundList();
});
document.getElementById("addPlayerButton").addEventListener("click", function(event) {
    event.preventDefault();
    addPlayer();
});

function refreshRoundList() {
    var xhttp = new XMLHttpRequest();
    var formData = new FormData();


    var players = new Array();
    var otherPlayersChildren = document.captureEventsgetElementById("otherPlayers").children;
    for (var i = 0; i < otherPlayersChildren.length; i++)
    {
        if(otherPlayersChildren[i].classList.contains("playername"))
        {
            players.push(otherPlayersChildren[i].value, otherPlayersChildren[i+2].value);
        }
    }

    formData.append("tournamentid", document.getElementById("selectedTournament").value);
    formData.append("otherplayers", JSON.stringify(players));
    formData.append("roundname", document.getElementById("roundName").value);
    formData.append("roundwinningplayer", document.getElementById("roundWinningPlayer").value);
    formData.append("roundwinningcharacter", document.getElementById("roundWinningCharacter").value);

    document.getElementById("roundList").innerHTML = "";

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("roundList").innerHTML = this.responseText;

            document.getElementById("roundName").value = "";
            document.getElementById("roundWinningPlayer").value = "";
            document.getElementById("roundWinningCharacter").value = "";
            document.getElementById("otherPlayers").innerHTML = "";
        }
    };
    xhttp.open("POST", "roundlist.php", true);
    xhttp.send(formData);
}

function addPlayer() {
    document.getElementById("otherPlayers").innerHTML += "<label>Player Name: </label>" +
                                 "<input type=\"text\" class=\"playername\" name=\"player[]\"><br>" +
                                 "<label>Character Name: </label>" +
                                 "<input type=\"text\" class=\"charactername\" name=\"character[]\"><br>";
}