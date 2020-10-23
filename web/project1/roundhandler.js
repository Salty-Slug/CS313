refreshRoundList();

document.getElementById("newRoundButton").addEventListener("click", function(event) {
    event.preventDefault();
    refreshRoundList();
});

function refreshRoundList() {
    var xhttp = new XMLHttpRequest();
    var formData = new FormData();

    formData.append("roundName", document.getElementById("roundName").value);
    formData.append("roundWinningPlayer", document.getElementById("roundWinningPlayer").value);
    formData.append("roundWinningCharacter", document.getElementById("roundWinningCharacter").value);

    document.getElementById("roundList").innerHTML = "";

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("roundList").innerHTML = this.responseText;
            document.getElementById("roundName").value = "";
            document.getElementById("roundWinningPlayer").value = "";
            document.getElementById("roundWinningCharacter").value = "";
        }
    };
    xhttp.open("POST", "roundlist.php", true);
    xhttp.send(formData);
}