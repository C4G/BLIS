<?php


$directories = scandir('../../local');
foreach($directories as $directory){
	if($directory=='.' or $directory=='..' ){
		//echo 'dot';
	}else{
		if (strpos($directory,'test') !== false && is_dir("../../local/".$directory)) {
			copy("en.php","../../local/".$directory."/en.php");
			copy("en.xml","../../local/".$directory."/en.xml");
			copy("default.php","../../local/".$directory."/default.php");
			copy("default.xml","../../local/".$directory."/default.xml");
			copy("fr.php","../../local/".$directory."/fr.php");
			copy("fr.xml","../../local/".$directory."/fr.xml");
			echo $directory .'<br />';
		}
		
	}
}

?>