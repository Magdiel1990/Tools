<?php
//Class for the dropdowns to choose (form selects) 
class dropdownSelection {
    public $column;
    public $order;
    public $value;

    function __construct ($column,$order,$value){
        $this -> column = $column;
        $this -> order = $order;
        $this -> value = $value;
    }
    
//Method for showing the info stored in the database as a dropdown. 
    function selectDropdown ($conn){
        $sql = "SELECT * FROM $this->column ORDER BY $this->order";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                //Output data of each row
                    while($row = $result->fetch_assoc()) {
                    $valueOption = $row[$this -> column];
                        echo "<option value='".$valueOption."'>".$row[$this->column]."</option>";
                    }
                }
        }
}

//Class for the color and location id selection.
class idSelection {
    public $id;
    public $table;
    public $condition;

    function __construct ($id, $table, $condition){
        $this -> id = $id;
        $this -> table = $table;
        $this -> condition = $condition;
    }
//Method for getting the ids.
    function idSelection($conn){
        $sql = "SELECT $this->id FROM $this->table WHERE $this->table = '$this->condition'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $newId = $row[$this -> id];
        return $newId;
    }
}
//Class for the fading alert message 
class alertButtons {
    public $buttonName;
    public $messageName;

    function __construct($buttonName, $messageName) {
        $this -> buttonName = $buttonName; 
        $this -> messageName = $messageName; 
    }
//Method for the message.
    function buttonMessage() {
        $html = "";
        if(isset($this -> buttonName)){
            $html .= "<div class='row justify-content-center'>";
            $html .= "<div class='col-auto'>";
            $html .= "<div class='alert alert-".$this -> buttonName." alert-dismissible fade show' role='alert'>";
            $html .= "<span>".$this -> messageName."</span>";
            $html .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <i class='fa-regular h6 text-secondary fa-circle-xmark'></i></button>";
            $html .= "</div>"; 
            $html .= "</div>";      
            $html .= "</div>";   
            echo $html;             
        }
    }

}
?>