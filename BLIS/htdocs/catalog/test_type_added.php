<?php
#
# Shows confirmation for new test type addition
#
include("redirect.php");
include("includes/header.php"); 
LangUtil::setPageId("catalog");
?>
<br>
<b><?php echo LangUtil::$pageTerms['TEST_TYPE_ADDED']; ?></b>
 | <a href='catalog.php?show_t=1'>&laquo; <?php echo LangUtil::$pageTerms['CMD_BACK_TOCATALOG']; ?></a>
<br><br>
<?php $page_elems->getTestTypeInfo($_REQUEST['tn'], true); ?>
<?php include("includes/footer.php"); ?>