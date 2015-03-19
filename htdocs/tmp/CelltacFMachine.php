<?php
 
class CelltacFMachine extends AbstractInstrumentor
{   

	protected $RESULTS_KEYS = array(
		        'WBC',
		        'UNIT-NE',
		        'UNIT-LY',
		        'UNIT-MO',
		        'UNIT-EO',
		        'UNIT-BA',
		        'Neu#',
		        'Lym#',
		        'Mon#',
		        'Eos#',
		        'Baso#',
		        'RBC',
		        'HB',
		        'HCT',
		        'MCV',
		        'MCH',
		        'MCHC',
		        'RDW',
		        'PLATELET COUNT',
		        'PCT',
		        'MPV',
		        'PDW'
		        );

	protected $DATETIME_KEYS = array(
		        'YEAR-CT',
		        'MONTH-CT',
		        'DATE-CT',
		        'HH-CT',
		        'MM-CT',
		        'SS-CT'
		        );


	/**
	* Returns information about an instrument 
	*
	* @return array('name' => '', 'description' => '', 'testTypes' => array(), 'measures' => array()) 
	*/
    public function getEquipmentInfo(){
    	return array(
    		'code' => 'CF8222', 
    		'name' => 'Celltac F Mek 8222', 
    		'description' => 'Automatic analyzer with 22 parameters and WBC 5 part diff Hematology Analyzer',
    		'testTypes' => array("Full Haemogram", "WBC"),
                'measures' => $this->RESULTS_KEYS
    		);
    }

	/**
	* Fetch Test Result from machine and format it as an array
	*
	* @return array
	*/
    public function getResult($testTypeID = 0) {

    	/*
    	* 1. Read result file stored on the local machine (Use IP/host to verify that I'm on the correct host)
    	* 2. Parse the data
    	* 3. Return an array of key-value pairs: measure_name => value
    	*/

		/*-------------
		* Sample file output
		*339869 6.2  17.8L 74.2*  7.2*  0.7   0.1   1.1L  4.7*  0.4*  0.0   0.0  4.26  10.5L 35.5L 83.3  24.6L 29.6L 13.0    35L 0.02L  7.0  21.3H */

		/*------------------
		* The Celltac F analyzer has 22 test parameters as listed below:
		*-------------------
		* WBC, LY%, MO%, NE%, EO%, BA%, LY, MO, NE, EO, BA, RBC, HGB, HCT, MCV, MCH, MCHC, RDW, PLT, PCT, MPV, PDW
		*/

		#
		#   Get results output, sanitize the output,
		#   insert results into an array for handling in front end
		#

		// The dump file from the Celltac F analyzer is expected in the location below
		$DUMP_URL = "http://".$this->hostname."/tmp/celltac.txt";

		$RESULTS_STRING = file_get_contents($DUMP_URL);
			if ($RESULTS_STRING === FALSE){
			print "Something went wrong with getting the File";
		};

		if (strlen($RESULTS_STRING) < 50) {
			print "Results file is empty, please press print on celltac machine";
			return;
		}

		$arr = preg_split("/\r\n|\n|\r/",$RESULTS_STRING);
		$COMPLETE_RESULT_ARRAY = array();
		$RUBBISH = array('\u0003', '\u0002');

		foreach ($arr as $key) {
			$res_string = trim($key);
			$res_string = str_replace('+', '', $res_string);
			if($res_string != ''){
				$res_string = json_encode($res_string);
				$res_string = str_replace($RUBBISH, '', $res_string);
				$res_string = str_replace('"', '', $res_string);
				$COMPLETE_RESULT_ARRAY[] = $res_string;
			}
		}

			//If Results string is reasonably long enough match results
			if(count($COMPLETE_RESULT_ARRAY > 90)){
				return $this->match_results($COMPLETE_RESULT_ARRAY);
			}

		    else{
				print "Something went wrong, results string too short.";
				return;
		    }
	}

    public function match_results($COMPLETE_RESULT_ARRAY){
        //Count 98
        //TODO check array length if too small then invalid
        //Validate also using PatientID

        $this_year = date('Y');

        //Search for occurences of MEK-8222 string
        $ARR_COUNT = $this->count_needles_in_haystack('MEK-8222', $COMPLETE_RESULT_ARRAY);
        if ($ARR_COUNT != 2){
            //We DO NOT have a valid results with two parts, Results and static values
            print "Something went wrong : Too many results in celltac log file";
            return;
        }

        //Find where date starts and begin recording results from here
        $keyofyear = array_search(''.$this_year.'', $COMPLETE_RESULT_ARRAY);
        $DATETIME_VALUES = array_slice($COMPLETE_RESULT_ARRAY, $keyofyear , 6);
        $DATETIME_ARRAY = array_combine($this->DATETIME_KEYS, $DATETIME_VALUES);

        //TODO Validate $datetime_array
        //Search using using key of current patient in Results entry page
        $idKey = $keyofyear + 6;
        $patientID =  $COMPLETE_RESULT_ARRAY[$idKey];

		//Assuming they have not put patientID in celltac we start reading results immediately
		$resultsKey = $idKey;

		//sometimes they dont input patient ID thus we have to check to see if its there if not start results
		if (strpos($patientID, ".") == false) {
			//There could also be Age / comments inputs Between patient ID and Results
			$resultsKey = $idKey+1;
		}
        //TODO Check if Patient ID from results matches with current patient
        //After $idKey next 22 values are results
        $RESULTS_VALUES = array_slice($COMPLETE_RESULT_ARRAY, $resultsKey , 22);

        //TODO Need to check if RESULTS Array is valid
        //Map values to their corresponding keys i.e WBC, LY, MO
        $RESULTS = array_combine($this->RESULTS_KEYS, $RESULTS_VALUES);
         if (!$RESULTS) {
          //Something wrong
          print "Something went wrong : Keys not equal";
         }
         return $RESULTS;
         //print json_encode($RESULTS);
         //We have the results now we have to emtyy the text file in prep
         //For next printed data
    }

    public function count_needles_in_haystack($needle, $HayStack){
        //Count number of times needle occurs in array haystack
        $counts = array_count_values($HayStack);
        return $counts[$needle];
    }
}
