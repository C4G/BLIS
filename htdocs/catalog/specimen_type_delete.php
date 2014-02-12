<?php
#
# Deletes a specimen type from DB
# Sets disabled flag to true instead of deleting the record
# This maintains info for samples that were linked to this specimen type previously
#

include("../includes/db_lib.php");

$saved_session = SessionUtil::save();
$saved_db = DbUtil::switchToGlobal();

$specimen_type_id = $_REQUEST['id'];
SpecimenType::deleteById($specimen_type_id);

DbUtil::switchRestore($saved_db);
SessionUtil::restore($saved_session);

header("Location: catalog.php?sdel");
?>
