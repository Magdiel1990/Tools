<?php

//Including the head and session_start.
include ("modulos/head.php");

//Verifying the login time
require ("loginTimeVerification.php");

//We include the classes file so we can call the methods.
include ("classes/classes.php");

?>
<div>

<?php
//Including the navigation file.
include("modulos/nav.php");
?>

<!--Main content of the index file-->
<main class="container py-4">
    <?php
    //Messages that are shown in the index page 
        if(isset($_SESSION['message'])){
            $message = new alertButtons($_SESSION['message_alert'], $_SESSION['message']);
            $message -> buttonMessage();
    //Unsetting the messages variables so the message fades after refreshing the page.
            unset($_SESSION['message_alert'], $_SESSION['message']);
        }
    ?>
    <h4 class="text-center">Herramientas</h4>

    <div class="row mt-4">
    <!--Select input for choosing the number of tools to be shown-->       
        <div class="col-auto">
            <select name="num_registros" id="num_registros" class="form-select">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    <!--Input to filter the list of tools--> 
        <div class="col-auto">
            <input class="form-control" type="text" placeholder="Buscar" autofocus name="search" id="search" maxlength="50" size="25">
        </div>    

    </div>

    <div class="row py-4">
        <div class="col">  
    <!--Table to show the tools in the index file-->     
            <table class="table table-sm table-bordered">
    <!--Head of the table-->               
                <thead class="text-center text-light bg-dark">
                    <tr>
                        <th>Herramienta</th>
                        <th>Color</th>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Acciones</th>   
                    </tr>
                </thead>
    <!-- El id del cuerpo de la tabla where the content will be shown. -->
                <tbody id="content">  
                </tbody>
            </table>            
        </div>
    </div>
    <!--Text that shows the amount of tools below the table-->
    <div class="row">
        <div class="col-6">
            <label id="lbl-total"></label>
        </div>
    <!--Pagination buttons-->
        <div class="col-6" id="nav-paginacion">            
        </div>
    </div>
</main>        
<script>
//Current page.
    let paginaActual = 1

//Calling to the getData function.
    getData(paginaActual)
//Adding event to the searching input.
    document.getElementById("search").addEventListener("keyup", function() {
        getData(paginaActual)
    }, false)
//Adding event to the text that shows the amount of tools below the table.   
    document.getElementById("num_registros").addEventListener("change", function() {
        getData(paginaActual)
    }, false)
//Creating function to get the data from the load.php file.  
    function getData(pagina){
//Declaring the variables.  
    let input = document.getElementById("search").value
    let num_registros = document.getElementById("num_registros").value
    let content = document.getElementById("content")
//If the pagina variable comes empty it is equal to paginaActual.  
    if(pagina != null){
        paginaActual = pagina
    }
//The data is got from the load.php file.  
    let url = "load.php"
    let formaData = new FormData()
    formaData.append("search", input)
    formaData.append("registros", num_registros)
    formaData.append("pagina", pagina)

    fetch(url, {
        method: "POST",
        body: formaData            
    }).then(response => response.json())
    .then(data => {
        content.innerHTML = data.data
        document.getElementById("lbl-total").innerHTML = data.totalFilters + " resultados de " + data.totalRegisters
        document.getElementById("nav-paginacion").innerHTML = data.paginacion
//If there's an error.  
    }).catch(err => console.log(err))
    }
</script>

<?php

//We include the footer (jquery, bootstrap and popper scripts).
include("modulos/footer.php");

?>
