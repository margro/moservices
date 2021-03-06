#!/tmp/www/cgi-bin/php
<?php

define("settings","/usr/local/etc/mos/www/modules/iptvlist/settings.conf");
define("udpsettings","/usr/local/etc/mos/www/modules/iptvlist/udp_proxy.conf");
define("timezoneConfig","/usr/local/etc/mos/www/modules/iptvlist/iptvlist_timezone.php");

if( isset( $GLOBALS["HTTP_RAW_POST_DATA"] ) ) 
{
	echo $GLOBALS["HTTP_RAW_POST_DATA"];
	$doc = new DomDocument();
	$doc->loadXML( $GLOBALS["HTTP_RAW_POST_DATA"] );

	$elem = $doc->getElementsByTagName('version');
	if ( $elem->item(0)->getAttribute("value")  == "3" )
	{

		$elem = $doc->getElementsByTagName('Recordings');
		$path = $elem->item(0)->getAttribute("value");
		echo $path . "\n";
		file_put_contents( settings, $path );


		$elem = $doc->getElementsByTagName('UDPProxy');
		$udpproxy = $elem->item(0)->getAttribute("value");
		echo $udpproxy . "\n";
		file_put_contents( udpsettings, $udpproxy );

		$elem = $doc->getElementsByTagName('Timezone');
		$tz = $elem->item(0)->getAttribute("value");
		echo $tz . "\n";
		file_put_contents( timezoneConfig, "<?php\n\n/*\niptvlist created by Roman Lut aka hax.\n*/\n\ndate_default_timezone_set( '".$tz."' );\n\n?>" );
	
		echo "deleting .m3u..bak...\n";

		//delete all m3u.bak
		foreach (glob( "*.m3u.bak" ) as $filename) 
		{  	
			echo "delete:" . $filename . "\n";
			unlink( $filename );
		}
	
		echo "renaming .m3u to .m3u.bak...\n";
		//reame all m3u to m3u.bak
		foreach (glob( "*.m3u" ) as $filename) 
		{  	
			$newName = str_replace( ".m3u", ".m3u.bak", $filename );
			echo "rename:" . $filename . "->" . $newName . "\n";
			rename( $filename, $newName );
		}

		//delete all url.bak
		foreach (glob( "*.url.bak" ) as $filename) 
		{  	
			echo "delete:" . $filename . "\n";
			unlink( $filename );
		}
	
		echo "renaming .url to .url.bak...\n";
		//reame all url to url.bak
		foreach (glob( "*.url" ) as $filename) 
		{  	
			$newName = str_replace( ".url", ".url.bak", $filename );
			echo "rename:" . $filename . "->" . $newName . "\n";
			rename( $filename, $newName );
		}

	}
}
else
{
	echo "Parameters not specified.";
}

?>