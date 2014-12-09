<?php

class CustomFieldOrderGeneration_Patient{
	public static $page_elems = null;
	public static function init(){
		if(is_null(self::$page_elems)){
			self::$page_elems = new PageElems();
		}
	}
	
	public static function generate_patient_custom_fields($custom_field_obj){
		echo "<tr valign='top'><td>";
		 echo $custom_field_obj->fieldName; 
		 echo "</td><td>";
		 CustomFieldOrderGeneration_Patient::$page_elems->getCustomFormField($custom_field_obj);
		 echo "</td></tr>";
	}
	public static function generate_patient_Id(){
		if($_SESSION['user_level'] != 17) {
			print "<tr ";
				
		if($_SESSION['pid'] == 0)
			echo " style='display:none;' ";
			echo " ><td>";
				echo LangUtil::$generalTerms['PATIENT_ID']; 
				if($_SESSION['pid'] == 2 || $_SESSION['pid'] == 4)
					CustomFieldOrderGeneration_Patient::$page_elems->getAsterisk();
			
			echo "</td>
			<td><input type='text' name='pid' id='pid' value='' size='20' class='uniform_width' /></td>
		</tr>";
		}
	}
	
	public static function generate_patient_rdate(){ 
		echo"
		<tr>
			<td>Date of Registration</td>
			<td>";

			$today1 = date("Y-m-d");
			$today_array1 = explode("-", $today1);
			$name_list1 = array("receipt_yyyy", "receipt_mm", "receipt_dd");
			$id_list1 = array("receipt_yyyy", "receipt_mm", "receipt_dd");
			$value_list1 = array($today_array1[0], $today_array1[1], $today_array1[2]);
			CustomFieldOrderGeneration_Patient::$page_elems->getDatePicker($name_list1, $id_list1, $value_list1, true);
			echo "</td>
		</tr>";
	}

	public static function generate_patient_addl(){ 
		if($_SESSION['user_level'] != 17) {
		echo "<tr ";
		if($_SESSION['p_addl'] == 0)
			echo " style='display:none;' ";
		echo "><td>". LangUtil::$generalTerms['ADDL_ID'];
		if($_SESSION['p_addl'] == 2)
				CustomFieldOrderGeneration_Patient::$page_elems->getAsterisk();
		echo "</td>
		<td><input type='text' name='addl_id' id='addl_id' value='' size='20' class='uniform_width' /></td>
		</tr>";
		}
	}
	
	public static function generate_patient_dailynum(){ 
		$daily_num = get_daily_number_registration();
		echo "<tr ";
		if( is_numeric($_SESSION['dnum']) && $_SESSION['dnum'] == 0 )
			echo " style='display:none;' ";
		echo "><td>";
		echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; 
		if($_SESSION['dnum'] == 2)
					CustomFieldOrderGeneration_Patient::$page_elems->getAsterisk();
		echo "</td>
			<td><input type='text' name='dnum' id='dnum' value='". $daily_num."' size='20' class='uniform_width' /></td>
		</tr>";
	}
	
	public static function generate_patient_name(){ 
		echo "<tr ";
		if($_SESSION['pname'] == 0)
			echo " style='display:none;' ";
		echo ">	<td>";
		echo LangUtil::$generalTerms['NAME'] ;
		if($_SESSION['pname'] > 0)
			CustomFieldOrderGeneration_Patient::$page_elems->getAsterisk();
		echo "</td>
			<td><input type='text' name='name' id='name' value='' size='20' class='uniform_width' /></td>
		</tr>";
	}
	
	public static function generate_patient_sex(){
		echo "<tr ";
		if($_SESSION['sex'] == 0)
			echo " style='display:none;' ";
		echo ">
		<td>";
		echo LangUtil::$generalTerms['GENDER']; 
		CustomFieldOrderGeneration_Patient::$page_elems->getAsterisk();
		echo "</td>
			<td>
				<INPUT TYPE=RADIO NAME='sex' id='sex' VALUE='M' checked>";
				echo LangUtil::$generalTerms['MALE'];
				echo "<INPUT TYPE=RADIO NAME='sex' VALUE='F'>";
				echo LangUtil::$generalTerms['FEMALE'];
			echo "<br>
			</td>
		</tr>";
	}
	
	public static function generate_patient_age(){
		echo "<tr>";
		if($_SESSION['age'] == 0)
			echo " style='display:none;' ";
		
		echo "<td>";
		echo LangUtil::$generalTerms['AGE'];
			if($_SESSION['age'] == 2)
				CustomFieldOrderGeneration_Patient::$page_elems->getAsterisk();
		
		echo "</td>
		<td>
		<font style='color:red'>";
		echo LangUtil::$pageTerms['TIPS_DOB_AGE'];echo "</font>
			<input type='text' name='age' id='age' value='' size='4' maxlength='10' class='uniform_width' />
			
			<select name='age_param' id='age_param'>";
			echo "
				<option value='1'>"; echo LangUtil::$generalTerms['YEARS']; echo "</option>
				<option value='2'>"; echo LangUtil::$generalTerms['MONTHS']; echo "</option>
				<option value='3'>"; echo LangUtil::$generalTerms['DAYS']; echo "</option>
				<option value='4'>Weeks</option>
				<option value='5'>Range(Years)</option>
			</select>
			
		</td>
	</tr>";
	
	}
	
	public static function generate_patient_dob(){
		echo "<tr valign='top'";
		if($_SESSION['dob'] == 0)
			echo " style='display:none;' ";
		echo ">	
		<td>";
		echo LangUtil::$generalTerms['DOB']; 
			if($_SESSION['dob'] == 2)
				CustomFieldOrderGeneration_Patient::$page_elems->getAsterisk();
		echo "
		</td>
		<td> ";
		$name_list = array("yyyy", "mm", "dd");
		$id_list = $name_list;
		$value_list = array("", "", "");
		CustomFieldOrderGeneration_Patient::$page_elems->getDatePicker($name_list, $id_list, $value_list); 
		echo "
			</td>
		</tr>";
	}
	
}
?>