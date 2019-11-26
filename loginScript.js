function makeSecret() {
    var aWord = document.getElementById("PASS");
    if (aWord.type === "password") {
        aWord.type = "text";
    }
    else {
        aWord.type = "password";
    }
}