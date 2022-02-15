let submitButton = document.getElementById('submit');
submitButton.addEventListener("click",submittingForm);
function submittingForm(e)
{
    let username = document.getElementById("UserName").value;
    let email = document.getElementById("InputEmail").value;
    console.log(username,email);
}

