<?php
if (!function_exists('getFieldValue')) {
    function getFieldValue($field_id,$previous_daily_num="") {
        global $patient;
        $retval="";
        
        switch ($field_id) {
            case 0:	
                $retval=$patient->getSurrogateId();		
            break;
            case 1:
                $retval=$previous_daily_num;
            break;
            case 2:
                $retval=$patient->getAddlId();
            break;
            case 3:
                $retval=$patient->sex;
            break;
            case 4:
                $retval=$patient->getAge();
            break;
            case 5:
                $retval=$patient->getDob();
            break;
            case 6:
                $retval=$patient->name;
            break;
            case 7:
            break;
            case 8:
                $retval=$patient->regDate;
            break;
            case 9:
                $retval='<div id="patientBarcode"></div>';
            break;
            case 10:
            break;
            
            default:
            $retval="-";
            
        }
        return $retval;
    }
}
?>