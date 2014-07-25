<?php

	require_once("Core/Function/start.php");
	require_once("Config/Lite.php");

	$config = new Config_Lite("/home/tryy3/Control_Panel/Config/config.ini");
	$start = new Start();


	if (isset($_POST["Start"]))
	{
		$id = $config->get("Server", "ID");
		$start_server = $start->start_server($id);
	}

	if (isset($_POST["Stop"]))
	{
		$id = $config->get("Server", "ID");
		$stop = $start->stop($id);
	}

	if (isset($_POST["Restart"]))
	{
		$id = $config->get("Server", "ID");
		$restart = $start->restart($id);
	}

	if (isset($_POST["Command"]))
	{
		$id = $config->get("Server", "ID");
		$command = $start->command($id, $_POST["Command"]);
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Homepage</title>
		<!-- AwesomeFont -->
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

		<!-- Bootstrap -->
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

		<!-- Boostrap Theme -->
		<link href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/cyborg/bootstrap.min.css" rel="stylesheet">
        
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>

		<!-- jQuery Migrate -->
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

        <!-- jQuery UI -->
        <link rel="stylesheet" href="style/jquery-ui.css">
        <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
        
		<!-- jQuery DataTables -->
        <script src="http://www.datatables.net/download/build/jquery.dataTables.js"></script>

		<style>
			#responsecontainer {
				background-color: #FFF;
				color: gray;
			}

			input {
				color: gray;
			}
		</style>
	
		<script>
            var log = "log.php";
            //var info = "core/func/info_table.php";

            $(document).ready(function() {

                $("#responsecontainer").load(log);
                //$("#info_table").load(info);

                $('#log_area').dataTable( {
                    "sScrollY": "400px",
                    "bPaginate": false,
                    "bFilter": false,
                    "bInfo": false
                } );

                setInterval(function(response, status, xhr) {
                	if (status == "error")
                	{
                		alert("Error: " + xhr.status + " " + xhr.statusText);
                	}
                    $("#responsecontainer").load(log);
                    //$("#info_table").load(info);
                }, 50);

                $.ajaxSetup({ cache: false });
            });
        </script>
	</head>
	<body>
<?php include "Pages/navbar.php" ?>

		<div class="container">
            <div class="page-header">
                <h1>Raptr Minecraft Control panel!</h1>
            </div>

            <?php if( isset( $Error ) ): ?>
                <div class="alert alert-warning">
                    <h4 class="alert-heading">Exception:</h4>
                    <?php echo htmlspecialchars( $Error ); ?>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
	                            <tr>
	                                <th style="text-align:center;font-size:17px">Console</th>
	                            </tr>
	                        </thead>
	                    </table>
	                </div>
	            </div>

	            <div class="row">
	                <div class="col-md-9">
                        <table class="table table-bordered table-striped" id="log_area">
                        	<thead>
                        		<tr>
                        			<th>
                        			</th>
                        		</tr>
                        	</thead>
	                        <tbody>
	                            <tr>
	                                <td>
	                                    <div id="responsecontainer"></div>
	                                </td>
	                            </tr>
	                        </tbody>
	                    </table>
                    </div>

                    <div class="col-md-3">
                        <table class="table table-bordered">
	                    	<tbody>
	                    		<tr>
		                        	<td>
		                        		<div class="row">
				                        	<div class="col-md-3 col-md-offset-1">
				                        		<form action="" method="post" role="form" style="margin:0px">
				                        			<button type="submit" value="start" name="Start" class="btn btn-primary">Start</button>
				                        		</form>
				                        	</div>

				                        	<div class="col-md-3">
				                        		<form action="" method="post" role="form" style="margin:0px">
				                        			<button type="submit" value="Stop" name="Stop" class="btn btn-primary">Stop</button>
				                        		</form>
			                        		</div>

				                        	<div class="col-md-3">
				                        		<form action="" method="post" role="form" style="margin:0px">
				                        			<button type="submit" value="Restart" name="Restart" class="btn btn-primary">Restart</button>
				                        		</form>
				                        	</div>
			                        	</div>
		                        	</td>
		                        </tr>

	                    		<tr>
		                            <td>
		                                <form class="form-inline" action="admin.php" method="post">
		                                    <label>
		                                        <input type="text" id="Command" name="Command" class="input-xlarge" placeholder= <?php echo "'Command'"; ?> >
		                                    </label>
		                                    <button class="btn btn-primary">Send</button>
		                                </form>
		                            </td>
		                        </tr>

		                        <tr>
		                            <td>
		                                <form class="form-inline" action="admin.php" method="post">
		                                    <label>
		                                        <input type="text" id="Chat_Message" name="Chat_Message" class="input-xlarge" placeholder= <?php echo "'message'"; ?> >
		                                    </label>
		                                    <button class="btn btn-primary">Send</button>
		                                </form>
		                            </td>
		                        </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
            <?php for($i = 0; $i < 20; $i++) { echo "<br>"; } ?>
		<?php include "Pages/footer.php" ?>
	</body>
</html>