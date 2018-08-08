<?php

include("../includes/db_lib.php");

$lab_config_id = $_REQUEST['lab_config_id'];

# test report config

if($_REQUEST['rage'] == 'y')
{
    # Group by age slots enabled
    $byAge = 1;
    $age_lower_list = $_REQUEST['age_l'];
    $age_upper_list = $_REQUEST['age_u'];
    $age_slot_string = "";
    for($i = 0; $i < count($age_lower_list); $i++)
    {
        if
        (
            trim($age_lower_list[$i]) === "" || 
            trim($age_upper_list[$i]) === "" || 
            is_nan($age_lower_list[$i]) ||
            (trim($age_upper_list[$i]) != "+" && is_nan($age_upper_list[$i]))
        )
        {
            # Invalid/empty age slot: Ignore
            continue;
        }
        $age_slot_string .= $age_lower_list[$i].":".$age_upper_list[$i];
        if($i < count($age_lower_list) - 1)
        {
            $age_slot_string .= ",";
        }
    }
    $ageGroups = $age_slot_string;
}
else 
{
    # Group by age slots not selected
    $byAge = 0;
        $age_lower_list = $_REQUEST['age_l'];
    $age_upper_list = $_REQUEST['age_u'];
    $age_slot_string = "";
    for($i = 0; $i < count($age_lower_list); $i++)
    {
        if
        (
            trim($age_lower_list[$i]) === "" || 
            trim($age_upper_list[$i]) === "" || 
            is_nan($age_lower_list[$i]) ||
            (trim($age_upper_list[$i]) != "+" && is_nan($age_upper_list[$i]))
        )
        {
            # Invalid/empty age slot: Ignore
            continue;
        }
        $age_slot_string .= $age_lower_list[$i].":".$age_upper_list[$i];
        if($i < count($age_lower_list) - 1)
        {
            $age_slot_string .= ",";
        }
    }
    $ageGroups = $age_slot_string;
}

if($_REQUEST['rgender'] == 'y')
{
    # Group by gender enabled
    $byGender = 1;
}
else
{
    # Group by gender not selected
    $byGender = 0;
}

if($_REQUEST['rsection'] == 'y')
{
    # Group by gender enabled
    $bySection = 1;
}
else
{
    # Group by gender not selected
    $bySection = 0;
}

if($_REQUEST['rcombo'] == 1)
{
    # Group by gender enabled
    $combo = 1;
}
else if($_REQUEST['rcombo'] == 2)
{
    # Group by gender enabled
    $combo = 2;
}
else
{
    # Group by gender not selected
    $combo = 3;
}

//The following are tests added for filtering on the age unit selected.
if($_REQUEST['age_unit'] == 'years')
{
    $age_unit = 1;
}
else if($_REQUEST['age_unit'] == 'months')
{
    $age_unit = 2;
}
else if($_REQUEST['age_unit'] == 'weeks')
{
    $age_unit = 3;
}
else
{
    $age_unit = 4;
}


# Specimen report config

if($_REQUEST['sp_rage'] == 'y')
{
    # Group by age slots enabled
    $sp_byAge = 1;
    $age_lower_list = $_REQUEST['sp_age_l'];
    $age_upper_list = $_REQUEST['sp_age_u'];
    $age_slot_string = "";
    for($i = 0; $i < count($age_lower_list); $i++)
    {
        if
        (
            trim($age_lower_list[$i]) === "" || 
            trim($age_upper_list[$i]) === "" || 
            is_nan($age_lower_list[$i]) ||
            (trim($age_upper_list[$i]) != "+" && is_nan($age_upper_list[$i]))
        )
        {
            # Invalid/empty age slot: Ignore
            continue;
        }
        $age_slot_string .= $age_lower_list[$i].":".$age_upper_list[$i];
        if($i < count($age_lower_list) - 1)
        {
            $age_slot_string .= ",";
        }
    }
    $sp_ageGroups = $age_slot_string;
}
else 
{
    # Group by age slots not selected
    $sp_byAge = 0;
    $age_lower_list = $_REQUEST['sp_age_l'];
    $age_Fupper_list = $_REQUEST['sp_age_u'];
    $age_slot_string = "";
    for($i = 0; $i < count($age_lower_list); $i++)
    {
        if
        (
            trim($age_lower_list[$i]) === "" || 
            trim($age_upper_list[$i]) === "" || 
            is_nan($age_lower_list[$i]) ||
            (trim($age_upper_list[$i]) != "+" && is_nan($age_upper_list[$i]))
        )
        {
            # Invalid/empty age slot: Ignore
            continue;
        }
        $age_slot_string .= $age_lower_list[$i].":".$age_upper_list[$i];
        if($i < count($age_lower_list) - 1)
        {
            $age_slot_string .= ",";
        }
    }
    $sp_ageGroups = $age_slot_string;
}

if($_REQUEST['sp_rgender'] == 'y')
{
    # Group by gender enabled
    $sp_byGender = 1;
}
else
{
    # Group by gender not selected
    $sp_byGender = 0;
}


    $sp_bySection = 0;

//The following are tests added for filtering on the age unit selected.
if($_REQUEST['sp_age_unit'] == 'years')
{
    $sp_age_unit = 1;
}
else if($_REQUEST['sp_age_unit'] == 'months')
{
    $sp_age_unit = 2;
}
else if($_REQUEST['sp_age_unit'] == 'weeks')
{
    $sp_age_unit = 3;
}
else
{
    $sp_age_unit = 4;
}
$sp_combo = 1;
$tc_id = 9999009;
$sc_id = 9999019;
updateGroupedReportsConfigCountryDir($byAge, $byGender, $ageGroups, $bySection, $combo, $tc_id, $age_unit, $lab_config_id);
updateGroupedReportsConfigCountryDir($sp_byAge, $sp_byGender, $sp_ageGroups, $sp_bySection, $sp_combo, $sc_id, $sp_age_unit, $lab_config_id);

?>
