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

function showCustomer(str) {
    if (str == "") {
      document.getElementById("txtHint").innerHTML = "";
      return;
    }
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
    xhttp.open("GET", "add-tools.php?q="+str);
    xhttp.send();
  }

 