<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Quickstart | Guide</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
.guide {
	font-size: 18px;
	color: #fff;
	font-weight: bold;
	background: darkgrey;
	padding-top: 10px;
	padding-bottom: 10px;
	/* margin-bottom: 30px; */
	margin-top: 0px;
	}
.sidebar-nav > .sidebar-brand {
	height: 100px;
	font-size: 18px;
	line-height: 100px;
	margin-bottom: 60px;
}	
.dropdown-menu {
	width: 100%;
}
.dropdown-menu>li>a {
	color: #666 !important;
}
</style>
</head>
<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("sidebar.php") ?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <article>
						<h1>Installation</h1>
						<p>Quickstart is a PHP object-oriented creator program. After setting the parameters of your project, Quickstart will generate the classes, action files and template pages you need. Quickstart does not use a database, but rather settings and project files so that it can be used without connecting to the project server. To create the class, action, and view files, connection to the project server is required. These are the different functions of Quickstart:
						<ol>
							<li>Download the latest quickstart version from the link on the menu</li>
							<li>Create a folder on your server (or locally) and extract to this folder.</li>
							<li>Edit the access.json file in the Quickstart root to change the password. Change the second parameter to the new password you want.</li>
							<li>Upload the files if remote.</li>							
							<li>Go to index.php from a browser and enter the password you created in the prompt. The login prompt should show up on the home page if you aren't local.</li>
						</ol>
						</p>
						
						</article>
													
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
