<?php session_start( );
print <<<HTML
	<html>
		<head><title>PDF Form Generator</title></head>
		<body>
			<form action='formpdf.php' method='post'>
				<input type='text' placeholder='Heading' name='PageHeading' value='Heading'/>
				<input type='text' placeholder='Link Text' name='PageLinkText' value='Link Text'/>
				<input type='text' placeholder='http://' name='PageLink' value='http://'/>
				<input type='text' placeholder='Mr. or Mrs.' name='Name' value='Mr. Mrs.'/>
				<input type='text' placeholder='04/23/2019' name='Date' value='04/23/2019'/>
				<input type='submit'/>
			</form>
		</body>
	</html>
HTML;
?>
