<!DOCTYPE html>
<html>
	<head>
        @vite(['resources/js/app.js'])
	</head>

	<body>
        <div id="graph" style="width: 100%; height: 50%; overflow: scroll;"></div>
		<div id="editor" style="width:50%; height:45%; overflow: hidden;">
			<textarea id="text-editor" style="width:100%; height:100%; position: relative;"></textarea>
		</div>
	</body>
</html>