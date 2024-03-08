<?php

# TAKE NOTE!
# For this to work properly, you need to make sure that _all_ of these
# required files are not outputting anything to the browser.
# https://github.com/PHPOffice/PHPExcel/blob/1.8/Documentation/markdown/Overview/08-Recipes.md#http-headers
# Ensure that these files are _not_ encoded as "UTF-8 with BOM" (Byte Order Mark)
# since that also counts. They should be "UTF-8".
require_once("../includes/composer.php");
require_once("../includes/db_lib.php");
require_once("../includes/db_util.php");
require_once("../includes/user_lib.php");

$lab_id = intval($_REQUEST['lab_config_id']);
if (!$lab_id) {
    header('HTTP/1.1 404 Not Found', true, 404);
    echo "[]";
    exit;
}

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

$unauthorized = true;

if (is_super_admin($current_user) || is_country_dir($current_user)) {
    $unauthorized = false;
}

if ($unauthorized) {
    // If the user is not a super admin or country director, they should only
    // be able to access data for their own lab, and only if they are an admin.
    if (count($lab_ids) == 1 && $lab_ids[0] == $current_user->labConfigId && is_admin($current_user)) {
        $unauthorized = false;
    }
}

if ($unauthorized) {
    header('HTTP/1.1 401 Unauthorized', true, 401);
    echo "You do not have permission to view this page.";
    exit;
}


$lab_config = LabConfig::getById($_REQUEST['lab_config_id']);
$custom_field_list = $lab_config->getSpecimenCustomFields();

foreach($custom_field_list as $idx => $custom_field) {
    echo '{ "id": '.$custom_field->id.', "fieldName": "'.$custom_field->fieldName.'" }';
    if ($idx < count($output_fields) - 1) {
        echo ",\n";
    }
}

echo "\n]";
