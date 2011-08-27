<html>
    <head>
        <title>PHOBOS - Usuarios</title>  
         <meta http-equiv="X-UA-Compatible" content="IE=8" >		    
        <link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
        <link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
        <link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />   
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
       
       <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
       
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/usuario.js"></script>
       
       
    </head>   
    <body>
        <div class="menuBar" style ="height: 54px">
             <ul>
               <?php echo $menu;?>
            </ul>         
        </div>
        
        <div id="loading" style="display:none; text-align:center">
			<span style = "color:white">Obteniendo datos ...</span>
			<div style="clear:both"></div>
			<img  src="<?php echo base_url(); ?>application/views/css/img/loading.gif"/>
		</div>
       
     <div class="sessionBar">
			<img id="systemIcon" src="<?php echo base_url(); ?>application/views/css/img/gears.png" />	
			<span id="systemName"><b>PHOBOS PLANING</b></span> 	
			<img id="logoutButton" title="Cerrar sesión" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span>
		</div>
       
        <div><span id="pageTittle"></span></div>
       
        <div class="container" style = "height : auto">
            <div style="height: 20px"></div>            
           
            <div class="divActions">               
                <div class="divCRUDRecords">
                    <span class = "recordsLabel">Usuario</span>
                    <input id="txtRecords" type="text"  value=""/><br>
                </div>
                           
                <div class="divCRUDButtons">
                    <button id="btnSave" onClick="save()">Guardar</button>
                    <button id="btnEdit" onClick="edit()">Editar</button>
                    <button id="btnDelete" onClick="deleteData()">Eliminar</button>
                    <button id="btnCancel" onClick="cancel()">Cancelar</button>

                </div>
            </div>
               
            <div id ="msgBox"></div>   
            <div id="tabs" style = "height: auto;">
                <ul>
                    <li><a href="#tabs-1">Información General</a></li>
                    <li><a href="#tabs-2">Roles</a></li>
                </ul>
                <div id="tabs-1" class="divDataForm" style="height: 860px">
                    <input id="idUsuario" type="hidden"  value="" class = "hiddenId"/>
                    <input id="idCargo" type="hidden"  value="" class = "hiddenId"/>
                    <input id="idDepto" type="hidden"  value="" class = "hiddenId"/>
                    <input id="accionActual" type="hidden"  value="" class = "hiddenId"/>               
                   
                    <span class = "requiredFieldLabel">Código empleado:</span>
                    <input id="txtUsuarioCodigo" type="text"  value="" class = "inputField" title = "Codigo empleado UCA" maxlength="10"/><br>
                               
                    <span class = "requiredFieldLabel">Primer nombre:</span>
                    <input id="txtUsuarioPrimerNombre" type="text"  value="" class = "inputField" title = "Primer nombre del usuario" maxlength="80"/><br>
                   
                    <span class = "inputFieldLabel">Otros nombres:</span>
                    <input id="txtUsuarioOtrosNombres" type="text"  value="" class = "inputField" title = "Otros nombres del usuario" maxlength="80"/><br>
                   
                    <span class = "requiredFieldLabel">Primer apellido:</span>
                    <input id="txtUsuarioPrimerApellido" type="text"  value="" class = "inputField" title = "Primer apellido del usuario " maxlength="80"/><br>
                   
                    <span class = "inputFieldLabel">Otros apellidos:</span>
                    <input id="txtUsuarioOtrosApellidos" type="text"  value="" class = "inputField" title = "Otros apellidos del usuario" maxlength="80"/><br>
                   
                    <span class = "requiredFieldLabel">Fecha nacimiento:</span>
                    <input id="txtProyectoFechaNacimiento" type="text"  value="" class = "jqcalendario" title = "Fecha nacimiento del usuario" readonly/><br>
                   
                    <span class = "requiredFieldLabel">Usuario sistema:</span>
                    <input id="txtUsuarioUserName" type="text"  value="" class = "inputField" title = "Nombre de usuario de sistema" maxlength="10"/><br>
   
                    <span class = "requiredFieldLabel">Contraseña:</span>
                    <input id="txtUsuarioPassword" type="password"  value="" class = "inputFieldPSW" title = "Contraseña para el usuario" maxlength="10"/><br>
                   
                    <span class = "requiredFieldLabel">Confirmar:</span>
                    <input id="txtUsuarioConfirmar" type="password"  value="" class = "inputFieldPSW" title = "Confirmación de contraseña" maxlength="10"/><br>
                   
                    <span class = "requiredFieldLabel">DUI:</span>
                    <input id="txtUsuarioDUI" type="text"  value="" class = "inputField" title = "Documento Unico de Identidad del usuario" maxlength="11"/><br>               
                   
                    <span class = "requiredFieldLabel">NIT:</span>
                    <input id="txtUsuarioNIT" type="text"  value="" class = "inputField" title = "Número de identificación tributaria" maxlength="17"/><br>
                   
                    <span class = "requiredFieldLabel">ISSS:</span>
                    <input id="txtUsuarioISSS" type="text"  value="" class = "inputField" title = "Número de afiliacion al ISSS" maxlength="9"/><br>
                   
                    <span class = "inputFieldLabel">NUP:</span>
                    <input id="txtUsuarioNUP" type="text"  value="" class = "inputField" title = "Número de afiliación de AFP" maxlength="12"/><br>
                   
                    <span class = "requiredFieldLabel">Departamento:</span>
                    <input id="txtUsuarioDepartamento" type="text"  value="" class = "inputField" title = "Departamento universitario al que pertenece" maxlength="256"/><br>
                   
                    <span class = "requiredFieldLabel">Cargo:</span>
                    <input id="txtUsuarioCargo" type="text"  value="" class = "inputField" title = "Cargo que desempeña en la universidad" maxlength="40"/><br>
                   
                    <span class = "inputFieldLabel">Carnet:</span>
                    <input id="txtUsuarioCarnet" type="text"  value="" class = "inputField" title = "Carnet de estudiante UCA" maxlength="10"/><br>
                   
                    <span class = "inputFieldLabel">E-mail personal:</span>
                    <input id="txtUsuarioEmailPersonal" type="text"  value="" class = "inputField" title = "Dirección de correo electronico personal" maxlength="40"/><br>
                   
                    <span class = "inputFieldLabel">E-mail institucional:</span>
                    <input id="txtUsuarioEmailInstitucional" type="text"  value="" class = "inputField" title = "Dirección de correo electronico institucional" maxlength="40"/><br>
                   
                    <span class = "inputFieldLabel">Teléfono contacto:</span>
                    <input id="txtUsuarioTelefono" type="text"  value="" class = "inputField" title = "Teléfono de contacto personal" maxlength="8"/><br>
                   
                    <span class = "inputFieldLabel">Extensi&oacute;n:</span>
                    <input id="txtUsuarioExtension" type="text"  value="" class = "inputField" title = "Extensión UCA" maxlength="5"/><br>
                   
                    <span class = "inputFieldLabel">Activo:</span>
                    <input id="chkUsuarioActivo" type="checkbox" value="1" title = "Checkear si el usuario esta activo en el sistema" class="inputCHK"/><br>
                </div>
                <div id="tabs-2" style="height: 260px" align="center">
                    <input id="idRol" type="hidden" value="" class = "hiddenId"/>
                    <div class = "gridView">
                        <table>
                            <tr>
                                <td>
                                    <table id="todosRoles" align="center"></table>
                                    <div id="pagerTR"></div>
                                </td>
                                <td>
                                    <div class="divLessOrMoreThan">
                                        <button id="btnMoreThan" onClick="agregarRol()"></button><br />
                                        <button id="btnLessThan" onClick="eliminarRol()"></button>
                                    </div>
                                </td>   
                                <td>
                                    <table id="list" align="center"></table>
                                    <div id="pager"></div>
                                </td>
                            </tr>               
                        </table>
                    </div>
                </div>
            </div>   
        </div>
       
    </body>
</html>