<!DOCTYPE html>
<html lang="en">
<head>
<title>Budgeting App</title>
 <link href="css/bootstrap.css" rel="stylesheet">
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/main.css">
<script src="js/bootstrap.min.js"></script>
</head>
<script>
    var jqSupported = false;
    $(document).ready(function(){


        if(window.location.hash == "#ccmanager") {
            $('#main_content').load('cardmanager.php');
            $(".nav").find(".active").removeClass("active");
            $("#card_manager").addClass("active");
        } else {
            $('#main_content').load('budget_overview.php');
        }

        $('.navbar_link').on('click', function(){;})

        $('.toplink').on('click', function(){
            var link = $(this).attr('href');
            var id = $(this).attr('data-id');

            var whereTo = $(this).attr('href');
            if (whereTo == "budget_overview.php") {
                window.location.hash = '';
            } else if(whereTo == "cardmanager.php") {
                window.location.hash = '#ccmanager';
            }

            $('#main_content').load(link);
            return false;
        });

        $(".nav a").on("click", function(){
           $(".nav").find(".active").removeClass("active");
           $(this).parent().addClass("active");
        });
    });

    //Auto Run
    if (typeof(Storage) !== "undefined") {
        if (localStorage.jsdbwa == null) {
            console.log("Initializing BWA array");
            var initBWA = [];
            initBWA.push({
                title: "Unnamed Budget Project"
            });
            initBWA.push({
                income_rows_num: 0
            });
            initBWA.push({
                expense_rows_num: 0
            });
            initBWA.push({
                income_rows: []
            });
            initBWA.push({
                expense_rows: []
            });
            initBWA.push({
                static_vals: [{
                        net_income: 0,
                        cc_mpmts: 0,
                        cc_balance: 0
                    }]
            });
            initBWA.push({
                cc_rows_num: 0
            });
            initBWA.push({
                cc_rows: []
            });
            localStorage.jsdbwa = JSON.stringify(initBWA);
            showls();
        }
    } else {
        alert("We are sorry, your device does not support localStorage. This application depends on it to save data.");
    }
    //End Auto Run

    window.onload = function() {
        pageInit();
    }

    function pageInit() {
        if (typeof jQuery == 'undefined') {
            alert("Your device does not support jQuery (or some other error)");
        } else {
            jqSupported = true;
        }

    }

</script>
<body>
    <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Budget Calculator App</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li data-id='1' class="active navbar_link" id="budget_overview"><a href="budget_overview.php" class="toplink">Budget Overview <span class="sr-only">(current)</span></a></li>
        <li data-id='2' class="navbar_link" id="card_manager"><a href="cardmanager.php" class="toplink">Credit Card Manager</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container-fluid">
<section id="main_content">

</section>
</div>
<footer>
<span id="footer_text">Copyright 2016 Just Some Devs.</span>
</footer>
</body>
</html>
