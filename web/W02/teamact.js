function ChangeColor()
{
    var colorChangeInput = document.getElementById("ColorChangeInput");
    var div1 = document.getElementById("div1");

    var color = colorChangeInput.value;
    div1.style.backgroundColor = color;
}

function ClickMeButtonClicked()
{
    alert("Clicked!");
}