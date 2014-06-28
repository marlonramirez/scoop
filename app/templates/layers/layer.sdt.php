<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Codificación de la pagina a utf-8 para que admita caracteres especiales --><meta charset="utf-8" />
	<!-- Referencia a los datos del autor y material utilizado -->
	<link rel="author" href="{ROOT}public/humans.txt" />
	<!-- Visualización en cualquier dispositivo utilizando responsive disign -->
	<meta name="viewport" content="width=device-width">
	<!-- Icono de la aplicación -->
	<link rel="shortcut icon" type="image/x-icon" href="{ROOT}public/favicon.ico" />
	<!-- Enlace a la hoja de estilos general -->
	<link rel="stylesheet" href="{ROOT}public/css/project.scoop.min.css" />
	<!-- trabajar las rutas absolutas dentro de javascript -->
	<script type="text/javascript">
	var root = "{ROOT}";
	</script>
	<script src="{ROOT}public/js/project.scoop.min.js"></script>
	<!-- Titulo de la pagina -->
	<title>{$title}</title>
</head>

<body>
	<a href="https://github.com/mirdware/scoop" target="_blank">
		<img style="position: absolute; top: 0; left: 0; border: 0;" src="https://camo.githubusercontent.com/c6625ac1f3ee0a12250227cf83ce904423abf351/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f6c6566745f677261795f3664366436642e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_left_gray_6d6d6d.png"/>
	</a>
	<div id="main">
		{$view->msg}
		@output
	</div>
	<footer>
	</footer>
</body>
</html>