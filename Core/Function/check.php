<?php
	Error_Reporting( E_ALL | E_STRICT );
	Ini_Set( 'display_errors', true );

	include('/home/tryy3/Control_Panel/Core/Class/status.php');

	$array = array(
		"192.99.5.178:33333",
		"192.99.5.178:25568"
		);

	$newArray = array();

	$file = "test.txt";

	foreach ($array as $key => $value) {
		$serverArray = explode(':', $value);

		$Info = false;
		$Query = null;
		
		try
		{
			$Query = new MinecraftPing( $serverArray[0], $serverArray[1], 1 );
			
			$Info = $Query->Query( );
			
			if( $Info === false )
			{
				/*
				 * If this server is older than 1.7, we can try querying it again using older protocol
				 * This function returns data in a different format, you will have to manually map
				 * things yourself if you want to match 1.7's output
				 *
				 * If you know for sure that this server is using an older version,
				 * you then can directly call QueryOldPre17 and avoid Query() and then reconnection part
				 */
				
				$Query->Close( );
				$Query->Connect( );
				
				$Info = $Query->QueryOldPre17( );
			}
		}
		catch( MinecraftPingException $e )
		{
			$Exception = $e;
		}
		
		if( $Query !== null )
		{
			$Query->Close( );
		}

		if (isset($e))
		{
			$newArray[$value] = "[RED]Offline";
		}
		else
		{
			$newArray[$value] = "[GREEN]Online";
		}

	}
	
	$handle = fopen($file, 'w+');

	foreach ($newArray as $key => $value)
	{
		fwrite($handle, $key . " " . $value . "\n");
	}

?>