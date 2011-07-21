<?php

require_once 'jq-config.php';
// include the jqGrid Class
require_once "php/jqGrid.php";
// include the PDO driver class
require_once "php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
// We suppose that mytable exists in your database
$grid->SelectCommand = 'SELECT idNotificacion AS Codigo, subject AS Asunto, fechaNotificacion AS Fecha FROM notificacion';

// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('application/grids/buzonGrid.php');
// Set grid caption using the option caption
$grid->setGridOptions(array(
	"hoverrows"=>true,
    "caption"=>"Notificaciones",
    "rowNum"=>10,
    "sortname"=>"idNotificacion",
    "rowList"=>array(10,20,50)
));

// Change some property of the field(s)
$grid->setColProperty("Codigo", array("label"=>"Num.", "width"=>15));
$grid->setColProperty("Asunto", array("label"=>"Asunto", "width"=>90));
$grid->setColProperty("Fecha", array("label"=>"Fecha", "width"=>25));

// Run the script
$grid->renderGrid('#grid','#pager',true, null, null, true,true);

?>