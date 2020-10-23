refreshTournamentList();

document.getElementById("newTournamentButton").addEventListener("click", function(event) {
    event.preventDefault();
    refreshTournamentList();
});
document.getElementById("searchTournamentButton").addEventListener("click", function(event) {
    event.preventDefault();
    refreshTournamentList();
});

function refreshTournamentList() {
    var xhttp = new XMLHttpRequest();
    var formData = new FormData();

    formData.append("tournamentSearch", document.getElementById("tournamentSearch").value);
    formData.append("tournamentName", document.getElementById("tournamentName").value);
    formData.append("gameName", document.getElementById("gameName").value);

    document.getElementById("tournamentList").innerHTML = "";

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tournamentList").innerHTML = this.responseText;
            document.getElementById("tournamentName").value = "";
            document.getElementById("gameName").value = "";
        }
    };
    xhttp.open("POST", "tournamentlist.php", true);
    xhttp.send(formData);
}

function deleteTournament(tourneyId) {
    var xhttp = new XMLHttpRequest();
    var formData = new FormData();

    formData.append("tournamentid", tourneyId);

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            refreshTournamentList();
        }
    };
    xhttp.open("POST", "deletetournament.php", true);
    xhttp.send(formData);
}