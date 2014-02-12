<?php
#
# Main file for updating to new version
# Called from the update.php page
#

function directoryCopy( $source, $destination) 
{ 
    $dir = opendir($source); 
	
	if ( !is_dir($destination) )
		mkdir($destination); 
    
	while(false !== ( $file = readdir($dir)) ) 
	{ 
        if (( $file != '.' ) && ( $file != '..' )) 
		{ 
            if ( is_dir($source . '/' . $file) ) 
			{ 
                directoryCopy($source . '/' . $file,$destination . '/' . $file); 
            } 
            else 
			{ 
                copy($source . '/' . $file,$destination . '/' . $file); 
            } 
        } 
	} 
	
    closedir($dir); 
} 

try { 
	$today = date('mdy');
	$createDirCheck = true;

	if ( !file_exists("../../backup_".$today) )  {
		$createDirCheck = mkdir("../../backup_".$today);
		if ( $createDirCheck == true ) {
			if ( !file_exists("../../backup_".$today."/htdocs") ) 
				$createDirCheck = mkdir("../../backup_".$today."/htdocs");
		}
	}
		

	if ($createDirCheck == false) {
		echo "<p align='center' style='color:red;' >Backup failed. Cannot update!</p>";
	}

	else {
		$source = "../../htdocs";
		$destination = "../../backup_".$today."/htdocs";

		directoryCopy($source,$destination);

		$zip_dir = "../../";
		if( file_exists("../../htdocs.zip") ) { 
			$zip = zip_open( "../../htdocs.zip");
			if($zip) {
				while ( $zip_entry = zip_read($zip) ) {
					$file = zip_entry_name($zip_entry);
					
					
					if ( !( strstr($file,"CVS") || strstr($file,".settings") || strstr($file,"update/update.php") || strstr($file,"users/home.php") || strstr($file,"ajax/update.php") ) ) {
						if ( !is_dir($zip_dir.$file) ) {

							$fp = fopen($zip_dir.$file, "w+");
									
							if (zip_entry_open($zip, $zip_entry, "r")) {
								$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
								zip_entry_close($zip_entry);
							}
						
							fwrite($fp, $buf);
							if( $fp )
								fclose($fp);
						}
					}

				}
				zip_close($zip);
			}
			else {
				throw new Exception('File could not be opened');
			}
		} else {
			throw new Exception('Update not found');
		}
	}
	echo "true";
} catch (Exception $e) {
	echo $e;
}

?>