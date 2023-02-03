<?php
    //Including the database conenection.
    include ("db/db.php");
    

    $columns = ["id", "tools", "color", "quantity", "description", "fecha"];
    
    $table = "registersum";

    $id = "id";

    $field = isset($_POST["search"]) ? $conn -> real_escape_string($_POST["search"]) : null;
    
    /*Filter*/
    $where = "";

    if($field != null){
        $where = "WHERE (";

        $count = count($columns);
        for($i = 0; $i < $count; $i++){
            $where .= $columns[$i] . " LIKE '%" . $field . "%' OR ";
        }
        $where = substr_replace($where, "", -3);
        $where .= ")";
    }    
    
    /* Limit */
    $limit = isset($_POST["registros"]) ? $conn -> real_escape_string($_POST["registros"]) : 10;
    $pagina = isset($_POST["pagina"]) ? $conn -> real_escape_string($_POST["pagina"]) : 0;
    
    if(!$pagina) {
        $inicio = 0;
        $pagina = 1;
    } else {
        $inicio = ($pagina - 1) * $limit;
    }
    
    
    
    $sLimit = "LIMIT $inicio, $limit"; 

    $sql = "SELECT SQL_CALC_FOUND_ROWS ". implode(", ", $columns) . " 
    FROM $table 
    $where 
    $sLimit";

    $result = $conn->query($sql);
    $num_rows = $result-> num_rows;

    /*Query for all the registers filtered*/

    $sqlFilter = "SELECT FOUND_ROWS()";
    $resFilter = $conn->query($sqlFilter);
    $row_filter =  $resFilter -> fetch_array();
    $totalFilters = $row_filter[0];

    /*Query for all the registers filtered*/

    $sqlTotal = "SELECT count($id) FROM $table";
    $resTotal = $conn->query($sqlTotal);
    $row_total =  $resTotal -> fetch_array();
    $totalRegisters = $row_total[0];
    


    $output = [];
    $output['totalRegisters'] = $totalRegisters;
    $output['totalFilters'] = $totalFilters;
    $output['data'] = '';
    $output['paginacion'] = '';



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
        $output['data'] .= "<tr class='text-center'>";
        $output['data'] .= "<td colspan = '6'>No results</td>";
        $output['data'] .= "</tr>";
    }

    if($output['totalRegisters'] > 0){
        $totalPaginas = ceil($output['totalRegisters'] / $limit);
        $output['paginacion'] .= "<nav>";
        $output['paginacion'] .= "<ul class='pagination'>";

        $numeroInicio = 1;

        if(($pagina - 4) > 1) {
            $numeroInicio = $pagina - 4;
        }

        $numeroFin = $numeroInicio + 9;

        if($numeroFin >  $totalPaginas) {
            $numeroFin =  $totalPaginas;
        }

        for($i=$numeroInicio; $i <= $numeroFin; $i++){

            if($pagina == $i){
                $output['paginacion'] .= "<li class='page-item active'><a class='page-link' href='#'>". $i ."</a></li>";
            } else {
                $output['paginacion'] .= "<li class='page-item'><a class='page-link' onclick='getData
                (". $i .")' href='#'>". $i ."</a></li>";
            }      

        }

        $output['paginacion'] .= "</ul>";
        $output['paginacion'] .= "</nav>";
    }

    echo json_encode($output, JSON_UNESCAPED_UNICODE);

    //Closing the connection.
    $conn -> close();    
?>
