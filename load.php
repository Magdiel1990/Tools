<?php
    //Including the database connection.
    include ("db/db.php");
    
    //Array of the columns to be querried from the database.
    $columns = ["id", "tools", "color", "quantity", "description", "fecha"];
    
    //Table to be querried from the database.
    $table = "registersum";


    $id = "id";

    //If the variable search is set it's received, else it's null.
    $field = isset($_POST["search"]) ? $conn -> real_escape_string($_POST["search"]) : null;
    
    /*Filter where*/
    $where = "";

    //If the variable search isn't null, the query is done with the where.
    if($field != null){
        $where = "WHERE (";

        $count = count($columns);
        for($i = 0; $i < $count; $i++){
            $where .= $columns[$i] . " LIKE '%" . $field . "%' OR ";
        }
    //The final where delection.
        $where = substr_replace($where, "", -3);
        $where .= ")";
    }    
    
    //Limit variable selected in the select input, if not set, the default amount is 10.
    $limit = isset($_POST["registros"]) ? $conn -> real_escape_string($_POST["registros"]) : 10;

    //Current pagina variable, the default value is 0.
    $pagina = isset($_POST["pagina"]) ? $conn -> real_escape_string($_POST["pagina"]) : 0;
    
    //If there is no pagina.
    if(!$pagina) {
        $inicio = 0;
        $pagina = 1;
    } else {
        $inicio = ($pagina - 1) * $limit;
    }
    
    //Query to select the data to be shown on the index page.
    $sLimit = "LIMIT $inicio, $limit"; 

    $sql = "SELECT SQL_CALC_FOUND_ROWS ". implode(", ", $columns) . " 
    FROM $table 
    $where 
    $sLimit";

    //Count of the number of rows of the query
    $result = $conn->query($sql);
    $num_rows = $result-> num_rows;

    //Query for all the registers filtered

    $sqlFilter = "SELECT FOUND_ROWS()";
    $resFilter = $conn->query($sqlFilter);
    $row_filter =  $resFilter -> fetch_array();
    $totalFilters = $row_filter[0];

    //Query for all the registers filtered

    $sqlTotal = "SELECT count($id) FROM $table";
    $resTotal = $conn->query($sqlTotal);
    $row_total =  $resTotal -> fetch_array();
    $totalRegisters = $row_total[0];
    
    //Array with the totalRegisters, totalFilters, data and pagination info.
    $output = [];
    $output['totalRegisters'] = $totalRegisters;
    $output['totalFilters'] = $totalFilters;
    $output['data'] = '';
    $output['paginacion'] = '';

    //If there are results for the query , they are shown.
    if($num_rows > 0) {
        while($row = $result->fetch_assoc()){
            $output['data'] .= "<tr>";
            $output['data'] .= "<td >" .$row['tools']. "</td>";
            $output['data'] .= "<td>" .$row['color']. "</td>";
            $output['data'] .= "<td>" .$row['quantity']. "</td>";
            $output['data'] .= "<td>" .$row['description']. "</td>";
            $output['data'] .= "<td>" .date_format(date_create($row['fecha']), 'd/m/y'). "</td>";
            $output['data'] .= "<td>";
            $output['data'] .= "<a href='update.php?id=" .$row['id']. "' " ."class='btn btn-secondary my-sm-1 mx-md-1' title='Editar'><i class='fa-solid fa-pen'></i></a>";
            $output['data'] .= "<a href='delete.php?id=" .$row['id']. "' " ."class='btn btn-danger' title='Eliminar'><i class='fa-solid fa-trash'></i></a>";
            $output['data'] .= "</td>";
            $output['data'] .= "</tr>";
        }
    } else {
    //Else this message is shown.
        $output['data'] .= "<tr class='text-center'>";
        $output['data'] .= "<td colspan = '6'>No results</td>";
        $output['data'] .= "</tr>";
    }

    //If there is data, the amount of pages are calculated.
    if($output['totalRegisters'] > 0){
        $totalPaginas = ceil($output['totalRegisters'] / $limit);

    //The pagination buttons are shown.
        $output['paginacion'] .= "<nav>";
        $output['paginacion'] .= "<ul class='pagination'>";

    //First pagination button to be shown.
        $numeroInicio = 1;
        
        if(($pagina - 4) > 1) {
            $numeroInicio = $pagina - 4;
        }

    //Last pagination button to be shown.
        $numeroFin = $numeroInicio + 9;

    //If the last pagination number is higher than the total pages number, they're equal.
        if($numeroFin >  $totalPaginas) {
            $numeroFin =  $totalPaginas;
        }

    //Cycle for outputting the buttons of the pagination
        for($i=$numeroInicio; $i <= $numeroFin; $i++){

            if($pagina == $i){
                $output['paginacion'] .= "<li class='page-item active'><a class='page-link' href='#'>". $i ."</a></li>";
            } else {
                $output['paginacion'] .= "<li class='page-item'><a class='page-link' onclick='getData
                (". $i .")' href='#'>". $i ."</a></li>";
            }      

        }
    //Pagination tags are closed.
        $output['paginacion'] .= "</ul>";
        $output['paginacion'] .= "</nav>";
    }

    //Json file is encoded and echoed excluding especial characters.
    echo json_encode($output, JSON_UNESCAPED_UNICODE);

    //Closing the connection.
    $conn -> close();    
?>
