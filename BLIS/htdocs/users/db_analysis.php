<?php 
/*
Buea : cameroon : 129
bamenda : cameroon : 128
nphrel:ghana : 1006
kaneshie: ghana : 153
*/
include("redirect.php");

include("includes/header.php");
LangUtil::setPageId("home");



//echo "hi";
db_analysis_ratings(153);
//echo "<br>count=".$count;
?>

<?php
include("includes/footer.php");
?>