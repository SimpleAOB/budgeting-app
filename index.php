<!DOCTYPE html>
<html>
<head>
<title>Budgeting App</title>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<script>
$(document).ready(function(){
	$('.navbar_link').on('click', function(){
		var link = $(this).attr('href');
		$('#main_content').load(link);
		return false;
	})
})

</script>
<body>
<header>
	<div id="logo"><h1>Budgeting App</h1></div>
	<div id="navbar">
		<a href="cardmanager.php" id="card_manager" class="navbar_link">Credit Card Manager</a>
		<a href="budget_overview.php" id="budget_overview" class="navbar_link">Budget Overview</a>
		
	</div>
</header>
<section id="main_content">

</section>
<footer>
<span id="footer_text">Copyright 2016 Just Some Devs.</span>
</footer>
</body>
</html>