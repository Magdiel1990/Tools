//Function to validate if all the fields of the form were filled
function validateForm () {
    let tool = document.forms["toolRegister"]["tool"].value;
    let quantity = document.forms["toolRegister"]["quantity"].value;
    let location = document.forms["toolRegister"]["location"].value;
    let color = document.forms["toolRegister"]["color"].value;
    if (tool == "" || quantity == "" || location == "" || color == "") {
        alert("Por favor complete los campos faltantes!");
        return false;    
    }
}

