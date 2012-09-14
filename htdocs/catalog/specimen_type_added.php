<?php
#
# Shows confirmation for new specimen type addition
#
include("redirect.php");
include("includes/header.php"); 
LangUtil::setPageId("catalog");
?>
<br>
<b><?php echo LangUtil::$pageTerms['SPECIMEN_TYPE_ADDED']; ?></b>
 | <a href='catalog.php?show_s=1'>&laquo; <?php echo LangUtil::$pageTerms['CMD_BACK_TOCATALOG']; ?></a>
<br><br>
<?php 
$page_elems->getSpecimenTypeInfo($_REQUEST['sn'], true);
include("includes/footer.php");
?>