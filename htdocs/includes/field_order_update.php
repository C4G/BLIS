<?php

//include("db_lib.php");



class field_order_update{

public static function getActualName($form_field_short_name){
$actual_name = "";
if($form_field_short_name == "pid"){
$actual_name = "Patient ID";
} else if($form_field_short_name == "pname"){
$actual_name = "Patient Name";
} else if($form_field_short_name == "sid"){
$actual_name = "Specimen ID";
} else if($form_field_short_name == "age"){
$actual_name = "Age";
} else if($form_field_short_name == "sex"){
$actual_name = "Sex";
} else if($form_field_short_name == "rdate"){
$actual_name = "Registration Date";
} else if($form_field_short_name == "refout"){
$actual_name = "Ref out";
} else if($form_field_short_name == "dnum"){
$actual_name = "Daily Number";
} else if($form_field_short_name == "dob"){
$actual_name = "Date Of Birth";
} else if($form_field_short_name == "patientAddl" || $form_field_short_name == "patientaddl"){
$actual_name = "Patient Addl ID";
} else if($form_field_short_name == "specimenaddl" || $form_field_short_name == "specimenAddl"){
$actual_name = "Specimen Addl ID";
} else if($form_field_short_name == "comm"){
$actual_name = "Comm";
} else if($form_field_short_name == "ageLimit"){
$actual_name = "Age Limit";
}

return $actual_name;
}


public static function getShortName($form_field_actual_name){
$short_name = "";
if($form_field_actual_name == "PatientID" || $form_field_short_name == "Patient ID"){
$short_name = "pid";
} else if($form_field_actual_name == "PatientName" || $form_field_actual_name == "Patient Name"){
$short_name = "pname";
} else if($form_field_actual_name == "Specimen ID" || $form_field_actual_name == "SpecimenID"){
$short_name = "sid";
} else if($form_field_actual_name == "Age"){
$short_name = "age";
} else if($form_field_actual_name == "Sex"){
$short_name = "sex";
} else if($form_field_actual_name == "Registration Date" || $form_field_actual_name == "RegistrationDate"){
$short_name = "rdate";
} else if($form_field_actual_name == "Ref out" || $form_field_actual_name == "Refout"){
$short_name = "rout";
} else if($form_field_actual_name == "Daily Number" || $form_field_actual_name == "DailyNumber"){
$short_name = "dnum";
} else if($form_field_actual_name == "Date Of Birth" || $form_field_actual_name == "DateOfBirth"){
$short_name = "dob";
} else if($form_field_actual_name == "Patient Addl ID" || $form_field_actual_name == "PatientAddlID"){
$short_name = "patientAddl";
} else if($form_field_actual_name == "Specimen Addl ID" || $form_field_actual_name == "SpecimenAddlID"){
$short_name = "specimenAddl";
} else if($form_field_actual_name == "Comm"){
$short_name = "comm";
} else if($form_field_actual_name == "Age Limit" || $form_field_actual_name == "AgeLimit"){
$short_name = "ageLimit";
}

return $short_name;
}

public static function install_first_order($lab_config, $formId){ 
	$field_ordering_for_curent_lab = FieldOrdering::getByFormId($_SESSION['lab_config_id'], $formId);
	
	if($field_ordering_for_curent_lab == null){
	// insert the order for the first time
	// 1. Get the current lab config info from the LabConfig Class
		//$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
		//$custom_field_list_patients = get_lab_config_patient_custom_fields($lab_config->id);
	// 2. Parse the object and populate the new fieldOrder Object
		//$fieldOrdering_new = new FieldOrdering();
		$field_ordering = new FieldOrdering();
		 // default values
		$field_ordering->form_id = $formId;
		$field_ordering->id = $_SESSION['lab_config_id'];
		
		$count = 1;
		
		$field_order = "";
		
		if($formId == 1){
			// pid
			if(isset($lab_config->pid) && $lab_config->pid > 0){
				//$field_ordering->{field.$count} = "Patient ID";
				$field_order = "Patient ID";
				$count++;
			}
			//p_addl
			if(isset($lab_config->patientAddl) && $lab_config->patientAddl> 0){
				//$field_ordering->{field.$count} = "Patient Addl ID";
				$field_order = $field_order.","."Patient Addl ID";
				$count++;
			}//dnum
			if(isset($lab_config->dailyNum) &&  $lab_config->dailyNum > 0){
				$field_ordering->{field.$count} = "Daily Number";
				$field_order = $field_order.","."Daily Number";
				$count++;
			}//pname
			if(isset($lab_config->pname) && $lab_config->pname > 0){
				//$field_ordering->{field.$count} = "Patient Name";
				$field_order = $field_order.","."Patient Name";
				$count++;
			}//sex
			if(isset($lab_config->sex) && $lab_config->sex> 0){
				//$field_ordering->{field.$count} = "Sex";
				$field_order = $field_order.","."Sex";
				$count++;
			}//age
			if(isset($lab_config->age) && $lab_config->age > 0){
				//$field_ordering->{field.$count} = "Age";
				$field_order = $field_order.","."Age";
				$count++;
			}//dob
			if(isset($lab_config->dob) && $lab_config->dob > 0){
				//$field_ordering->{field.$count} = "Date of Birth";
				$field_order = $field_order.","."Date of Birth";
				$count++;
			}
			
			$custom_field_list_patients = get_lab_config_patient_custom_fields($lab_config->id);
			
			foreach($custom_field_list_patients as $value){
				//$field_ordering->{field.$count} = $value->fieldName;
				$field_order = $field_order.",".$value->fieldName;
				$count++;
			}
		} 
		else if($formId == 2){
			// specimen field
			$field_order = "Specimen ID";
			//s_addl
			if(isset($lab_config->specimenAddl) && $lab_config->specimenAddl > 0){
				$field_order = $field_order.","."Specimen Additional ID";
				$count++;
			}
			//COMM
			if(isset($lab_config->comm) && $lab_config->comm > 0){
				$field_order = $field_order.","."Comments";
				$count++;
			}
			//rdate
			if(isset($lab_config->rdate) && $lab_config->rdate > 0){
				$field_order = $field_order.","."Lab Reciept Date";
				$count++;
			}
			
			//refout
			if(isset($lab_config->refout) && $lab_config->refout > 0){
				$field_order = $field_order.","."Referred Out";
				$count++;
			}
			
			//doctor
			if(isset($lab_config->doctor) && $lab_config->doctor > 0){
				$field_order = $field_order.","."Physician";
				$count++;
			}
			
			$custom_field_list_specimen = get_lab_config_specimen_custom_fields($lab_config->id);
				
			foreach($custom_field_list_specimen as $value){
				//$field_ordering->{field.$count} = $value->fieldName;
				$field_order = $field_order.",".$value->fieldName;
				$count++;
			}
			
		}
		
		
		
		/* //agelimit
		if(isset($lab_config->agelimit) && $lab_config->agelimit > 0){
		    $field_ordering->{field.$count} = "Age Limit";
			$count++;
		} */
	
	// 3. Insert the newly created order
		$field_ordering->form_field_inOrder = $field_order;
		FieldOrdering::add_fieldOrdering($field_ordering);
		$field_ordering_for_curent_lab = $field_ordering;
	}

	return $field_ordering_for_curent_lab;
} // install first order function ends
} // class field order update ends
?>