<html>
<head>
<title>Test</title>
<link type="text/css"
	href="<?php echo base_url(); ?>application/views/css/humanity/jquery-ui-1.8.14.custom.css"
	rel="stylesheet" />
<link type="text/css"
	href="<?php echo base_url(); ?>application/views/css/style.css"
	rel="stylesheet" />
<link rel="stylesheet" type="text/css" media="screen"
	href="application/views/css/themes/redmond/jquery-ui-1.8.2.custom.css" />
<link rel="stylesheet" type="text/css" media="screen"
	href="application/views/css/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen"
	href="application/views/css/themes/ui.multiselect.css" />
<script type="text/javascript"
	src="<?php echo base_url(); ?>application/views/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript"
	src="<?php echo base_url(); ?>application/views/js/jquery-ui-1.8.14.custom.min.js"></script>
<script type="text/javascript"
	src="<?php echo base_url(); ?>application/views/js/buzon.js"></script>
<script type="text/javascript"
	src="application/grids/i18n/grid.locale-en.js"></script>
<script type="text/javascript"
	src="application/views/js/jquery.jqGrid.min.js"></script>

</head>
<body>
	<div class="menuBar">
		<ul>
			<li><span class="menu_button_to"><a href="http://www.google.com"><span
						class="menu_button_text">Dinamic</span>
				</a>
			</span>
			</li>
			<li class="highlight"><span class="menu_button_to"><a
					href="http://www.google.com"><span class="menu_button_text">Dinamic</span>
				</a>
			</span>
			</li>
			<li><span class="menu_button_to"><a href="http://www.google.com"><span
						class="menu_button_text">Dinamic</span>
				</a>
			</span>
			</li>
			<li><span class="menu_button_to"><a href="http://www.google.com"><span
						class="menu_button_text">Dinamic</span>
				</a>
			</span>
			</li>
		</ul>
	</div>

	<div class="sessionBar">
		<span id="sessionUser"></span>
	</div>

	<div>
		<span id="pageTittle"></span>
	</div>

	<div class="container">
		<div style="height: 20px"></div>
		<div id="msgBox"></div>

		<p align="center">
		<?php include "application/grids/buzonGrid.php"; ?>
		</p>
		<br>
		<div align="center">
			<button id="btnGet" onClick="load()">Ver Mensaje</button>
			<button id="btnCancel" onClick="cancel()">Ocultar</button>
		</div>

		<br><p align="center"><font size="5"><label id="subject" ></label></font></p>
		<div id="msg" class="divActions" align="center" style="display: none">
			<table border="0" width="300px">

				<tr>
					<td><textArea id="message" cols="35" rows="4" class="inputField"></textArea>
					</td>
				</tr>
			</table>
		</div>

	</div>

</body>
</html>
