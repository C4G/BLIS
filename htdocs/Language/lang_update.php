<?php


$directories = scandir('../../local');
foreach($directories as $directory){
	if($directory=='.' or $directory=='..' ){
		//echo 'dot';
	}else{
		if (strpos($directory,'test') !== false && is_dir("../../local/".$directory)) {
			copy("en.php","../../local/".$directory."/en.php");
			copy("default.php","../../local/".$directory."/default.php");
			copy("fr.php","../../local/".$directory."/fr.php");
			echo $directory .'<br />';
		}
		
	}
}

?>