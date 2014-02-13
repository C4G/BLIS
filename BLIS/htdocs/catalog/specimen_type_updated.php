<?php
#
# Shows confirmation for specimen type updation
#
include("redirect.php");
include("includes/header.php"); 
LangUtil::setPageId("catalog");
?>
<br>
<b><?php echo LangUtil::$pageTerms['SPECIMEN_TYPE_UPDATED']; ?></b>
 | <a href='catalog.php?show_s=1'>&laquo; <?php echo LangUtil::$pageTerms['CMD_BACK_TOCATALOG']; ?></a>
<br><br>
<?php 
$specimen_type = get_specimen_type_by_id($_REQUEST['sid']);
$page_elems->getSpecimenTypeInfo($specimen_type->name); 
include("includes/footer.php");
?>