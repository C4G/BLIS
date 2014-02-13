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
 | <a href='country_catalog.php?show_t=1'>&laquo; <?php echo LangUtil::$pageTerms['CMD_BACK_TOCATALOG']; ?></a>
<br><br>
<?php 
$testTypeMapping = TestTypeMapping::getById($_REQUEST['tid']);
$page_elems->getTestTypeInfoAggregate($testTypeMapping);
include("includes/footer.php");
?>