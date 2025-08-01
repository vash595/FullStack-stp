function validate() {
    var result = true;
    password1 = document.getElementById("password");
    password2 = document.getElementById("confirm_password");
    if (password1.value !== password2.value) {
        result = false;
        password1.style = "border-color:red";
        password2.style = "border-color:red";
    } else {
        password1.style = "";
        password2.style = "";
    }

    no = document.getElementById("phone");
    if (no.value.length !== 10) {
        result = false;
        no.style = "border-color:red";
    }
    return result;
}