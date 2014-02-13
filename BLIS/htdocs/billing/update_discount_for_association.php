<?php
#
# Updates the discount for an test-bill association
#

include("../includes/db_lib.php");

$lab_config_id = $_SESSION['lab_config_id'];

$discount_type = $_REQUEST['sel'];
$discount_amount = $_REQUEST['amt'];
$discount_id = $_REQUEST['id'];

$assoc = BillsTestsAssociationObject::loadFromId($discount_id, $lab_config_id);

$assoc->setDiscountType($discount_type);
$assoc->setDiscountAmount($discount_amount);
$assoc->save($lab_config_id);

$bill = Bill::loadFromId($assoc->getBillId(), $lab_config_id);

echo json_encode(array("a" => format_number_to_money($assoc->getDiscountedTotal()), "b" => format_number_to_money($bill->getBillTotal($lab_config_id))));

?>