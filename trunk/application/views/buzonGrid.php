<?php

require_once 'jq-config.php';
// include the jqGrid Class
require_once "libraries/jqGrid.php";
// include the PDO driver class
require_once "libraries/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
// We suppose that mytable exists in your database
$grid->SelectCommand = 'SELECT idNotificacion AS Codigo, notificacion AS Mensaje, subject AS Asunto, fechaNotificacion AS Fecha FROM notificacion';

// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('buzonGrid.php');
// Set grid caption using the option caption
$grid->setGridOptions(array(
    "caption"=>"Notificaciones",
    "rowNum"=>10,
    "sortname"=>"idNotificacion",
    "rowList"=>array(10,20,50)
));

// Change some property of the field(s)
$grid->setColProperty("field1", array("label"=>"ID", "width"=>60));

// Run the script
$grid->renderGrid('#grid','#pager',true, null, null, true,true);

?>