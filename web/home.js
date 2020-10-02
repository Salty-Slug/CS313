function ProfileButtonClicked() 
{
    var picture = document.getElementById("ProfilePicDiv");

    if(picture.style.transform == "scaleX(1)")
    {
        picture.style.transform = "scaleX(-1)";
    }
    else
    {
        picture.style.transform = "scaleX(1)";
    }
}