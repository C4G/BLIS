 <?php
#
# Shows confirmation for test type updation
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("catalog");
?>
<br>
<b><?php echo LangUtil::$pageTerms['TEST_TYPE_UPDATED']; ?></b>
 | <a href='catalog.php?show_t=1'>&laquo; <?php echo LangUtil::$pageTerms['CMD_BACK_TOCATALOG']; ?></a>
<br><br>
<?php 
$test_type = get_test_type_by_id($_REQUEST['tid']);
$page_elems->getTestTypeInfo($test_type->name); 
include("includes/footer.php");
?>