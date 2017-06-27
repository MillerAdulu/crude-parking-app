function formValidate(){
    var username = $("#username").val();
    var firstName = $("#firstName").val();
    var lastName = $("#lastName").val();
    var userEmail = $("#userEmail").val();
    var userPassword = $("#userPassword").val();
    var retypePassword = $("#retypePassword").val();

    if(username  === "" || firstName === "" || lastName === "" || userEmail === "" || userPassword === "" || retypePassword === "") {
        alert("Ensure all the fields are filled");
        return false;
    }
    else if(userPassword !== retypePassword){
        alert("Your passwords don't match");
        return false;
    }
    else if(userPassword.length < 8){
        alert("Ensure your password is at least 8 characters long");
        return false;
    }
    else
        return true;
}
