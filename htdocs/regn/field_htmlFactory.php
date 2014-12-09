<?php

include_once("generate_customize_field_order_patient.php");

include_once("../includes/db_lib.php");

class field_htmlFactory{
	
	static $custom_field_list = null;
	static $custom_field_name_array = array();
	
		
	public function generateHTML($fieldName){
		if(self::$custom_field_list == null){
			self::$custom_field_list = get_custom_fields_patient();
			foreach(self::$custom_field_list as $custom_field)
			{	
				if(($custom_field->flag)==NULL)
				{
					array_push(self::$custom_field_name_array,$custom_field->fieldName);
				}
			}
		}
		
		if($fieldName == "pid"|| $fieldName == "Patient ID"){
			CustomFieldOrderGeneration_Patient::generate_patient_Id(); 
		} else if($fieldName == "patientaddl" || $fieldName == "patientAddl" || $fieldName == "Patient Addl ID" ) {
			CustomFieldOrderGeneration_Patient::generate_patient_addl(); 
		} else if($fieldName == "rdate" ||  $fieldName == "Registration Date") {
			//CustomFieldOrderGeneration_Patient::generate_patient_rdate(); 
		} else if($fieldName == "dnum" ||  $fieldName == "Daily Number") {
			CustomFieldOrderGeneration_Patient::generate_patient_dailynum(); 
		} else if($fieldName == "pname" ||  $fieldName == "Patient Name") {
			CustomFieldOrderGeneration_Patient::generate_patient_name(); 
		} else if($fieldName == "sex" ||  $fieldName == "Sex") {
			CustomFieldOrderGeneration_Patient::generate_patient_sex(); 
		} else if($fieldName == "age" ||  $fieldName == "Age") {
			CustomFieldOrderGeneration_Patient::generate_patient_age(); 
		} else if($fieldName == "dob" ||  $fieldName == "Date of Birth") {
			CustomFieldOrderGeneration_Patient::generate_patient_dob(); 
		} 
		
		
		
		else if(in_array($fieldName, self::$custom_field_name_array) ){
			
			$custom_field_obj = get_custom_fields_patient_by_name($fieldName);
			CustomFieldOrderGeneration_Patient::generate_patient_custom_fields($custom_field_obj);
		}
		

			
		
		
	}

}


class field_htmlFactory_specimen{

	static $custom_field_list = null;
	static $custom_field_name_array = array();


	public function generateHTML($fieldName){
		if(self::$custom_field_list == null){
			self::$custom_field_list = get_custom_fields_specimen();
			foreach(self::$custom_field_list as $custom_field)
			{
				if(($custom_field->flag)==NULL)
				{
					array_push(self::$custom_field_name_array,$custom_field->fieldName);
				}
			}
		}

		if($fieldName == "specimenId"|| $fieldName == "Specimen ID"){
			CustomFieldOrderGeneration_Patient::generate_patient_Id();
		} else if($fieldName == "comm" || $fieldName == "Comments" ) {
			CustomFieldOrderGeneration_Patient::generate_patient_addl();
		} else if($fieldName == "Lab Reciept Date" ||  $fieldName == "rdate") {
			//CustomFieldOrderGeneration_Patient::generate_patient_rdate();
		} else if($fieldName == "refout" ||  $fieldName == "Referred Out") {
			CustomFieldOrderGeneration_Patient::generate_patient_dailynum();
		} else if($fieldName == "doctor" ||  $fieldName == "Physician") {
			CustomFieldOrderGeneration_Patient::generate_patient_name();
		} 



		else if(in_array($fieldName, self::$custom_field_name_array) ){
				
			$custom_field_obj = get_custom_fields_patient_by_name($fieldName);
			CustomFieldOrderGeneration_Patient::generate_patient_custom_fields($custom_field_obj);
		}


			


	}

}

class field_htmlFactoryDoctor{

	static $custom_field_list = null;
	static $custom_field_name_array = array();


	public function generateHTML($fieldName){
		if(self::$custom_field_list == null){
			self::$custom_field_list = get_custom_fields_patient();
			foreach(self::$custom_field_list as $custom_field)
			{
				if(($custom_field->flag)==NULL)
				{
					array_push(self::$custom_field_name_array,$custom_field->fieldName);
				}
			}
		}

		if($fieldName == "pid"|| $fieldName == "Patient ID"){
			CustomFieldOrderGeneration_Patient::generate_patient_Id();
		} else if($fieldName == "patientaddl" || $fieldName == "patientAddl" || $fieldName == "Patient Addl ID" ) {
			CustomFieldOrderGeneration_Patient::generate_patient_addl();
		} else if($fieldName == "rdate" ||  $fieldName == "Registration Date") {
			//CustomFieldOrderGeneration_Patient::generate_patient_rdate();
		} else if($fieldName == "dnum" ||  $fieldName == "Daily Number") {
			CustomFieldOrderGeneration_Patient::generate_patient_dailynum();
		} else if($fieldName == "pname" ||  $fieldName == "Patient Name") {
			CustomFieldOrderGeneration_Patient::generate_patient_name();
		} else if($fieldName == "sex" ||  $fieldName == "Sex") {
			CustomFieldOrderGeneration_Patient::generate_patient_sex();
		} 



		else if(in_array($fieldName, self::$custom_field_name_array) ){
				
			$custom_field_obj = get_custom_fields_patient_by_name($fieldName);
			CustomFieldOrderGeneration_Patient::generate_patient_custom_fields($custom_field_obj);
		}


			


	}

}
?>
