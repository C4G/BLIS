<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Includes all common JavaScript files
#

class ScriptElems
{
	public $enabledJQuery = false;
	public $enabledFacebox = false;
	public $enabledPageLoadIndicator = false;
	public $enabledDatePicker = false;
	public $enabledTimePicker = false;
	public $enabledTokenInput = false;
	public $enabledJQueryForm = false;
	public $enabledJQueryValidate = false;
	public $enabledTableSorter = false;
	public $enabledFlotBasic = false;
	public $enabledMultiSelect = false;
	public $enabledLatencyRecord = false;
	public $enabledFlipV = false;
	public $enabledJWizard = false;
	public $enabledAutoLogout = false;
	public $enabledAutogrowTextarea = false;
	public $enabledDragTable = false;
	public $enabledEditInPlace = false;
	public $enabledAutocomplete = false;
    public $enabledJQueryMask = false;

    //Tree view
    public $enabledTreeView = false;
	
	public function enableJQuery()
	{
		if($this->enabledJQuery === false)
		{
		?>
			
			<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script> -->
			<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
			
			<script type='text/javascript'>
			
				$(document).ready(function() {
					$("input").attr("autocomplete", "on");
				});
				
				String.prototype.trim = function() {
					return this.replace(/^\s+|\s+$/g,"");
				}
				
				String.prototype.contains = function(substr) {
					if(this.indexOf(substr) >= 0)
						return true;
					else
						return false;
				}
				
				function toggle(div_id)
				{
					$('#'+div_id).toggle();
				}
				
				function checkDateRegex(chkdate)
				{
					if(chkdate.match(/^[0-9]{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])/))
					{
						return true;
					}
					else
					{
						return false;
					}
				}
	
				function checkDate(y, m, d)
				{

					var today = new Date();
					var today_y = today.getFullYear();
					var today_m = today.getMonth()+1;
					var today_d = today.getDate();
					if(parseInt(y) > today_y){
                        return false;
                    }

					if(y.trim() == "" || m.trim() == "" || d.trim() == ""){
					    console.log(1);
                        return false;
                    }

					else if(parseInt(y) == today_y && parseInt(m) > today_m){
                        console.log(2);
					    return false;
                }

					else if(parseInt(y) == today_y && parseInt(m) == today_m && parseInt(d) > today_d){
                        console.log(3);
					    return false;
                }

					if(parseInt(y) < 1900){
                        console.log(4);
					    return false;
                    }

					return checkDateRegex(y+"-"+m+"-"+d);
				}
	
				Array.prototype.has=function(v){
					for (i=0; i<this.length; i++){
						if (this[i]==v) return i;
					}
					return false;
				} 
				if(!String.prototype.startsWith){
					String.prototype.startsWith = function (str) {
						return !this.indexOf(str);
					}
				}
				
				function cUpper(cObj) 
				{
					cObj.value=cObj.value.toUpperCase();
				}
				
				function validate_custom_numeric(elem, elem_id, range_lower, range_upper)
				{
					var value = elem.value;
					var error_elem_id = elem_id+"_err";
					if(value >= range_lower && value <= range_upper)
					{
						$('#'+error_elem_id).hide();
					}
					else
					{
						$('#'+error_elem_id).show();
					}
				}
				
			</script>
		<?php
		$this->enabledJQuery == true;
		}
	}
	
	public function enableFacebox()
	{
		# Enable facebox plugin for overlay dialogs/message boxes
		if($this->enabledFacebox === false)
		{
		?>
			<link href="facebox/facebox.css" media="screen" rel="stylesheet" type="text/css" />
			<script src="facebox/facebox.js" type="text/javascript"></script>
			<script type='text/javascript'>
			$(document).ready(function(){
				$('a[rel*=facebox]').facebox()
			});
			</script>
		<?php
			$this->enabledFacebox = true;
		}
	}
	
	public function enableDatePicker()
	{
		# Enable date picker library
		if($this->enabledDatePicker === false)
		{
		?>
			<!-- required plugins -->
			<SCRIPT type="text/javascript" src="js/date.js"></SCRIPT>
			<!--[if IE]><script type="text/javascript" src="js/jquery.bgiframe.min.js"></script><![endif]-->
			<!-- jquery.datePicker.js -->
			<SCRIPT type="text/javascript" src="js/jquery.datePicker.min.js"></SCRIPT>
			<!-- datePicker required styles -->
			<LINK rel="stylesheet" type="text/css" media="screen" href="css/datePicker.css">
		<?php
			$this->enabledDatePicker = true;
		}
	}
	
	public function enableTimePicker()
	{
		# Enable time picker library
		if($this->enabledTimePicker === false)
		{
		?>
			<SCRIPT type="text/javascript" src="js/jquery.timePicker.js"></SCRIPT>
		<?php
			$this->enabledTimePicker = true;
		}
	}
	
	public function enablePageloadIndicator()
	{
		# Enable page load indicator bar
		if($this->enabledPageLoadIndicator === false)
		{
		?>
			<script type="text/javascript">
			$(window).load(function(){
				$("#loading").hide();
			});
			</script>
			<!-- Code within Head Tag -->
			<style type="text/css">
			/* Loading Div Style */
			#loading{
				position:absolute;
				width:300px;
				top:0px;
				left:50%;
				margin-left:-150px;
				text-align:center;
				padding:7px 0 0 0;
				font:bold 11px Arial, Helvetica, sans-serif;
			}
			</style>
			<!-- Loading Div -->
			<div id="loading">
			Loading content, please wait..
			<img src="includes/img/loading.gif" alt="Loading.." />
			<br>
			</div>
		<?php
			$this->enabledPageLoadIndicator = true;
		}
	}
	
	public function enableAutoScrollTop()
	{
		?>
		<script type='text/javascript'>
		function set_page_focus()
		{
			$(window).scrollTop(0);
			$(window).scrollLeft(0);
		}
		$(window).load(function(){
			set_page_focus();
		});
		</script>
		<?php
	}
	public function enableAutocomplete()
	 {
		 if($this->enabledAutocomplete === false)
		{
	 ?>
  <!--<link rel="stylesheet" href="css/main.css" type="text/css" />-->
  <link rel="stylesheet" href="css/jquery.autocomplete.css" type="text/css" />
  <script type="text/javascript" src="js/jquery.bgiframe.min.js"></script>
 <script type="text/javascript" src="js/jquery.dimensions.js"></script>
  <script type="text/javascript" src="js/jquery.autocomplete.js"></script>
   <link rel="stylesheet" type="text/css" media="screen" href="css/select2.css"></link>
	<?php
		 }
		 $this->enabledAutocomplete = true;
		 }
	public function enableTokenInput()
	{
		if($this->enabledTokenInput === false)
		{
		?>
			<script type='text/javascript' src="js/jquery.tokeninput-1.1.js"></script>
			<link rel="stylesheet" type="text/css" media="screen" href="css/token-input.css"></link>
			<link rel="stylesheet" type="text/css" media="screen" href="css/token-input-facebook.css"></link>
		<?php
		}
		$this->enabledTokenInput = true;
	}
	
	public function enableJQueryForm()
	{
		if($this->enabledJQueryForm === false)
		{
		?>
			<script type='text/javascript' src="js/jquery.form.js"></script>
		<?php
		}
		$this->enabledJQueryForm = true;
	}
        
        public function enableJQueryMask()
	{
		if($this->enabledJQueryMask === false)
		{
		?>
                        <script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
		<?php
		}
		$this->enabledJQueryMask = true;
	}
	
	public function enableJQueryValidate()
	{
		if($this->enabledJQueryValidate === false)
		{
		?>
			<script type='text/javascript' src="js/jquery.validate.js"></script>
		<?php
		}
		$this->enabledJQueryValidate = true;
	}
	
	public function enableTableSorter($selectedStyle=null)
	{
		if($this->enabledTableSorter === false)
		{
			?>
			<script type='text/javascript' src="js/jquery.tablesorter.js"></script>
			<script type='text/javascript' src="js/jquery.tablesorter.pager.js"></script>
			<?php
			if($selectedStyle==null) {
			?>
				<link href="css/tablesorter_blue/style.css" media="screen" rel='stylesheet' type='text/css'></link>
			<?php 
			}
		}
		$this->enabledTableSorter = true;
	}
	
	public function enableFlotBasic()
	{
		if($this->enabledFlotBasic === false)
		{
		?>
			<!--[if IE]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]--> 
			<script language="javascript" type="text/javascript" src="js/jquery.flot.min.js"></script> 
		<?php
		}
		$this->enabledFlotBasic = true;
	}
	
	public function enableMultiSelect()
	{
		if($this->enabledMultiSelect === false)
		{
		?>
			<script src="js/jquery.multiselect/jquery.bgiframe.min.js" type="text/javascript"></script> 
			<script src="js/jquery.multiselect/jquery.multiSelect.js" type="text/javascript"></script> 
 			<link href="js/jquery.multiselect/jquery.multiSelect.css" rel="stylesheet" type="text/css" /> 
		<?php
		}
		$this->enabledMultiSelect = true;
	}
	
	public function enableLatencyRecord()
	{
		# Enables recording latency information for page load times
		if($this->enabledLatencyRecord === false)
		{
			if(session_id() == '')
			{
				session_start();
			}
			$_SESSION['DELAY_RECORDED'] = false;
		?>
			<script language="javascript" type="text/javascript" src="record.js"></script> 
		<?php
		}
		$this->enabledLatencyRecord = true;
	}
	
	public function bindEnterToClick($field_selector, $button_selector)
	{
		# Binds an form input field to enable form submit on hitting 'Enter' key
		?>
		<script type='text/javascript'>
		$(function() {
			$("<?php echo $field_selector; ?>").keypress(function (e) {
				if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
					$('<?php echo $button_selector; ?>').click();
					return false;
				} else {
					return true;
				}
			});
		});
		</script>
	<?php
	}
	
	public function enableFlipV()
	{
		# Enables jquery.flipv plugin for displaying vertical text
		# From http://www.openstudio.fr/jQuery-flipv.html?lang=en
		if($this->enabledFlipV == false)
		{
		?>
			<script type="text/javascript" src="js/cvi_text_lib.js"></script>
			<script type="text/javascript" src="js/jquery.flipv.js"></script>
			<script type="text/javascript" src="js/jquery.flipv_up.js"></script>
		<?php
		$this->enabledFlipV = true;
		}
	}
	
	public function enableJWizard()
	{
		# Enables jquery.jwizard plugin
		# From http://jquery.redllama.net/jwizard/
		if($this->enabledJWizard == false)
		{
		?>
			<script type="text/javascript" src="js/jquery.jwizard/jquery.jwizard.js"></script>
			<link href="js/jquery.jwizard/jquery.jwizard.css" media="screen" rel='stylesheet' type='text/css'></link>
		<?php
		$this->enabledJWizard = true;
		}
	}
	
	public function enableAutoLogout()
	{
		# Enables autologout after inactivity for a few seconds on the system
		if($this->enabledAutoLogout == false)
		{
		?>
			<script type="text/javascript" src="js/auto_logout.js"></script>
		<?php
		}
		$this->enabledAutoLogout = true;
	}
	
	public function enableAutogrowTextarea()
	{
		# Enables jquery.autogrow-textarea plugin
		if($this->enabledAutogrowTextarea == false)
		{
		?>
			<script type="text/javascript" src="js/jquery.autogrow-textarea.js"></script>
			<script type='text/javascript'>
			$(document).ready(function(){
				$('textarea').autogrow();
				$('textarea').css("height", "30px");
				$('textarea').css("line-height", "1");				
			});
			</script>
		<?php
		}
		$this->enabledAutogrowTextarea = true;
	}

	public function enableDragTable()
	{
		# Enables autologout after inactivity for a few seconds on the system
		if($this->enabledDragTable == false)
		{
		?>
			<script type="text/javascript" src="js/dragtable.js"></script>
		<?php
		}
		$this->enabledDragTable = true;
	}
	
	public function enableEditInPlace()
	{
		# Enables autologout after inactivity for a few seconds on the system
		if($this->enabledEditInPlace == false)
		{
		?>
			<script type="text/javascript" src="js/jquery.ui.js"></script>
			<script type="text/javascript" src="js/jquery.editinplace.js"></script>
			<!--<script type="text/javascript" src="js/jquery.ui.js"></script>
			<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
			<script type="text/javascript" src="js/jquery.editable.ipweditor-1.2.1.js"></script>
			<script type="text/javascript" src="js/fckeditor/fckeditor.js"></script>-->
		<?php
		}
		$this->enabledEditInPlace = true;
	}
	
	public function enableTreeView()
    {
        # Enables autologout after inactivity for a few seconds on the system
        if($this->enabledTreeView === false)
        {
        ?>
            <link rel="stylesheet" href="js/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
            <script type="text/javascript" src="js/ztree/js/jquery-1.4.4.min.js"></script>
            <script type="text/javascript" src="js/ztree/js/jquery.ztree.core-3.5.js"></script>
            <script type="text/javascript" src="js/ztree/js/jquery.ztree.excheck-3.5.js"></script>
            <script type="text/javascript" src="js/ztree/js/jquery.ztree.exhide-3.5.js"></script>
        <?php
        }
        $this->enabledTreeView = true;
    }
}
?>