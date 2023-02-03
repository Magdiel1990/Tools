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
    // if(isset($_SESSION['message'])){
        if(isset($_SESSION['message'])){
            $successAlert = new alertButtons($_SESSION['message_alert'], $_SESSION['message']);
            $successAlert -> buttonMessage();
    //Unsetting the message variables so the message fades after refreshing the page.
            unset($_SESSION['message_alert'], $_SESSION['message']);
        }
    ?>
    <h4 class="text-center">Herramientas</h4>

    <div class="row mt-4">
        
        <div class="col-auto">
            <select name="num_registros" id="num_registros" class="form-select">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>

        <div class="col-auto">
            <input class="form-control" type="text" placeholder="Buscar" autofocus name="search" id="search" maxlength="50" size="25">
        </div>    

    </div>

    <div class="row py-4">
        <div class="col">      
            <table class="table table-sm table-bordered">
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
                <!-- El id del cuerpo de la tabla. -->
                <tbody id="content">  
                </tbody>
            </table>            
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <label id="lbl-total"></label>
        </div>
        <div class="col-6" id="nav-paginacion">            
        </div>
    </div>
</main>        
<script>
    let paginaActual = 1


    getData(paginaActual)

    document.getElementById("search").addEventListener("keyup", function() {
        getData(paginaActual)
    }, false)
    
    document.getElementById("num_registros").addEventListener("change", function() {
        getData(paginaActual)
    }, false)

    function getData(pagina){
    let input = document.getElementById("search").value
    let num_registros = document.getElementById("num_registros").value
    let content = document.getElementById("content")
    
    if(pagina != null){
        paginaActual = pagina
    }

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
    }).catch(err => console.log(err))
    }
</script>
<?php
//We include the footer (jquery, bootstrap and popper scripts).
include("modulos/footer.php");
?>
