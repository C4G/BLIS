<?php
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("reports");

putUILog('reports', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');


$script_elems->enableDatePicker();
$script_elems->enableJQueryForm();
$script_elems->enableTableSorter();
db_get_current();

$lab_config_id = $_SESSION['lab_config_id'];
?>

    <div class='reports_subdiv_help' id='reports_div_help' style='display:none'>
        <?php
        $tips_string = "";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='summary_div_help' style='display:none'>
        <?php
        //Prevelance Rate
        $tips_string = "Select the date range to view the infection graph and prevalence rates.";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='specimen_aggregate_report_form_div_help' style='display:none'>
        <?php
        $tips_string = "Select the date range and facilities for which the report should be generated";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='test_aggregate_report_form_div_help' style='display:none'>
        <?php
        $tips_string = "Select the date range and facilities for which the report should be generated";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='session_report_div_help2' style='display:none'>
        <?php
        $tips_string = LangUtil::$pageTerms['TIPS_SPECIMEN'];
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='pending_tests_div_help' style='display:none'>
        <?php
        $tips_string = LangUtil::$pageTerms['TIPS_PENDINGTESTS'];
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='tat_div_help' style='display:none'>
        <?php
        //Turnaround time
        $tips_string = "Select the date interval to view the average test-wise turn-around times for the lab test reports.";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='stock_report_div_help' style='display:none'>
        <?php
        //Turnaround time
        $tips_string = "Access previous inventory data.";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='user_stats_div_help' style='display:none'>
        <?php
        //Turnaround time
        $tips_string = "Display user specific statistics and user activity logs.";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='test_agg_reports_subdiv_help' id='test_agg_reports_div_help' style='display:none'>
        <?php
        //Test Aggregate Reports
        $tips_string = "Display test-wise reports - count and site.";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='tests_done_div_help' style='display:none'>
        <?php
        $tips_string = "Select Date Interval to view number of Tests Performed over the specified duration.";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='testcount_grouped_div_help' style='display:none'>
        <?php
        $tips_string = "Select Date Interval to view number of Tests Performed over the specified duration, grouped by age, gender and lab section.";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='specimencount_grouped_div_help' style='display:none'>
        <?php
        $tips_string = "Select Date Interval to view number of Specimens Analyzed over the specified duration, grouped by age and gender.";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='specimen_aggregate_report_config_div_help' style='display:none'>
        <?php
        $tips_string = "Select Date Interval to view number of Specimens Analyzed over the specified duration, grouped by age/gender/age unit.";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='print_div_help' style='display:none'>
        <?php
        $tips_string = LangUtil::$pageTerms['TIPS_TESTRECORDS'];
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='specimen_count_div_help' style='display:none'>
        <?php
        //Counts
        $tips_string = "Select date range and type of count required";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='test_history_div_help' style='display:none'>
        <?php
        //Patient Report
        $tips_string = "Select Patient Name, Number or ID to retrieve patient's lab reports";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='daily_report_div_help' style='display:none'>
        <?php
        //Daily Log
        $tips_string = LangUtil::$pageTerms['TIPS_DAILYLOGS'];
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div>

    <div class='reports_subdiv_help' id='disease_report_div_help' style='display:none'>
        <?php
        //Infection report
        $tips_string = "Select Date range and lab section to view the Infection report";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='prevalance_aggregate_div_help' style='display:none'>
        <?php
        $tips_string = "Select a test, the date range and facilities for which the report should be generated";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='tat_aggregate_div_help' style='display:none'>
        <?php
        $tips_string = "Select a test, the date range, the time division for data collection and facilities for which the report should be generated";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>
    <div class='reports_subdiv_help' id='infection_aggregate_div_help' style='display:none'>
        <?php
        $tips_string = "Select a lab section, the date range and facilities for which the report should be generated";
        $page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        ?>
    </div>

    <style type="text/css">
        .ustats_link_v
        {
            font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
            background-color:#a7dd5c;
        }

        .ustats_link_u
        {
            font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
        }
    </style>
    <script type='text/javascript' src="facebox/facebox.js"></script>
    <script type='text/javascript'>
        $(document).ready(function(){
            $("input[name='rage']").change(function() {
                toggle_agegrouplist();
            });
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $("#location").change(function () { get_test_types('location', 't_type') });
            $("#location3").change(function () { get_test_types('location3', 't_type3') });
            $("#location6").change(function () { get_test_types('location6', 't_type6') });
            $("#location9").change(function () { get_test_types('location9', 't_type9') });
            $("#location10").change(function () { get_test_types_withall('location10', 't_type10') });
            $("#location11").change(function () { get_usernames('location11', 'username11') });
            $("input[name='rectype13']").change( function() {
                var recordType = $("input[name='rectype13']:checked").attr("value");
                if(recordType == 1){
                    $('#cat_row13').show();
                    $('#ttype_row13').show();
                } else if(recordType == 2) {
                    $('#cat_row13').show();
                    $('#ttype_row13').hide();
                } else {
                    $('#cat_row13').hide();
                    $('#ttype_row13').hide();
                }
            });
            $('#cat_code13').change( function() { get_test_types_bycat() });
            $("#reportTypeSelect").change( function() {
                var selectedReport = $("#reportTypeSelect").val();
                if ( selectedReport == "infectionReport" ) {
                    $('#ttype_row16').hide();
                    $('#labSection_row').show();
                }
                else {
                    $('#labSection_row').hide();
                    $('#ttype_row16').show();
                }
            });
            get_test_types('location', 't_type');
            get_test_types('location3', 't_type3');
            get_test_types('location6', 't_type6');
            get_test_types('location9', 't_type9');
            get_test_types_withall('location10', 't_type10');
            get_usernames('location11', 'username11');
            get_test_types_bycat();
            <?php
            if (isset($_REQUEST['show_d'])) {
                ?>
            show_disease_form();
            <?php
            } elseif (isset($_REQUEST['show_p'])) {
                ?>
            show_summary_form();
            <?php
            } elseif (isset($_REQUEST['show_p_agg'])) {
                ?>
            show_selection("prevalance_aggregate");
            <?php
            } elseif (isset($_REQUEST['show_t'])) {
                ?>
            show_tat_form();
            <?php
            } elseif (isset($_REQUEST['show_tsr'])) {
                ?>
            show_test_stats_form();
            <?php
            } elseif (isset($_REQUEST['show_c'])) {
                ?>
            show_specimen_count_form();
            <?php
            } elseif (isset($_REQUEST['show_ust'])) {
                ?>
            $('#user_stats_div').show();
            <?php
            } elseif (isset($_REQUEST['show_t_agg'])) {
                ?>
            show_tat_aggregate_form();
            <?php
            } elseif (isset($_REQUEST['show_agg'])) {
                ?>
            show_selection('country_aggregate');
            <?php
            } elseif (isset($_REQUEST['specimen_aggregate_update'])) {
                # Show custom field updated message?>
            $('#specimen_aggregate_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('specimen_aggregate_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
            $('#specimen_aggregate_msg').show();
            show_selection("specimen_aggregate_report_config_div");
            <?php
            } elseif (isset($_REQUEST['infrepupdated'])) { ?>
            $('#report_updated_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('report_updated_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
            $('#report_updated_msg').show();
            show_selection("infection_report_settings");
            <?php } ?>


            $("#testRec").attr('checked',true);
        });

        function specimen_aggregate_checkandsubmit()
        {
            //Validate
            //TODO
            //All okay
            $('#grouped_count_country_dir_progress_spinner').show();
            $('#specimen_aggregate_report_config_form').ajaxSubmit({
                success: function() {
                    $('#grouped_count_country_dir_progress_spinner').hide();
                    window.location="reports.php?id=<?php echo $lab_config->id; ?>&specimen_aggregate_update=1";
                }
            });
        }
        function changeAvailableLocations(dropdown) {
            var index  = dropdown.selectedIndex;
            var selectValue = dropdown.options[index].value;
            $('#locationAggregation').load('ajax/locations_bytests.php?l='+selectValue+'&checkBoxName=locationAgg[]');
        }

        function handleChange(dropdown) {
            if( dropdown.value != 0 ) {
                get_test_types_bycat();

            }
        }

        function getTestCategories(locationCode) {
            $('#cat_code13').load('ajax/tests_selectbysection.php?l='+locationCode);
        }

        function get_test_types_bycat()
        {
            var cat_code = $('#cat_code13').attr("value");
            var location_code = $('#location13').attr("value");
            $('#ttype13').load('ajax/tests_selectbycat.php?c='+cat_code+'&l='+location_code);
        }

        function get_test_types(location_elem, t_type_elem)
        {
            $.getJSON("ajax/tests_select.php",{site: $('#'+location_elem).val()}, function(j){
                var options = '';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
                }
                $("select#"+t_type_elem).html(options);
            })
        }

        function get_test_types_withall(location_elem, t_type_elem)
        {
            $.getJSON("ajax/tests_select.php",{site: $('#'+location_elem).val()}, function(j){
                var options = '';
                options += '<option value="0">All</option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
                }
                $("select#"+t_type_elem).html(options);
            })
        }

        function get_usernames(location_elem, username_elem)
        {
            $.getJSON("ajax/users_select.php",{site: $('#'+location_elem).val()}, function(j){
                var options = '';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
                }
                $("select#"+username_elem).html(options);
            })
        }

        function show_report_form()
        {
            //Not in use
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#reports_div').show();
            $('#reports_div_help').show();
        }

        function show_summary_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#summary_div').show();
            $('#summary_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#summary_menu').addClass('current_menu_option');
        }

        function show_pending_tests_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#pending_tests_div').show();
            $('#pending_tests_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#pending_tests_menu').addClass('current_menu_option');
        }

        function show_tat_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#tat_div').show();
            $('#tat_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#tat_menu').addClass('current_menu_option');
        }

        /* Manav */
        function show_test_stats_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#test_results_range_div').show();
            $('#test_results_range_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#test_results_range_div').addClass('current_menu_option');
        }

        function show_tests_done_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#tests_done_div').show();
            $('#tests_done_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#tests_done_menu').addClass('current_menu_option');
        }

        function show_testcount_grouped_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#testcount_grouped_div').show();
            $('#testcount_grouped_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#testcount_grouped_menu').addClass('current_menu_option');
        }

        function show_specimencount_grouped_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#specimencount_grouped_div').show();
            $('#specimencount_grouped_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#specimencount_grouped_menu').addClass('current_menu_option');
        }


        function show_print_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#print_div').show();
            $('#print_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#print_menu').addClass('current_menu_option');
        }

        function show_specimen_count_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#specimen_count_div').show();
            $('#specimen_count_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#specimen_count_menu').addClass('current_menu_option');
        }

        function show_billing_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#billing_report_div').show();
            $('#billing_report_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#billing_report_menu').addClass('current_menu_option');
        }

        function show_test_history_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#test_history_div').show();
            $('#test_history_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#test_history_menu').addClass('current_menu_option');
        }

        function show_test_report_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#test_report_div').show();
            $('#test_report_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#test_report_menu').addClass('current_menu_option');
        }

        function show_specimen_report_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#specimen_report_div').show();
            $('#specimen_report_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#specimen_report_menu').addClass('current_menu_option');
        }

        function show_user_log_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#user_log_div').show();
            $('#user_log_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#user_log_menu').addClass('current_menu_option');
        }

        function show_patient_report_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#patient_report_div').show();
            $('#patient_report_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#patient_report_menu').addClass('current_menu_option');
        }

        function show_session_report_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#session_report_div').show();
            $('#session_report_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#session_report_menu').addClass('current_menu_option');
        }

        function show_specimen_log_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#specimen_log_div').show();
            $('#specimen_log_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#specimen_log_menu').addClass('current_menu_option');
        }

        function show_daily_report_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#daily_report_div').show();
            $('#daily_report_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#daily_report_menu').addClass('current_menu_option');
        }

        function show_disease_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('.menu_option').removeClass('current_menu_option');
            $('#disease_report_div').show();
            $('#disease_report_div_help').show();
            $('#disease_report_menu').addClass('current_menu_option');
        }
        function show_stock_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('.menu_option').removeClass('current_menu_option');
            $('#stock_report_div').show();
            $('#stock_report_menu').addClass('current_menu_option');
        }

        function show_control_test_form()
        {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('.menu_option').removeClass('current_menu_option');
            $('#control_report_div').show();
            $('#control_report_menu').addClass('current_menu_option');

        }

        function show_selection(divName) {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#'+divName+'_div').show();
            if(divName != "specimen_aggregate_report_config")
                $('#'+divName+'_div_help').show();
            $('.menu_option').removeClass('current_menu_option');
            $('#pending_tests_menu').addClass('current_menu_option');
        }

        function show_user_stats_submenu(divID) {
            if(divID == 1)
            {
                $('#user_stats_all').show();
                $('#ustats_a').removeClass('ustats_link_u');
                $('#ustats_a').addClass('ustats_link_v');
                $('#ustats_i').removeClass('ustats_link_v');
                $('#ustats_i').addClass('ustats_link_u');
                $('#user_stats_individual').hide();
            }
            else if(divID == 2)
            {
                $('#user_stats_all').hide();
                $('#ustats_i').removeClass('ustats_link_u');
                $('#ustats_i').addClass('ustats_link_v');
                $('#ustats_a').removeClass('ustats_link_v');
                $('#ustats_a').addClass('ustats_link_u');
                $('#user_stats_individual').show();
            }

        }

        function show_test_agg_reports_div() {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#test_agg_reports_div').show()
            $('.menu_option').removeClass('current_menu_option');
            $('#test_aggregate_reports_form_menu').addClass('current_menu_option');
        }

        function show_site_agg_reports_div() {
            $('.reports_subdiv').hide();
            $('.reports_subdiv_help').hide();
            $('#site_agg_reports_div').show()
            $('.menu_option').removeClass('current_menu_option');
            $('#site_aggregate_reports_form_menu').addClass('current_menu_option');
        }


        function user_radio(divID) {
            if(divID == 1)
            {
                $("#user_stats_form").attr("action", "reports_user_stats_all.php");
                $("#user_stats_form").attr("target", "_self");
                $('#user_stats_all').show();
                $('#user_stats_individual').hide();
            }
            else if(divID == 2)
            {
                $("#user_stats_form").attr("action", "reports_user_stats_individual.php");
                $("#user_stats_form").attr("target", "_blank");
                $('#user_stats_all').hide();
                $('#user_stats_individual').show();
            }

        }

        function toggleInfectionReportSettings()
        {
            $('#infection_report_settings_summary').toggle();
            $('#infection_report_settings_form_div').toggle();
            var curr_link_text = $('#agg_edit_link').html();
            if(curr_link_text == "<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>")
                $('#agg_edit_link').html("<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>");
            else
                $('#agg_edit_link').html("<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>");
        }

        function toggle_specimen_aggregate_report()
        {
            $('#specimen_aggregate_report_summary').toggle();
            $('#specimen_aggregate_report_config_form_div').toggle();
            var curr_link_text = $('#specimen_aggregate_edit_link').html();
            if(curr_link_text == "<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>")
                $('#specimen_aggregate_edit_link').html("<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>");
            else
                $('#specimen_aggregate_edit_link').html("<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>");
        }

        function agg_checkandsubmit()
        {
            $('#agg_progress_spinner').show();
            $('#agg_progress_spinner').hide();
            $('#infection_report_settings_form').ajaxSubmit({
                success: function() {
                    $('#agg_progress_spinner').hide();
                    window.location="reports.php?infrepupdated=1";
                }
            });
        }

        function agg_preview()
        {
            // Shows preview of infection report in a separate window
            // Clone fields from disease report form to preview form
            $('#agg_preview_form').html($('#agg_report_form').clone(true).html());
            $('#agg_preview_form').submit();
        }

        function get_patient_reports()
        {
            var t_type = $("#t_type").attr("value");
            var location = $("#location").attr("value");
            var yyyy_from = $("#yyyy_from").attr("value");
            var mm_from = $("#mm_from").attr("value");
            var dd_from = $("#dd_from").attr("value");
            var yyyy_to = $("#yyyy_to").attr("value");
            var mm_to = $("#mm_to").attr("value");
            var dd_to = $("#dd_to").attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(t_type == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {

                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID'];?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {

                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else
            {
                if(
                    isNaN(yyyy_from) ||
                    isNaN(yyyy_to) ||
                    isNaN(mm_from) ||
                    isNaN(mm_to) ||
                    isNaN(dd_from) ||
                    isNaN(dd_to)
                )
                {
                    $("#mm_from").val("");
                    $("#dd_from").val("");
                    $("#yyyy_from").val("");
                    $("#mm_to").val("");
                    $("#dd_to").val("");
                    $("#yyyy_to").val("");
                }
                $('#report_progress_bar').show();
                $("#get_patient_report").submit();
            }
        }
        function get_aggregate_report() {
            var t_type = $("#ttype_row16").attr("value");
            var location = $("#location").attr("value");
            var yyyy_from = $("#yyyy_from").attr("value");
            var mm_from = $("#mm_from").attr("value");
            var dd_from = $("#dd_from").attr("value");
            var yyyy_to = $("#yyyy_to").attr("value");
            var mm_to = $("#mm_to").attr("value");
            var dd_to = $("#dd_to").attr("value");

            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(t_type == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else
            {
                if(
                    isNaN(yyyy_from) ||
                    isNaN(yyyy_to) ||
                    isNaN(mm_from) ||
                    isNaN(mm_to) ||
                    isNaN(dd_from) ||
                    isNaN(dd_to)
                )
                {
                    $("#mm_from").val("");
                    $("#dd_from").val("");
                    $("#yyyy_from").val("");
                    $("#mm_to").val("");
                    $("#dd_to").val("");
                    $("#yyyy_to").val("");
                }
                $('#aggregate_report_progress_spinner').show();
                $("#country_aggregate_form").submit();
            }
        }

        function agegrouplist_append()
        {
            var html_code = "&nbsp;&nbsp;<input type='text' name='age_l[]' class='range_field'></input>-<input type='text' name='age_u[]' class='range_field'></input>";
            $('#agegrouplist_inner').append(html_code);
        }

        function add_slot(span_id, field_name1, field_name2)
        {
            var html_code = "&nbsp;&nbsp;&nbsp;<input type='text' class='range_field' name='"+field_name1+"[]' value=''></input>-<input type='text' class='range_field' name='"+field_name2+"[]' value=''></input>";
            $('#'+span_id).append(html_code);
        }

        function get_summary_fn(all_sites_flag)
        {
            if(all_sites_flag == 0)
            {
                //View Cumulative
                //Change checkbox value to "C"
                $('input[name=summary_type]:checked').attr('value', 'C');
            }
            else if(all_sites_flag == 1)
            {
                //Change checkbox value to "M"
                $('input[name=summary_type]:checked').attr('value', 'M');
            }
            else if(all_sites_flag == 2)
            {
                //View across all available sites
                //Change checkbox value to "L"
                $('input[name=summary_type]:checked').attr('value', 'L');
            }
            var location = $("#location2").attr("value");
            var yyyy_from = $("#yyyy_from2").attr("value");
            var mm_from = $("#mm_from2").attr("value");
            var dd_from = $("#dd_from2").attr("value");
            var yyyy_to = $("#yyyy_to2").attr("value");
            var mm_to = $("#mm_to2").attr("value");
            var dd_to = $("#dd_to2").attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(
                isNaN(yyyy_from) ||
                isNaN(yyyy_to) ||
                isNaN(mm_from) ||
                isNaN(mm_to) ||
                isNaN(dd_from) ||
                isNaN(dd_to)
            )
            {
                $("#mm_from2").val("");
                $("#dd_from2").val("");
                $("#yyyy_from2").val("");
                $("#mm_to2").val("");
                $("#dd_to2").val("");
                $("#yyyy_to2").val("");
            }
            $('#summary_progress_bar').show();
            $("#get_summary").submit();
        }

        function get_pending_report()
        {
            var location = $("#location3").attr("value");
            var t_type = $("#t_type3").attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
            }
            else if(t_type == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
            }
            else
            {
                $('#pending_progress_spinner').show();
                $('#pending_tests_form').submit();
            }
        }


        function get_tests_done_report()
        {
            var location = $("#location4").attr("value");
            var yyyy_from = $("#yyyy_from4").attr("value");
            var mm_from = $("#mm_from4").attr("value");
            var dd_from = $("#dd_from4").attr("value");
            var yyyy_to = $("#yyyy_to4").attr("value");
            var mm_to = $("#mm_to4").attr("value");
            var dd_to = $("#dd_to4").attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(
                isNaN(yyyy_from) ||
                isNaN(yyyy_to) ||
                isNaN(mm_from) ||
                isNaN(mm_to) ||
                isNaN(dd_from) ||
                isNaN(dd_to)
            )
            {
                $("#mm_from4").val("");
                $("#dd_from4").val("");
                $("#yyyy_from4").val("");
                $("#mm_to4").val("");
                $("#dd_to4").val("");
                $("#yyyy_to4").val("");
            }
            $('#tests_done_progress_spinner').show();
            $('#tests_done_form').submit();
        }

        function get_doctor_stats()
        {
            var location = $("#location7").attr("value");
            var yyyy_from = $("#yyyy_from7").attr("value");
            var mm_from = $("#mm_from7").attr("value");
            var dd_from = $("#dd_from7").attr("value");
            var yyyy_to = $("#yyyy_to7").attr("value");
            var mm_to = $("#mm_to7").attr("value");
            var dd_to = $("#dd_to7").attr("value");

            $("#location8").attr("value", location);
            $("#yyyy_from8").attr("value", yyyy_from);
            $("#mm_from8").attr("value", mm_from);
            $("#dd_from8").attr("value", dd_from);
            $("#yyyy_to8").attr("value", yyyy_to);
            $("#mm_to8").attr("value", mm_to);
            $("#dd_to8").attr("value", dd_to);

            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(
                isNaN(yyyy_from) ||
                isNaN(yyyy_to) ||
                isNaN(mm_from) ||
                isNaN(mm_to) ||
                isNaN(dd_from) ||
                isNaN(dd_to)
            )
            {
                $("#mm_from8").val("");
                $("#dd_from8").val("");
                $("#yyyy_from8").val("");
                $("#mm_to8").val("");
                $("#dd_to8").val("");
                $("#yyyy_to8").val("");
            }
            $('#specimen_count_progress_spinner').show();
            $('#doctors_stats_form').submit();


        }
        function get_tests_done_report2()
        {

            var location = $("#location7").attr("value");
            var yyyy_from = $("#yyyy_from7").attr("value");
            var mm_from = $("#mm_from7").attr("value");
            var dd_from = $("#dd_from7").attr("value");
            var yyyy_to = $("#yyyy_to7").attr("value");
            var mm_to = $("#mm_to7").attr("value");
            var dd_to = $("#dd_to7").attr("value");

            $("#location4").attr("value", location);
            $("#yyyy_from4").attr("value", yyyy_from);
            $("#mm_from4").attr("value", mm_from);
            $("#dd_from4").attr("value", dd_from);
            $("#yyyy_to4").attr("value", yyyy_to);
            $("#mm_to4").attr("value", mm_to);
            $("#dd_to4").attr("value", dd_to);

            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(
                isNaN(yyyy_from) ||
                isNaN(yyyy_to) ||
                isNaN(mm_from) ||
                isNaN(mm_to) ||
                isNaN(dd_from) ||
                isNaN(dd_to)
            )
            {
                $("#mm_from4").val("");
                $("#dd_from4").val("");
                $("#yyyy_from4").val("");
                $("#mm_to4").val("");
                $("#dd_to4").val("");
                $("#yyyy_to4").val("");
            }
            $('#specimen_count_progress_spinner').show();
            $('#tests_done_form').submit();
        }

        function get_testcount_grouped()
        {

            var location = $("#location7").attr("value");
            var yyyy_from = $("#yyyy_from7").attr("value");
            var mm_from = $("#mm_from7").attr("value");
            var dd_from = $("#dd_from7").attr("value");
            var yyyy_to = $("#yyyy_to7").attr("value");
            var mm_to = $("#mm_to7").attr("value");
            var dd_to = $("#dd_to7").attr("value");

            $("#location44").attr("value", location);
            $("#yyyy_from44").attr("value", yyyy_from);
            $("#mm_from44").attr("value", mm_from);
            $("#dd_from44").attr("value", dd_from);
            $("#yyyy_to44").attr("value", yyyy_to);
            $("#mm_to44").attr("value", mm_to);
            $("#dd_to44").attr("value", dd_to);

            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(
                isNaN(yyyy_from) ||
                isNaN(yyyy_to) ||
                isNaN(mm_from) ||
                isNaN(mm_to) ||
                isNaN(dd_from) ||
                isNaN(dd_to)
            )
            {
                $("#mm_from44").val("");
                $("#dd_from44").val("");
                $("#yyyy_from44").val("");
                $("#mm_to44").val("");
                $("#dd_to44").val("");
                $("#yyyy_to44").val("");
            }
            //$('#specimen_count_progress_spinner').show();
            $('#testcount_grouped_form').submit();
        }

        function get_specimencount_grouped()
        {

            var location = $("#location7").attr("value");
            var yyyy_from = $("#yyyy_from7").attr("value");
            var mm_from = $("#mm_from7").attr("value");
            var dd_from = $("#dd_from7").attr("value");
            var yyyy_to = $("#yyyy_to7").attr("value");
            var mm_to = $("#mm_to7").attr("value");
            var dd_to = $("#dd_to7").attr("value");

            $("#location444").attr("value", location);
            $("#yyyy_from444").attr("value", yyyy_from);
            $("#mm_from444").attr("value", mm_from);
            $("#dd_from444").attr("value", dd_from);
            $("#yyyy_to444").attr("value", yyyy_to);
            $("#mm_to444").attr("value", mm_to);
            $("#dd_to444").attr("value", dd_to);

            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(
                isNaN(yyyy_from) ||
                isNaN(yyyy_to) ||
                isNaN(mm_from) ||
                isNaN(mm_to) ||
                isNaN(dd_from) ||
                isNaN(dd_to)
            )
            {
                $("#mm_from44").val("");
                $("#dd_from44").val("");
                $("#yyyy_from44").val("");
                $("#mm_to44").val("");
                $("#dd_to44").val("");
                $("#yyyy_to44").val("");
            }
            //$('#specimen_count_progress_spinner').show();
            $('#specimencount_grouped_form').submit();
        }


        function get_tat_report()
        {
            var location = $("#location5").attr("value");
            var yyyy_from = $("#yyyy_from5").attr("value");
            var mm_from = $("#mm_from5").attr("value");
            var dd_from = $("#dd_from5").attr("value");
            var yyyy_to = $("#yyyy_to5").attr("value");
            var mm_to = $("#mm_to5").attr("value");
            var dd_to = $("#dd_to5").attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(
                isNaN(yyyy_from) ||
                isNaN(yyyy_to) ||
                isNaN(mm_from) ||
                isNaN(mm_to) ||
                isNaN(dd_from) ||
                isNaN(dd_to)
            )
            {
                $("#mm_from5").val("");
                $("#dd_from5").val("");
                $("#yyyy_from5").val("");
                $("#mm_to5").val("");
                $("#dd_to5").val("");
                $("#yyyy_to5").val("");
            }
            $('#tat_progress_spinner').show();
            $('#tat_form').submit();
        }

        function submit_tat_aggregate_form() {
            var location = $("#location5").attr("value");
            var yyyy_from = $("#yyyy_from5").attr("value");
            var mm_from = $("#mm_from5").attr("value");
            var dd_from = $("#dd_from5").attr("value");
            var yyyy_to = $("#yyyy_to5").attr("value");
            var mm_to = $("#mm_to5").attr("value");
            var dd_to = $("#dd_to5").attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(
                isNaN(yyyy_from) ||
                isNaN(yyyy_to) ||
                isNaN(mm_from) ||
                isNaN(mm_to) ||
                isNaN(dd_from) ||
                isNaN(dd_to)
            )
            {
                $("#mm_from5").val("");
                $("#dd_from5").val("");
                $("#yyyy_from5").val("");
                $("#mm_to5").val("");
                $("#dd_to5").val("");
                $("#yyyy_to5").val("");
            }
            $('#tat_progress_spinner').show();
            $('#tat_aggregate_form').submit();
        }
        function submit_specimen_aggregate_report_form() {
            var yyyy_from = $("#yyyy_from9").attr("value");
            var mm_from = $("#mm_from9").attr("value");
            var dd_from = $("#dd_from9").attr("value");
            var yyyy_to = $("#yyyy_to9").attr("value");
            var mm_to = $("#mm_to9").attr("value");
            var dd_to = $("#dd_to9").attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(
                isNaN(yyyy_from) ||
                isNaN(yyyy_to) ||
                isNaN(mm_from) ||
                isNaN(mm_to) ||
                isNaN(dd_from) ||
                isNaN(dd_to)
            )
            {
                $("#mm_from9").val("");
                $("#dd_from9").val("");
                $("#yyyy_from9").val("");
                $("#mm_to9").val("");
                $("#dd_to9").val("");
                $("#yyyy_to9").val("");
            }
            $('#test_specimen_aggregate_report_form_progress_spinner').show();
            $('#specimen_aggregate_report_form').submit();
        }
        function submit_test_aggregate_report_form() {
            var yyyy_from = $("#yyyy_from_labs").attr("value");
            var mm_from = $("#mm_from_labs").attr("value");
            var dd_from = $("#dd_from_labs").attr("value");
            var yyyy_to = $("#yyyy_to_labs").attr("value");
            var mm_to = $("#mm_to_labs").attr("value");
            var dd_to = $("#dd_to_labs").attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                //alert(yyyy_from+' '+  mm_from + " "+ dd_from);
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                //alert(yyyy_to+' '+  mm_to + " "+ dd_to);
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(
                isNaN(yyyy_from) ||
                isNaN(yyyy_to) ||
                isNaN(mm_from) ||
                isNaN(mm_to) ||
                isNaN(dd_from) ||
                isNaN(dd_to)
            )
            {
                $("#mm_from9").val("");
                $("#dd_from9").val("");
                $("#yyyy_from9").val("");
                $("#mm_to9").val("");
                $("#dd_to9").val("");
                $("#yyyy_to9").val("");
            }
            $('#test_aggregate_report_form_progress_spinner').show();
            $('#test_aggregate_report_form').submit();
        }

        function submit_test_agg_report_form()
        {
            var yyyy_from = $('#yyyy_from').attr('value');
            var mm_from = $('#mm_from').attr('value');
            var dd_from = $('#dd_from').attr('value');

            var yyyy_to = $('#yyyy_to').attr('value');
            var mm_to = $('#mm1_to').attr('value');
            var dd_to = $('#dd_to').attr('value');

            var test_id = $('#select_test_for_report').attr('value');
            var site = $('#select_site_for_report').attr('value');

            if(checkDate(yyyy_from, mm_from, dd_from) == false) {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            } else if(checkDate(yyyy_to, mm_to, dd_to) == false) {
alert(yyyy_to);
alert(mm_to);
alert(dd_to);
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>"+"def");
                return;
            }

            $('#test_agg_report_spinner').show();
            $('#test_agg_reports_form').submit();
        }

       function submit_site_agg_report_form()
        {
            var yyyy_from = $('#yyyy_from_site').attr('value');
            var mm_from = $('#mm_from_site').attr('value');
            var dd_from = $('#dd_from_site').attr('value');

            var yyyy_to = $('#yyyy_to_site').attr('value');
            var mm_to = $('#mm_to_site').attr('value');
            var dd_to = $('#dd_to_site').attr('value');



            if(checkDate(yyyy_from, mm_from, dd_from) == false) {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            } else if(checkDate(yyyy_to, mm_to, dd_to) == false) {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }


            $('#site_agg_reports_form').submit();
        }

        function get_print_page()
        {
            var location = $("#location6").attr("value");
            var t_type = $("#t_type6").attr("value");
            var yyyy_from = $("#yyyy_from6").attr("value");
            var mm_from = $("#mm_from6").attr("value");
            var dd_from = $("#dd_from6").attr("value");
            var yyyy_to = $("#yyyy_to6").attr("value");
            var mm_to = $("#mm_to6").attr("value");
            var dd_to = $("#dd_to6").attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(t_type == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            //$('#print_progress_bar').show();
            $('#get_print').submit();
        }

        function get_count_report()
        {
            var count_type = $("input[name='count_type']:checked").attr("value");
            if(count_type == 1)
            {
                get_specimen_count_report();
            }
            else if(count_type == 2)
            {
                get_tests_done_report2();
            }
            else if(count_type==3)
            {

                get_doctor_stats();
            }
            else if(count_type==4)
            {

                get_testcount_grouped();
            }
            else if(count_type==5)
            {

                get_specimencount_grouped();
            }
        }

        function get_specimen_count_report()
        {
            var location = $("#location7").attr("value");
            var yyyy_from = $("#yyyy_from7").attr("value");
            var mm_from = $("#mm_from7").attr("value");
            var dd_from = $("#dd_from7").attr("value");
            var yyyy_to = $("#yyyy_to7").attr("value");
            var mm_to = $("#mm_to7").attr("value");
            var dd_to = $("#dd_to7").attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            else if(checkDate(yyyy_from, mm_from, dd_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            else if(checkDate(yyyy_to, mm_to, dd_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(
                isNaN(yyyy_from) ||
                isNaN(yyyy_to) ||
                isNaN(mm_from) ||
                isNaN(mm_to) ||
                isNaN(dd_from) ||
                isNaN(dd_to)
            )
            {
                $("#mm_from7").val("");
                $("#dd_from7").val("");
                $("#yyyy_from7").val("");
                $("#mm_to7").val("");
                $("#dd_to7").val("");
                $("#yyyy_to7").val("");
            }
            $('#specimen_count_progress_spinner').show();
            $('#specimen_count_form').submit();
        }

        function get_test_history_report()
        {
            var location = $("#location8").attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            var pid = $('#patient_id8').attr("value");
            if(pid == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
                return;
            }
            //$('#test_history_progress_spinner').show();
            $('#test_history_form').submit();
        }

        function search_patient_history()
        {
            var superuser = <?php echo(is_super_admin(get_user_by_id($_SESSION["user_id"])) ? 'true' : 'false'); ?>;
            var location = $("#location8").attr("value");
            var search_attrib = $('#p_attrib').attr("value");
            var condition_attrib = $('#h_attrib').attr("value");
            var pid = $('#patient_id8').attr("value");
            var lid = $('#lab_config_id8').attr("value");
            // alert(location);
            // alert("hello");
            if(pid == "" || (superuser && lid == ""))
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
                return;
            }
            var cat_code =  $('#cat_code_patient_report').attr("value");
            //alert(cat_code);
            $('#test_history_progress_spinner').show();
            var url = 'ajax/search_p_dyn.php?lab_config_id=' + lid;
            //alert(search_attrib+" "+condition_attrib);
            $("#phistory_list").load(url,
                {q: pid, a: search_attrib, l: location, lab_section : cat_code, c: condition_attrib },
                function()
                {
                    $('#test_history_progress_spinner').hide();
                    $('#phistory_list').show();
                }
            );
        }

        function search_preport()
        {
            var location = $("#location15").attr("value");
            var search_attrib = $('#p_attrib15').attr("value");
            var pid = $('#patient_id15').attr("value");
            if(pid == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
                return;
            }
            $('#preport_progress_spinner').show();
            var url = 'ajax/preport_checkboxes.php';
            $("#preport_list").load(url,
                {q: pid, a: search_attrib, l: location },
                function() {
                    $('#preport_progress_spinner').hide();
                    $('#preport_list').show();
                    $('#preport_table').tablesorter({sortList: [[4,1]]});
                    $('#location151').attr("value", location);
                }
            );
        }

        function submit_preport()
        {
            //Validate
            var checkbox_list = $('.sp_checkbox');
            var none_selected = true;
            for(var i = 0; i < checkbox_list.length; i++)
            {
                if(checkbox_list[i].checked == true)
                {
                    none_selected = false;
                    break;
                }
            }
            if(none_selected == true)
            {
                alert("No tests selected.");
                return;
            }
            //All okay
            $('#preport_selected_form').submit();
        }

        function get_test_report()
        {
            var location = $("#location9").attr("value");
            var sid = $('#specimen_id9').attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            if(sid == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
                return;
            }
            $('#test_report_form').submit();
        }

        function get_specimen_report()
        {
            var location = $('#location10').attr("value");
            var sid = $('#specimen_id10').attr("value");
            var ttype = $('#t_type10').attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            if(sid == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
                return;
            }
            if(ttype == 0)
            {
                $('#specimen_report_form').submit();
            }
            else
            {
                $('#location9').attr("value", location);
                $('#specimen_id9').attr("value", sid);
                $('#t_type9').attr("value", ttype);
                $('#test_report_form').submit();
            }
        }

        function get_user_log_report()
        {
            var location = $('#location11').attr("value");
            var user = $('#username11').attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            if(user == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
                return;
            }
            $('#user_log_form').submit();
        }

        function get_session_report()
        {
            var location = $('#location11').attr("value").trim();
            var s_attrib = $('#specimen_attrib').attr("value");
            var sid = $('#session_num').attr("value").trim();
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            if(sid == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
                return;
            }
            var params = $('#session_report_form').formSerialize();
            var url = "ajax/reports_specimen_entries.php?"+params;
            $('#session_report_progress_spinner').show();
            $('#specimens_fetched').load(url, function() {
                $('#session_report_progress_spinner').hide();
            });
        }

        function get_specimen_log()
        {
            var location = $('#location12').attr("value");
            var sid = $('#specimen_id12').attr("value");
            if(location == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_SELECTSITE']; ?>");
                return;
            }
            if(sid == "")
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>");
                return;
            }
            $('#specimen_log_form').submit();
        }

        function print_daily_patientBarcodes()
        {
            var l = $("#location13").attr("value");
            var yf = $("#daily_yyyy").attr("value");
            var mf = $("#daily_mm").attr("value");
            var df = $("#daily_dd").attr("value");
            var yt = $("#daily_yyyy_to").attr("value");
            var mt = $("#daily_mm_to").attr("value");
            var dt = $("#daily_dd_to").attr("value");

            if(checkDate(yt, mt, dt) == false || checkDate(yf, mf, df) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            var url = "reports_dailypatientBarcodes.php?yt="+yt+"&mt="+mt+"&dt="+dt+"&yf="+yf+"&mf="+mf+"&df="+df+"&l="+l;
            window.open(url);
        }

        function print_daily_patients()
        {
            var l = $("#location13").attr("value");
            var yf = $("#daily_yyyy").attr("value");
            var mf = $("#daily_mm").attr("value");
            var df = $("#daily_dd").attr("value");
            var yt = $("#daily_yyyy_to").attr("value");
            var mt = $("#daily_mm_to").attr("value");
            var dt = $("#daily_dd_to").attr("value");

            var cat_code = $('#cat_code13').attr("value");

            if(checkDate(yt, mt, dt) == false || checkDate(yf, mf, df) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            var url = "reports_dailypatients.php?yt="+yt+"&mt="+mt+"&dt="+dt+"&yf="+yf+"&mf="+mf+"&df="+df+"&l="+l+"&labsec="+cat_code;
            window.open(url);
        }

        function print_daily_specimens()
        {
            var l = $("#location13").attr("value");
            var yf = $("#daily_yyyy").attr("value");
            var mf = $("#daily_mm").attr("value");
            var df = $("#daily_dd").attr("value");
            var yt = $("#daily_yyyy_to").attr("value");
            var mt = $("#daily_mm_to").attr("value");
            var dt = $("#daily_dd_to").attr("value");

            if(checkDate(yt, mt, dt) == false || checkDate(yf, mf, df) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            var cat_code = $('#cat_code13').attr("value");
            var ttype = $('#ttype13').attr("value");
            var ip= 0;
            var p=0;
            var url = "reports_dailyspecimens.php?yt="+yt+"&mt="+mt+"&dt="+dt+"&yf="+yf+"&mf="+mf+"&df="+df+"&l="+l+"&c="+cat_code+"&t="+ttype+"&ip="+ip;
            window.open(url);
        }

        function print_daily_log()
        {
            var record_type = $("input[name='rectype13']:checked").attr("value");
            if(record_type == 1)
            {
                print_daily_specimens();
            }
            else if (record_type == 2)
            {
                print_daily_patients();
            }
            else {
                print_daily_patientBarcodes();
            }
        }

        function get_stock_report()
        {
            // Validate
            var l = $("#location15").attr("value");
            var y_from = $("#yyyy_from15").attr("value");
            var m_from = $("#mm_from15").attr("value");
            var d_from = $("#dd_from15").attr("value");
            var y_to = $("#yyyy_to15").attr("value");
            var m_to = $("#mm_to15").attr("value");
            var d_to = $("#dd_to15").attr("value");
            var cat_code = $("#cat_code15").attr("value");

            if(checkDate(y_from, m_from, d_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }

            if(checkDate(y_to, m_to, d_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            // All okay

            $('#stock_report_form').submit();
        }

        function get_control_report()
        {
            // Validate
            var dateError = "From date cannot be beyond To date";
            var l = $("#location15").attr("value");
            var y_from = $("#yyyy_from15").attr("value");
            var m_from = $("#mm_from15").attr("value");
            var d_from = $("#dd_from15").attr("value");
            var y_to = $("#yyyy_to15").attr("value");
            var m_to = $("#mm_to15").attr("value");
            var d_to = $("#dd_to15").attr("value");
            var cat_code = $("#cat_code15").attr("value");

            if(checkDate(y_from, m_from, d_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }

            if(checkDate(y_to, m_to, d_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }

            $('#control_testing_error').hide();
            var test_type_id = $('#verify_test_type_control').attr("value");
            if(test_type_id == "")
            {
                $('#control_testing_error').show();
                return;
            }
            // All okay

            //$('#control_report_form').submit();
        }

        function get_infection_report_aggregate() {
            var l = $("#location14").attr("value");
            var y_from = $("#yyyy_from14").attr("value");
            var m_from = $("#mm_from14").attr("value");
            var d_from = $("#dd_from14").attr("value");
            var y_to = $("#yyyy_to14").attr("value");
            var m_to = $("#mm_to14").attr("value");
            var d_to = $("#dd_to14").attr("value");
            var cat_code = $('#cat_code14').attr("value");
            if(checkDate(y_from, m_from, d_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(checkDate(y_to, m_to, d_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            // All okay
            $('#infection_aggregate_form').submit();
        }

        function get_disease_report()
        {
            // Validate
            var l = $("#location14").attr("value");
            var y_from = $("#yyyy_from14").attr("value");
            var m_from = $("#mm_from14").attr("value");
            var d_from = $("#dd_from14").attr("value");
            var y_to = $("#yyyy_to14").attr("value");
            var m_to = $("#mm_to14").attr("value");
            var d_to = $("#dd_to14").attr("value");
            var cat_code = $('#cat_code14').attr("value");
            if(checkDate(y_from, m_from, d_from) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            if(checkDate(y_to, m_to, d_to) == false)
            {
                alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
                return;
            }
            // All okay
            $('#disease_report_form').submit();
        }

        function show_custom_report_form(report_id)
        {
            var url_string = "report_custom.php?rid="+report_id;
            window.location = url_string;
        }

        function hideCondition(p_attrib)
        {
            if(parseInt(p_attrib)==1)
                $('#h_attrib').show();
            else
                $('#h_attrib').hide();
        }

        function showSiteAggForm(){
            $("#test_aggregate_report_div").hide();
            $("#site_aggregate_report_div").show();

        }

        function showLabAggForm(){
            $("#test_aggregate_report_div").show();
            $("#site_aggregate_report_div").hide();
        }

        function get_reference_range() {

           
            $('#test_type_id_details').html("");
            $selected_test_type_id = $('#test_type_id_1').attr('value');
            if($selected_test_type_id !='0')
            {
                $.ajax({
                    url : "ajax/getTestReferenceRange.php?id="+$selected_test_type_id,
                    success : function(data) 
                    {
                        var objData = JSON.parse(data);
                        var html = "<form>"+
                                "<table class='hor-minimalist-b'>"+
                                "<tr>"+
                                    "<th></th>"+
                                            "<th><b>Test Reference Range</b></th>"+
                                "</tr>"+
                                "<tr>"+
                                "<td>Test Type :</td>"+
                                "<td>Sex :</td>"+
                                "<td>Ranage-Lower :</td>"+
                                "<td>Range-Upper :</td>"+
                                "<td>Age-Min :</td>"+
                                "<td>Age-Max :</td>"+
                                "</tr>";
                        for (var c_i = 0; c_i < objData.length; c_i++){
                        
                             html+="<tr>"+
                                "<td><input type='text' id = 'name' value = '"+objData[c_i].name+"'></td>  "+ 
                                "<td><input type='text' id = 'name' value = '"+objData[c_i].sex+"'></td>  "+                                
                                "<td><input type='text' id = 'range_lower' value = '"+objData[c_i].range_lower+"'></td>  "+
                                "<td><input type='text' id = 'range_upper' value = '"+objData[c_i].range_upper+"'></td>  "+
                                "<td><input type='text' id = 'range_lower' value = '"+objData[c_i].age_min+"'></td>  "+
                                "<td><input type='text' id = 'range_upper' value = '"+objData[c_i].age_max+"'></td>  "+
                                "</tr>"
                                "</table> "+
				                "</form>";                        
                             }
                             $('#test_type_id_details').html(html);   
                }});
            }
        }

    </script>
    <br>
    <table name="page_panes" cellpadding="10px">
        <tr valign='top'>
            <td id='left_pane' width='200px'>
                <?php
                $site_list = get_site_list($_SESSION['user_id']);
                $user = get_user_by_id($_SESSION['user_id']);
                if (!is_country_dir($user)) {
                    echo LangUtil::$pageTerms['MENU_DAILY']; ?>
                    <ul>
                        <!--
				<li class='menu_option' id='patient_report_menu'>
					<a href='javascript:show_patient_report_form();'><?php #echo LangUtil::$pageTerms['MENU_PATIENT'];?></a>
				</li>
				-->
                        <li class='menu_option' id='test_history_menu'>
                            <!--<a href='javascript:show_test_history_form();'><?php #echo LangUtil::$pageTerms['MENU_PHISTORY'];?></a>-->
                            <a href='javascript:show_test_history_form();'><?php echo LangUtil::$pageTerms['MENU_PATIENT']; ?></a>
                        </li>
                        <li class='menu_option' id='session_report_menu' <?php
                        if ($SHOW_SPECIMEN_REPORT === false) {
                            echo " style='display:none;' ";
                        } ?>>
                            <a href='javascript:show_session_report_form();'><?php echo LangUtil::$pageTerms['MENU_SPECIMEN']; ?></a>
                        </li>
                        <li class='menu_option' id='print_menu' <?php
                        if ($SHOW_TESTRECORD_REPORT === false) {
                            echo " style='display:none;' ";
                        } ?>>
                            <a href='javascript:show_print_form();'><?php echo LangUtil::$pageTerms['MENU_TESTRECORDS']; ?></a>
                        </li>

                        <li class='menu_option' id='daily_report_menu'>
                            <a href='javascript:show_daily_report_form();'><?php echo LangUtil::$pageTerms['MENU_DAILYLOGS']; ?></a>
                        </li>
                        <li class='menu_option' id='print_menu' <?php
                        if ($SHOW_PENDINGTEST_REPORT === false) {
                            echo " style='display:none;' ";
                        } ?>>
                            <a href='javascript:show_pending_tests_form();'><?php echo LangUtil::$pageTerms['MENU_PENDINGTESTS']; ?></a>
                        </li>

                        <li class='menu_option' id='user_test_result_range_menu'>
                                <a href='javascript:show_selection("test_results_range");'>Test Statistics</a>
                        </li>


                        <?php
                        # Space for menu entries corresponding to a new daily report
                        # PLUG_DAILY_REPORT_ENTRY
                        ?>

                    </ul>
                <?php
                } else { ?>
                    <?php echo "Report Settings"; ?>
                    <ul>
                        <li class='menu_option' id='location_settings' >
                            <a href='lab_pin.php'><?php echo "Location Settings"; ?></a>
                        </li>
                        <li class='menu_option' id='specimen_aggregate_report_config_menu' >
                            <a href='javascript:show_selection("specimen_aggregate_report_config");'><?php echo LangUtil::$pageTerms['MENU_TEST_SPECIMEN_AGGREGATE_REPORT_CONFIG']; ?></a>
                        </li>
                    </ul>
                <?php } echo LangUtil::$pageTerms['MENU_AGGREPORTS']; ?>
                <ul>
                    <?php
                    $site_list = get_site_list($_SESSION['user_id']);
                    if (is_country_dir(get_user_by_id($_SESSION['user_id']))) { ?>
                        <li class='menu_option' id='country_aggregate_menu'>
                            <a href='javascript:show_selection("prevalance_aggregate");'><?php echo LangUtil::$pageTerms['MENU_INFECTIONSUMMARY']; ?></a>
                        </li>
                        <li class='menu_option' id='tat_menu'>
                            <a href='javascript:show_selection("tat_aggregate");'><?php echo LangUtil::$pageTerms['MENU_TAT']; ?></a>
                        </li>
                        <li class='menu_option' id='specimen_aggregate_report_form_menu'>
                            <a href='javascript:show_selection("specimen_aggregate_report_form");'><?php echo LangUtil::$pageTerms['MENU_SPECIMEN_AGGREGATE_REPORT_FORM']; ?></a>
                        </li>
                        <li class='menu_option' id='test_aggregate_reports_form_menu'>
                            <a href='javascript:show_selection("test_aggregate_report_form");'><?php echo LangUtil::$pageTerms['MENU_TEST_AGGREGATE_REPORT_FORM']; ?></a>
                        </li>


                        <!--<li class='menu_option' id='disease_report_menu'>
							<a href='javascript:show_selection("infection_aggregate");'><?php echo LangUtil::$pageTerms['MENU_INFECTIONREPORT']; ?></a>
						</li>-->
                    <?php } else { ?>
                        <li class='menu_option' id='summary_menu'>
                            <a href='javascript:show_selection("summary");'><?php echo LangUtil::$pageTerms['MENU_INFECTIONSUMMARY']; ?></a>
                        </li>
                        <li class='menu_option' id='specimen_count_menu'>
                            <a href='javascript:show_selection("specimen_count");'><?php echo LangUtil::$pageTerms['MENU_COUNTS']; ?></a>
                        </li>
                        <li class='menu_option' id='tat_menu'>
                            <a href='javascript:show_selection("tat");'><?php echo LangUtil::$pageTerms['MENU_TAT']; ?></a>
                        </li>
                        <li class='menu_option' id='disease_report_menu'>
                            <a href='javascript:show_selection("disease_report");'><?php echo LangUtil::$pageTerms['MENU_INFECTIONREPORT']; ?></a>
                        </li>
                        <?php if (is_admin(get_user_by_id($_SESSION['user_id']))) { ?>
                            <li class='menu_option' id='user_stats_menu'>
                                <a href='javascript:show_selection("user_stats");'>User Statistics</a>
                            </li>
                        <?php } ?>
                        


                        <!--<li class='menu_option' id='stock_report_menu'>
							<a href='javascript:show_selection("stock_report");'>Previous Inventory Data</a>
						</li>-->
                        <li class="menu_option" id="test_agg_reports_menu">
                            <a href="javascript:show_test_agg_reports_div();">
                                <?php echo LangUtil::$pageTerms['MENU_TESTWISE_REPORTS']; ?>
                            </a>
                        </li>


                    <?php } ?>
                    <?php /*
                if( is_country_dir( get_user_by_id($_SESSION['user_id'] ) ) ) { ?>
                    <li class='menu_option' id='country_aggregate_menu'>
                    <a href='javascript:show_selection("country_aggregate");'>Country Level Aggregation</a>
                    </li>
                <?php }
                /*
                <li class='menu_option' id='control_tests_menu'>
                    <a href='javascript:show_control_test_form();'><?php echo LangUtil::$pageTerms['MENU_CONTROLREPORT']; ?></a>
                </li>
                */
                    # Space for menu entries corresponding to a new aggregate report
                    # PLUG_AGGREGATE_REPORT_ENTRY
                    ?>

                </ul>
            </td>
            <td></td>

            <td id="right_pane" class="right_pane" valign='top'>
                <div id='reports_div' style='display:none;' class='reports_subdiv'>
                    <b>Patient Results Report</b>
                    <br><br>
                    <form name="get_patient_report" id="get_patient_report" action="reports_patient.php" method='post'>
                        <table cellpadding="4px">
                            <tr class="location_row" id="location_row">
                                <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                <td>
                                    <?php
                                    $site_list = get_site_list($_SESSION['user_id']);
                                    if (count($site_list) == 1) {
                                        foreach ($site_list as $key=>$value) {
                                            echo "<input type='hidden' name='location' id='location' value='$key'></input>";
                                        }
                                    } else {
                                        ?>
                                        <select name='location' id='location' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?php
                            $today = date("Y-m-d");
                            $today_array = explode("-", $today);
                            $monthago_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($today)) . " -270 days"));//getStartDate();
                            $monthago_array = explode("-", $monthago_date);
                            ?>

                            <tr class="type_row" id="type_row">
                                <td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                                <td>
                                    <SELECT NAME="t_type" id="t_type" class='uniform_width'>
                                        <OPTION VALUE='' selected='selected'>Select..</option>
                                    </SELECT>
                                </td>
                            </tr>

                            <tr class="sdate_row" id="sdate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = $name_list;
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>

                            <tr class="edate_row" id="edate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?>&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = $name_list;
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                </td>
                                <td>
                                    <br>
                                    <input type="button" value="<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>" onclick="get_patient_reports();"/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='report_progress_bar' style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='summary_div' style='display:none;' class='reports_subdiv'>
                    <b><?php echo LangUtil::$pageTerms['MENU_INFECTIONSUMMARY']; ?></b><?php echo getStartDate();?>
                    <br><br>
                    <form name="get_summary" id="get_summary" action="reports_infection.php" method='post'>
                        <table cellpadding="4px">
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location2' value='$key'></input>";
                                }
                            } else {
                                ?>

                                <tr class="location_row" id="location_row">
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                    <td>
                                        <select name='location' id='location2' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from2", "mm_from2", "dd_from2");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to2", "mm_to2", "dd_to2");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <?php
                            if (count($site_list) > 1) { ?>
                                <tr id='testType'>
                                    <td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></td>
                                    <td>
                                        <select name='ttype' id='ttype' class='uniform_width' onchange='changeAvailableLocations(this)'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getTestTypesCountrySelect();
                                            ?>
                                        </select>
                                    </td>
                                </tr>
<!--                                <tr class="location_row_aggregate" id="location_row_aggregate">
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                    <td id='locationAggregation'>
                                        <input type='checkbox' name='locationAgg' id='locationAgg' value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></input>
                                        <?php
                                        $page_elems->getSiteOptionsCheckBoxes("locationAgg");
                                        ?>
                                    </td>
                                </tr>-->
                                <?php
                            } else {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location2' value='$key'></input>";
                                }
                            }
                            ?>
                            <tr>
                                <td>
                                    <INPUT TYPE=RADIO NAME="summary_type" id="summary_type" VALUE="C" style="display:none;" checked />
                                    &nbsp;&nbsp;
                                    <INPUT TYPE=RADIO NAME="summary_type" style="display:none;" VALUE="M" />
                                </td>
                                <td>
                                    <br>
                                    <input type="button" value="<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>" onclick="get_summary_fn(0);"/>
                                    &nbsp;&nbsp;
                                    <!--<input type="button" value="View Monthly" onclick="get_summary_fn(1);"/>-->
                                    <!--<br><br>-->
                                    <span id='summary_progress_bar'  style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='pending_tests_div'  style='display:none;' class='reports_subdiv'>
                    <b><?php echo LangUtil::$pageTerms['MENU_PENDINGTESTS']; ?></b>
                    <?php
                    if ($SHOW_TESTRECORD_REPORT === true) {
                        ?>
                        |
                        <a href='javascript:show_print_form()'><?php echo LangUtil::$pageTerms['MENU_TESTRECORDS']; ?></a>
                        <?php
                    }
                    ?>
                    <br><br>
                    <form name="pending_tests_form" id="pending_tests_form" action="reports_pending.php" method='post'>
                        <table cellpadding="4px">
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location3' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr class="location_row" id="location_row">
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                    <td>
                                        <select name='location' id='location3' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></td>
                                <td>
                                    <select name='test_type' id='t_type3' class='uniform_width'>
                                        <OPTION VALUE='' selected='selected'>Select..</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' id='pending_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick="javascript:get_pending_report();"></input>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='pending_progress_spinner' style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='doctors_stats_div' style='display:none;' class='reports_subdiv'>
                    <b>Test Count Report</b>
                    <br><br>
                    <form name="doctors_stats_form" id="doctors_stats_form" action="doctor_stats.php" method='post'>
                        <table cellpadding="4px">
                            <?php
                            $site_list = get_site_list_with_labid($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location8' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr>
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                    <td>
                                        <select name='location' id='location8' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from8", "mm_from8", "dd_from8");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to8", "mm_to8", "dd_to8");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' id='tests_done_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick="javascript:get_doctor_stats();"></input>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='tests_done_progress_spinner' style='display:none'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='tests_done_div' style='display:none;' class='reports_subdiv'>
                    <b>Test Count Report</b>
                    <br><br>
                    <form name="tests_done_form" id="tests_done_form" action="reports_tests_done.php" method='post'>
                        <table cellpadding="4px">
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location4' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr>
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                    <td>
                                        <select name='location' id='location4' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from4", "mm_from4", "dd_from4");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to4", "mm_to4", "dd_to4");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' id='tests_done_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick="javascript:get_tests_done_report();"></input>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='tests_done_progress_spinner' style='display:none'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='testcount_grouped_div' style='display:none;' class='reports_subdiv'>
                    <b>Test Count Report</b>
                    <br><br>
                    <form name="testcount_grouped_form" id="testcount_grouped_form" action="reports_testcount_grouped.php" method='post' target='_blank'>
                        <table cellpadding="4px">
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location44' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr>
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                    <td>
                                        <select name='location' id='location44' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from44", "mm_from44", "dd_from44");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to44", "mm_to44", "dd_to44");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' id='testcount_grouped_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick="javascript:get_tests_done_report();" ></input>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='tests_done_progress_spinner' style='display:none'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='specimencount_grouped_div' style='display:none;' class='reports_subdiv'>
                    <b>Test Count Report</b>
                    <br><br>
                    <form name="specimencount_grouped_form" id="specimencount_grouped_form" action="reports_specimencount_grouped.php" method='post' target='_blank'>
                        <table cellpadding="4px">
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location444' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr>
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                    <td>
                                        <select name='location' id='location444' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from444", "mm_from444", "dd_from444");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to444", "mm_to444", "dd_to444");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' id='specimencount_grouped_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick="javascript:get_tests_done_report();" ></input>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='tests_done_progress_spinner' style='display:none'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='tat_div' style='display:none;' class='reports_subdiv'>
                    <b><?php echo LangUtil::$pageTerms['MENU_TAT']; ?></b>
                    <br><br>
                    <form name="tat_form" id="tat_form" action="reports_tat.php" method='post'>
                        <table cellpadding="4px">
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location5' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr>
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                    <td>
                                        <select name='location' id='location5' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from5", "mm_from5", "dd_from5");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to5", "mm_to5", "dd_to5");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$pageTerms['MSG_INCLUDEPENDING']; ?> </td>
                                <td>
                                    <input type='radio' value='Y' name='pending'><?php echo LangUtil::$generalTerms['YES']; ?></input>
                                    <input type='radio' value='N' name='pending' checked><?php echo LangUtil::$generalTerms['NO']; ?></input>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' id='tat_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick="javascript:get_tat_report();"></input>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='tat_progress_spinner' style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='tat_aggregate_div' style='display:none;' class='reports_subdiv'>
                    <b><?php echo LangUtil::$pageTerms['MENU_TAT']; ?></b>
                    <br><br>
                    <form name="tat_aggregate_form" id="tat_aggregate_form" action="geo_report_dir_tat.php" method='post'>
                        <table cellpadding="4px">
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from5", "mm_from5", "dd_from5");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to5", "mm_to5", "dd_to5");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>

                            <tr id='testType'>
                                <td><?php echo LangUtil::$generalTerms['TEST']; ?></td>
                                <td>
                                    <select name='testTypeCountry' id='testTypeCountry' class='uniform_width' onchange='changeAvailableLocations(this)'>
                                        <!--<option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>-->
                                        <?php
                                        $page_elems->getTestTypesCountrySelect();
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr class="location_row_aggregate" id="location_row_aggregate">
                                <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td id='locationAggregation'>
                                    <!--<input type='checkbox' name='locationAgg' id='locationAgg' value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></input>-->
                                    <?php
                                    $page_elems->getSiteOptionsCheckBoxes("locationAgg[]");
                                    ?>
                                </td>
                            </tr>
                            <!--<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['MSG_INCLUDEPENDING']; ?> </td>
					<td>
						<input type='radio' value='Y' name='pending'><?php echo LangUtil::$generalTerms['YES']; ?></input>
						<input type='radio' value='N' name='pending' checked><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo "Time Division"; ?></td>
					<td>
					<select name='tattype' id='tattype' style='font-family:Tahoma;'>
						<option value='m'><?php echo LangUtil::$pageTerms['PROGRESSION_M']; ?></option>
						<option value='w' selected><?php echo LangUtil::$pageTerms['PROGRESSION_W']; ?></option>
						<option value='d'><?php echo LangUtil::$pageTerms['PROGRESSION_D']; ?></option>
					</select>
					</td>
				</tr>-->
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' id='tat_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick="javascript:submit_tat_aggregate_form();"></input>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='tat_progress_spinner' style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id='specimen_aggregate_report_form_div' style='display:none;' class='reports_subdiv'>
                    <b><?php echo LangUtil::$pageTerms['MENU_SPECIMEN_AGGREGATE_REPORT_FORM']; ?></b>
                    <br><br>


                    <form name="specimen_aggregate_report_form" id="specimen_aggregate_report_form" action="specimen_aggregate_report.php" method='post'>
                        <table cellpadding="4px">
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from9", "mm_from9", "dd_from9");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to9", "mm_to9", "dd_to9");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>

                            <tr class="location_row_aggregate" id="location_row_aggregate">
                                <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td id='locationAggregation'>
                                    <!--<input type='checkbox' name='locationAgg' id='locationAgg' value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></input>-->
                                    <?php
                                    $page_elems->getSiteOptionsCheckBoxesCountryDir("locationAgg[]");
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <br>

                                    <input type='button' id='specimen_aggregate_report_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_GET_SPECIMEN_REPORT']; ?>' onclick="javascript:submit_specimen_aggregate_report_form();"></input>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='test_specimen_aggregate_report_form_progress_spinner' style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id='test_aggregate_report_form_div' style='display:none;' class='reports_subdiv'>
                    <h4><a href="javascript:showLabAggForm()">Lab-Wise</a>&nbsp;| &nbsp;
                        <a href="javascript:showSiteAggForm()">Site-Wise</a>
                    </h4>
                    <div id='test_aggregate_report_div' >
                    <b><?php echo LangUtil::$pageTerms['MENU_TEST_AGGREGATE_REPORT_FORM']; ?></b>
                    <br><br>

                    <form name="test_aggregate_report_form" id="test_aggregate_report_form" action="tests_aggregate_report.php" method='post'>
                        <table cellpadding="4px">
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from_labs", "mm_from_labs", "dd_from_labs");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to_labs", "mm_to_labs", "dd_to_labs");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>

                            <tr class="location_row_aggregate" id="location_row_aggregate">
                                <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td id='locationAggregation'>
                                    <!--<input type='checkbox' name='locationAgg' id='locationAgg' value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></input>-->
                                    <?php
                                    $page_elems->getSiteOptionsCheckBoxesCountryDir("locationAgg[]");
                                    ?>
                                </td>
                            </tr>

                            <tr class=results_aggregate" id="results_aggregate">
                                <td>Aggregate by<?php echo LangUtil::$generalTerms['AGGREGATION_BY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td id='resultsAggregation'>
                                    <input type="radio" name="resultAgg" value="common"> Common Tests<br>
                                    <input type="radio" name="resultAgg" value="all"> All Tests
                                </td>
                            </tr>


                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' id='test_aggregate_report_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_GET_TEST_REPORT']; ?>' onclick="javascript:submit_test_aggregate_report_form();"></input>

                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='test_aggregate_report_form_progress_spinner' style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                    </div>

                    <!---------------->
                    <div id="site_aggregate_report_div" style="display:none">
                    <b><?php echo "Site-wise Report"/*echo LangUtil::$pageTerms['MENU_TESTWISE_REPORTS']; */?></b>
                    <br><br>
                    <form name="site_agg_reports_form" id="site_agg_reports_form"
                          action="reports/site_aggregate_report.php" method="post">
                        <input type="hidden" id="lab_config_id" value="<?php echo $lab_config_id; ?>">
                        <table cellpadding="4px">
                            <tr valign="top">
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?></td>
                                <td>
                                    <?php
                                    $name_list = array('yyyy_from', 'mm_from', 'dd_from');
                                    $id_list = array('yyyy_from_site', 'mm_from_site', 'dd_from_site');
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?></td>
                                <td>
                                    <?php
                                    $name_list = array('yyyy_to', 'mm_to', 'dd_to');
                                    $id_list = array('yyyy_to_site', 'mm_to_site', 'dd_to_site');
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>

                            <tr valign="top">
                                <td><?php echo LangUtil::$pageTerms['SITE']; ?></td>
                                <td>

                                    <?php $page_elems->getCollectionSitesOptions2($lab_config_id); ?>

                                </td>
                            </tr>
                            <tr class=results_aggregate" id="results_aggregate">
                                <td>Aggregate by<?php echo LangUtil::$generalTerms['AGGREGATION_BY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td id='resultsAggregation'>
                                    <input type="radio" name="resultAgg" value="common"> Common Tests<br>
                                    <input type="radio" name="resultAgg" value="all"> All Tests
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type="button" id="test_agg_reports_form_submit"
                                           value="<?php echo LangUtil::$generalTerms['CMD_GETREPORT']; ?>"
                                           onclick="submit_site_agg_report_form();">
                                    &nbsp; &nbsp; &nbsp;
                                    <span id="test_agg_report_spinner" style="display: none;">
								<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
							</span>
                                </td>
                            </tr>


                        </table>
                    </form>

                    </div>
                    <!---------------->

                </div>
                <div id='specimen_aggregate_report_config_div' style='display:none;' class='reports_subdiv'>
                    <p style="text-align: right;"><a rel='facebox' href='#IR_rc'>Page Help</a></p>
                    <b><?php echo "Test/Specimen Count Grouped Reports"; ?></b>
                    <a href='javascript:toggle_specimen_aggregate_report();' id='specimen_aggregate_edit_link'><?php echo LangUtil::$generalTerms['CMD_EDIT']; ?></a>
                    <br><br>

                    <br>
                    <div id='specimen_aggregate_report_summary'>
                        <?php echo $page_elems->getGroupedCountReportSummaryCountryDir($lab_config); ?>
                    </div>
                    <div id='specimen_aggregate_report_config_form_div' style='display:none;'>
                        <form id='specimen_aggregate_report_config_form' name='specimen_aggregate_report_config_form' action='ajax/specimen_aggregate_reports_update.php' method='post'>
                            <?php $page_elems->getGroupedCountReportConfigureFormCountryDir($lab_config); ?>
                        </form>

                    </div>
                </div>
                <div id='print_div' style='display:none;' class='reports_subdiv'>
                    <span id='test_report_title'><b><?php echo LangUtil::$pageTerms['MENU_TESTRECORDS']; ?></b></span> | <span id='view_pending_title'><a href='javascript:show_pending_tests_form()'><?php echo LangUtil::$pageTerms['MENU_PENDINGTESTS']; ?></a></span>
                    <br><br>
                    <form name="get_print" id="get_print" method="post" action="reports_print.php" target="_blank">
                        <table cellpadding="4px">
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location6' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr class="location_row" id="location_row">
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                    <td>
                                        <select name='location' id='location6' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                            <tr class="type_row" id="type_row">
                                <td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                                <td>
                                    <SELECT NAME="t_type" id="t_type6" class='uniform_width'>
                                        <OPTION VALUE='' selected='selected'><?php echo LangUtil::$generalTerms['CMD_SELECT']; ?>..</option>
                                    </SELECT>
                                </td>
                            </tr>

                            <tr class="sdate_row" id="sdate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from6", "mm_from6", "dd_from6");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>

                            <tr class="edate_row" id="edate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?>&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to6", "mm_to6", "dd_to6");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <br>
                                    <input type="button" value="<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>" onclick="get_print_page();" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='print_progress_bar' style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='specimen_count_div' style='display:none;' class='reports_subdiv'>
                    <b><?php echo LangUtil::$pageTerms['MENU_COUNTS']; ?></b>
                    <br><br>
                    <form name="specimen_count_form" id="specimen_count_form" action="reports_specimencount.php" method='post'>
                        <table cellpadding="4px">
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location7' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr>
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                    <td>
                                        <select name='location' id='location7' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from7", "mm_from7", "dd_from7");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to7", "mm_to7", "dd_to7");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>

                            <tr valign='top'>
                                <td><?php echo LangUtil::$pageTerms['COUNT_TYPE']; ?></td>
                                <td>
                                    <input type='radio' id='count_type' name='count_type' value='2' checked>
                                    <?php echo LangUtil::$pageTerms['COUNT_TEST']." (Ungrouped)"; ?>
                                    </input>
                                    <br>
                                    <input type='radio' id='count_type' name='count_type' value='4' checked>
                                    <?php echo LangUtil::$pageTerms['COUNT_TEST']." (Grouped)"; ?>
                                    </input>
                                    <br>
                                    <input type='radio' id='count_type' name='count_type' value='1'>
                                    <?php echo LangUtil::$pageTerms['COUNT_SPECIMEN']." (Ungrouped)"; ?>
                                    </input>
                                    <br>
                                    <input type='radio' id='count_type' name='count_type' value='5'>
                                    <?php echo LangUtil::$pageTerms['COUNT_SPECIMEN']." (Grouped)"; ?>
                                    </input>
                                    <br>
                                    <input type='radio' id='count_type' name='count_type' value='3'>
                                    <?php echo "Doctor Statistics" ?>
                                    </input>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' id='specimen_count_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:get_count_report()'>
                                    </input>
                                    <!--
						--Merged into single submit button--
						<input type='button' id='specimen_count_submit_button' value='Specimen Count' onclick="javascript:get_specimen_count_report();"></input>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='button' value='Test Count' onclick="javascript:get_tests_done_report2();"></input>
						-->
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id='specimen_count_progress_spinner' style='display:none'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='user_stats_div' style='display:none;' class='reports_subdiv'>
                    <b><?php echo "User Statistics"; ?></b>
                    <?php $userStats = new UserStats(); ?>
                    <!--<br><br>

                <a id="ustats_a" class="ustats_link_u" href='javascript:show_user_stats_submenu(1);'>User Stats for All Users</a>
                |
                <a id="ustats_i" class="ustats_link_u" href='javascript:show_user_stats_submenu(2);'>User Logs for Individual Users</a>

                <br><br>-->


                    <form name="user_stats_form" id="user_stats_form" action="reports_user_stats_all.php" method='post' target='_blank'>
                        <table cellpadding="4px">

                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from7", "mm_from7", "dd_from7");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to7", "mm_to7", "dd_to7");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>

                            <tr valign='top'>
                                <td><?php echo "Stat Type" ?></td>
                                <td>

                                    <input type='radio' id='stat_type' name='stat_type' value='a' onclick="user_radio(1)">
                                    <?php echo "Collective User Stats"; ?>
                                    </input>
                                    <br>
                                    <input type='radio' id='stat_type' name='stat_type' value='i' onclick="user_radio(2)">
                                    <?php echo "Individual User Logs"; ?>
                                    </input>

                                </td>
                            </tr>
                        </table>
                        <div id='user_stats_all' style='display:none;'>
                            <table cellpadding="4px">
                                <tr valign='top'>
                                    <td><?php echo LangUtil::$pageTerms['COUNT_TYPE'] ?></td>
                                    <td>
                                        <input type='checkbox' id='count_type_pr' name='count_type_pr' value='Yes' checked>
                                        <?php echo "Patients Registered"; ?>
                                        </input>
                                        <br>
                                        <input type='checkbox' id='count_type_sr' name='count_type_sr' value='Yes' checked>
                                        <?php echo "Specimens Registered"; ?>
                                        </input>
                                        <br>
                                        <input type='checkbox' id='count_type_tr' name='count_type_tr' value='Yes' checked>
                                        <?php echo "Tests Registered"; ?>
                                        </input>
                                        <br>
                                        <input type='checkbox' id='count_type_re' name='count_type_re' value='Yes' checked>
                                        <?php echo "Results Entered"; ?>
                                        </input>
                                        <br>

                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <br>
                                        <input type='submit' id='user_stats_all_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'>
                                        </input>
                                        <!--
						--Merged into single submit button--
						<input type='button' id='specimen_count_submit_button' value='Specimen Count' onclick="javascript:get_specimen_count_report();"></input>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='button' value='Test Count' onclick="javascript:get_tests_done_report2();"></input>
						-->
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <span id='specimen_count_progress_spinner' style='display:none'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                    </td>
                                </tr>
                            </table>
                        </div>




                        <div id='user_stats_individual' style='display:none;'>
                            <table cellpadding="4px">
                                <?php
                                $site_list = get_site_list($_SESSION['user_id']);
                                //if(count($site_list) == 1)
                                if (true) {
                                    //foreach($site_list as $key=>$value)
                                    //echo "<input type='hidden' name='location' id='location7' value='$key'></input>";
                                    $liddd = $_SESSION['lab_config_id'];
                                    echo "<input type='hidden' name='location' id='location7' value='$liddd'></input>";

                                    $user_ids = array();
                                    array_push($user_ids, $userStats->getAdminUser($lab_config_id));
                                    $user_ids_others =  $userStats->getAllUsers($lab_config_id);
                                    foreach ($user_ids_others as $uids) {
                                        array_push($user_ids, $uids);
                                    }
                                    //print_r($user_ids);?>
                                    <tr>
                                        <td><?php echo "User"; ?> </td>
                                        <td>
                                            <select name='user_id' id='user_id' class='uniform_width'>
                                                <?php foreach ($user_ids as $uid) {?>
                                                    <option value='<?php echo $uid; ?>'><?php echo get_username_by_id($uid); ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr>
                                        <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                        <td>
                                            <select name='location' id='location7' class='uniform_width'>
                                                <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                                <?php
                                                $page_elems->getSiteOptions(); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                                <tr valign='top'>
                                    <td><?php echo "Log Type"; ?></td>
                                    <td>
                                        <input type='radio' id='log_type' name='log_type' value='1' checked>
                                        <?php echo "Patients Registry"; ?>
                                        </input>
                                        <br>
                                        <input type='radio' id='log_type' name='log_type' value='2'>
                                        <?php echo "Specimens Registry"; ?>
                                        </input>
                                        <br>
                                        <input type='radio' id='log_type' name='log_type' value='3'>
                                        <?php echo "Tests Registry"; ?>
                                        </input>
                                        <br>
                                        <input type='radio' id='log_type' name='log_type' value='4'>
                                        <?php echo "Results Entry"; ?>
                                        </input>
                                        <br>
                                        <input type='radio' id='log_type' name='log_type' value='5'>
                                        <?php echo "Inventory Transaction"; ?>
                                        </input>
                                        <br>

                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <br>
                                        <input type='submit' id='user_stats_individual_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'>
                                        </input>
                                        <!--
						--Merged into single submit button--
						<input type='button' id='specimen_count_submit_button' value='Specimen Count' onclick="javascript:get_specimen_count_report();"></input>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='button' value='Test Count' onclick="javascript:get_tests_done_report2();"></input>
						-->
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <span id='specimen_count_progress_spinner' style='display:none'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>

                <div id='test_results_range_div' style='display:none;' class='reports_subdiv'>
                    <b><?php echo "Test Statistics"; ?></b>
                    <?php?>
                    <br><br>

                    <form name="test_range_form" id="test__range_form" action="reports_test_range_stats.php" method='post'>
                    <input type="hidden" id="lab_config_id" value="<?php echo $lab_config_id; ?>">
                 
                    <table cellpadding="4px">
                    <tr valign="top">
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?></td>
                                <td>
                                <?php
                                $today = date("Y-m-d");
                                $value_list = explode("-", $today);
                                $name_list = array("daily_yyyy", "daily_mm", "daily_dd");
                                $id_list = $name_list;
                                $page_elems->getDatePicker($name_list, $id_list, $value_list, true);
                                ?>
                            </td>
                            </tr>
                            <tr valign="top">
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?></td>
                                <td>
                                <?php
                                $name_list = array("daily_yyyy_to", "daily_mm_to", "daily_dd_to");
                                $id_list = $name_list;
                                $page_elems->getDatePicker($name_list, $id_list, $value_list, true);
                                ?>
                            </td>
                            </tr>
                            <tr valign="top">
                                <td><?php echo LangUtil::$pageTerms['MENU_TEST_TYPES']; ?></td>
 
                                <td>
                                        <select name='test_type_id_1' id='test_type_id_1' class='uniform_width' onchange="get_reference_range();">                                        
                                               <option value="0">-</option>
                                               <?php $page_elems->getTestTypewithreferencerangeOptions(); ?>
                                        </select>
                                    </td>
                            </tr>
                            <tr>
                                <td colspan="2"><div id="test_type_id_details"></div></td>
                            </tr> 
                            <tr>
                            <td></td>
                            <td>
                                <br>
                                <input type='submit' id='test_results_range_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'>
                                </input>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            </tr>
                    </table>

                </div>



                <div id="test_agg_reports_div" class="reports_subdiv" style="display: none;">
                    <b><?php echo LangUtil::$pageTerms['MENU_TESTWISE_REPORTS']; ?></b>
                    <br><br>
                    <form name="test_agg_reports_form" id="test_agg_reports_form"
                          action="reports/test_agg_report.php" method="post">
                        <input type="hidden" id="lab_config_id" value="<?php echo $lab_config_id; ?>">
                        <table cellpadding="4px">
                            <tr valign="top">
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?></td>
                                <td>
                                    <?php
                                    $name_list = array('yyyy_from', 'mm_from', 'dd_from');
                                    $id_list = array('yyyy_from', 'mm_from', 'dd_from');
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?></td>
                                <td>
                                    <?php
                                    $name_list = array('yyyy_to', 'mm_to', 'dd_to');
                                    $id_list = array('yyyy_to', 'mm1_to', 'dd_to');
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td><?php echo LangUtil::$pageTerms['MENU_TEST_TYPES']; ?></td>
                                <td>
                                    <select id="select_test_for_report" name="select_test_for_report">
                                        <?php
                                        $page_elems->getTestTypesByReportingStatusOptions(1);
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td><?php echo LangUtil::$pageTerms['SITE']; ?></td>
                                <td>
                                    <select id="select_site_for_report"
                                            name="select_site_for_report">
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions();
                                            ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type="button" id="test_agg_reports_form_submit"
                                           value="<?php echo LangUtil::$generalTerms['CMD_GETREPORT']; ?>"
                                           onclick="submit_test_agg_report_form();">
                                    &nbsp; &nbsp; &nbsp;
                                    <span id="test_agg_report_spinner" style="display: none;">
								<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
							</span>
                                </td>
                            </tr>
                        </table>
                    </form>




                </div>

                <div id='test_history_div' class='reports_subdiv'  style='display:none'>
                    <b><?php echo LangUtil::$pageTerms['MENU_PATIENT']; ?></b>
                    <br><br>
                    <form name='test_history_form' id='test_history_form'>
                        <table cellpadding='4px'>
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            $t = $_SESSION['user_id'];
                            // echo "temp";
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    // echo "key = '$key', value = '$value";
                                    echo "<input type='hidden' name='location' id='location8' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr class="location_row" id="location_row">
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?></td>
                                    <td>
                                        <select name='location' id='location8' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td>
                                    <select name='p_attrib' id='p_attrib' style='font-family:Tahoma;' onchange="javascript:hideCondition(this.value);">
                                        <?php $page_elems->getPatientSearchAttribSelect(); ?>
                                    </select><select name='h_attrib' id='h_attrib' style='font-family:Tahoma;'>
                                        <?php $page_elems->getPatientSearchCondition(); ?>

                                    </select>
                                </td>
                                <td>
                                    <input type='text' name='patient_id' id='patient_id8' class='uniform_width'></input>
                                </td>
                            </tr>

                            <tr>
                                <td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <select name='cat_code_patient_report' id='cat_code_patient_report' class='uniform_width'>
                                        <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                        <?php
                                        if (is_country_dir(get_user_by_id($_SESSION['user_id']))) {
                                            $page_elems->getTestCategoryCountrySelect();
                                        } else {
                                            $page_elems->getTestCategorySelect();
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <?php
                                $current_user_id = $_SESSION['user_id'];
                                $current_user = get_user_by_id($current_user_id);
                                if (is_super_admin($current_user)) {
                                    $labs = get_lab_configs($current_user_id); ?>
                                <tr>
                                    <td><?php echo LangUtil::$generalTerms['LOCATION']; ?> &nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                        <select name="lab_config_id8" id="lab_config_id8" form="test_history_form" class='uniform_width'>
                                        <?php
                                            foreach ($labs as $lab) {
                                                $c_lab_id = $lab->id;
                                                $c_lab_name = $lab->name;
                                                echo "<option value='$c_lab_id'>$c_lab_name</option>";
                                            } ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php
                                }
                            ?>
                            <tr>
                                <td></td>
                                <td>
                                    <input type='button' id='submit_button8' name='test_history_button' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>' onclick='search_patient_history();'></input>
                                    &nbsp;&nbsp;&nbsp;
                                    <span id='test_history_progress_spinner'  style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <div id='phistory_list'>
                        </div>
                    </form>
                </div>

                <div id='test_report_div' class='reports_subdiv'  style='display:none'>
                    <b>Single Test Report</b>
                    <br><br>
                    <form name='test_report_form' id='test_report_form' action='reports_test.php' method='post' target='_blank'>
                        <table cellpadding='4px'>
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location9' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr class="location_row" id="location_row">
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                    <td>
                                        <select name='location' id='location9' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></td>
                                <td>
                                    <input type='text' name='specimen_id' id='specimen_id9' class='uniform_width'></input>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></td>
                                <td>
                                    <SELECT NAME="t_type" id="t_type9" class='uniform_width'>
                                        <OPTION VALUE='' selected='selected'>Select..</option>
                                    </SELECT>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type='button' name='test_report_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:get_test_report();'></input>
                                    &nbsp;&nbsp;&nbsp;
                                    <span id='test_report_progress_spinner'  style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='session_report_div' class='reports_subdiv' style='display:none'>
                    <b><?php echo LangUtil::$pageTerms['MENU_SPECIMEN']; ?></b>
                    <br><br>
                    <form name='session_report_form' id='session_report_form' action='reports_session.php' method='post' target='_blank'>
                        <table cellpadding='4px'>
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location11' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr class="location_row" id="location_row">
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
                                    <td>
                                        <select name='location' id='location11' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td>
                                    <select id='specimen_attrib' name='specimen_attrib'>
                                        <option value='1'><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></option>
                                        <option value='2'><?php echo LangUtil::$generalTerms['ACCESSION_NUM']; ?></option>
                                        <option value='3'><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></option>
                                        <option value='4'><?php echo LangUtil::$generalTerms['PATIENT_NAME']; ?></option>
                                    </select>
                                </td>
                                <td>
                                    <input type='text' name='session_num' id='session_num' class='uniform_width'></input>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type='button' id='submit_button11' name='session_report_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:get_session_report();'></input>
                                    &nbsp;&nbsp;&nbsp;
                                    <span id='session_report_progress_spinner'  style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div id='specimens_fetched'>
                    </div>
                </div>

                <div id='daily_report_div' class='reports_subdiv' style='display:none'>
                    <b><?php echo LangUtil::$pageTerms['MENU_DAILYLOGS']; ?></b>
                    <br><br>
                    <table cellpadding='4px'>
                        <tbody>
                        <?php
                        $site_list = get_site_list($_SESSION['user_id']);
                        //echo "test ".count($site_list);
                        //print_r($site_list);
                        if (count($site_list) == 1) {
                            foreach ($site_list as $key=>$value) {
                                echo "<input type='hidden' name='location' id='location13' value='$key'></input>";
                            }
                        } else {
                            ?>
                            <tr class="location_row" id="location_row">
                                <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <select name='location' id='location13' class='uniform_width' onchange='handleChange(this)'>
                                        <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                        <?php
                                        $page_elems->getSiteOptions(); ?>
                                    </select>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?></td>
                            <td>
                                <?php
                                $today = date("Y-m-d");
                                $value_list = explode("-", $today);
                                $name_list = array("daily_yyyy", "daily_mm", "daily_dd");
                                $id_list = $name_list;
                                $page_elems->getDatePicker($name_list, $id_list, $value_list, true);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?></td>
                            <td>
                                <?php
                                $name_list = array("daily_yyyy_to", "daily_mm_to", "daily_dd_to");
                                $id_list = $name_list;
                                $page_elems->getDatePicker($name_list, $id_list, $value_list, true);
                                ?>
                            </td>
                        </tr>

                        <tr valign='top'>
                            <td><?php echo LangUtil::$generalTerms['RECORDS']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <td>
                                <input type='radio' name='rectype13' id='testRec' value='1' checked />
                                <?php echo LangUtil::$generalTerms['RECORDS_TEST']; ?>
                                <br>
                                <input type='radio' name='rectype13' value='2' />
                                <?php echo LangUtil::$generalTerms['RECORDS_PATIENT']; ?>
                                <br/>
                                <input type='radio' name='rectype13' value='3' />
                                <?php echo LangUtil::$generalTerms['PATIENT_BARCODE']; ?>

                            </td>
                        </tr>
                        <tr id='cat_row13'>
                            <td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <td>
                                <select name='cat_code' id='cat_code13' class='uniform_width'>
                                    <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                    <?php
                                    if (is_country_dir(get_user_by_id($_SESSION['user_id']))) {
                                        $page_elems->getTestCategoryCountrySelect();
                                    } else {
                                        $page_elems->getTestCategorySelect();
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr id='ttype_row13'>
                            <td><?php echo LangUtil::$generalTerms['TEST']; ?></td>
                            <td>
                                <select name='ttype' id='ttype13' class='uniform_width'>
                                    <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:print_daily_log()'></input>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div id='daily_report_div' class='reports_subdiv' style='display:none'>
                    <b><?php echo LangUtil::$pageTerms['MENU_DAILYLOGS']; ?></b>
                    <br><br>
                    <table cellpadding='4px'>
                        <tbody>
                        <?php
                        $site_list = get_site_list($_SESSION['user_id']);
                        if (count($site_list) == 1) {
                            foreach ($site_list as $key=>$value) {
                                echo "<input type='hidden' name='location' id='location13' value='$key'></input>";
                            }
                        } else {
                            ?>
                            <tr class="location_row" id="location_row">
                                <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <select name='location' id='location13' class='uniform_width' onchange='handleChange(this)'>
                                        <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                        <?php
                                        $page_elems->getSiteOptions(); ?>
                                    </select>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?></td>
                            <td>
                                <?php
                                $today = date("Y-m-d");
                                $value_list = explode("-", $today);
                                $name_list = array("daily_yyyy", "daily_mm", "daily_dd");
                                $id_list = $name_list;
                                $page_elems->getDatePicker($name_list, $id_list, $value_list, true);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?></td>
                            <td>
                                <?php
                                $name_list = array("daily_yyyy_to", "daily_mm_to", "daily_dd_to");
                                $id_list = $name_list;
                                $page_elems->getDatePicker($name_list, $id_list, $value_list, true);
                                ?>
                            </td>
                        </tr>

                        <tr valign='top'>
                            <td><?php echo LangUtil::$generalTerms['RECORDS']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <td>
                                <input type='radio' name='rectype13' value='1' checked>
                                <?php echo LangUtil::$generalTerms['RECORDS_TEST']; ?>
                                </input>
                                <br>
                                <input type='radio' name='rectype13' value='2'>
                                <?php echo LangUtil::$generalTerms['RECORDS_PATIENT']; ?>
                                </input> <br/>
                                <input type='radio' name='rectype13' value='3'>
                                <?php echo LangUtil::$generalTerms['PATIENT_BARCODE']; ?>
                                </input>
                            </td>
                        </tr>
                        <tr id='cat_row13'>
                            <td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <td>
                                <select name='cat_code' id='cat_code13' class='uniform_width'>
                                    <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                    <?php
                                    if (is_country_dir(get_user_by_id($_SESSION['user_id']))) {
                                        $page_elems->getTestCategoryCountrySelect();
                                    } else {
                                        $page_elems->getTestCategorySelect();
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr id='ttype_row13'>
                            <td><?php echo LangUtil::$generalTerms['TEST']; ?></td>
                            <td>
                                <select name='ttype' id='ttype13' class='uniform_width'>
                                    <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:print_daily_log()'></input>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div id='billing_report_div' class='reports_subdiv' style='display:none'>
                    <b><?php echo "Bill Generation"; ?></b>
                    <br><br>
                    <form name='preport_form' id='preport_form'>
                        <table cellpadding='4px'>

                            <tr>
                                <td>
                                    <select name='p_attrib' id='p_attrib15'>
                                        <option value='1'><?php echo LangUtil::$generalTerms['PATIENT_NAME']; ?></option>
                                        <option value='2'><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></option>
                                        <option value='0'><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></option>
                                    </select>
                                </td>
                                <td>
                                    <input type='text' name='patient_id' id='patient_id15' class='uniform_width'></input>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type='button' id='submit_button15' name='preport_button' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>' onclick='search_preport();'></input>
                                    &nbsp;&nbsp;&nbsp;
                                    <span id='preport_progress_spinner'  style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <div id='preport_list'>
                        </div>
                    </form>
                </div>

                <div id='prevalance_aggregate_div' class='reports_subdiv' style='display:none'>
                    <b><?php echo LangUtil::$pageTerms['MENU_INFECTIONSUMMARY'];  ?></b>
                    <br><br>
                    <form name="country_aggregate_form" id="country_aggregate_form" action="geo_report_dir_prev.php" method='post'>
                        <table>
                            <tr class="sdate_row" id="sdate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from15", "mm_from15", "dd_from15");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr class="edate_row" id="edate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?>&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to15", "mm_to15", "dd_to15");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>

                            <tr id='ttype_row16'>
                                <td><?php echo LangUtil::$generalTerms['TEST']; ?></td>
                                <td>
                                    <select name='testTypeCountry' id='testTypeCountry' class='uniform_width' onchange='changeAvailableLocations(this)'>
                                        <!--<option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>-->
                                        <?php
                                        $page_elems->getTestTypesCountrySelect();
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr class="location_row_aggregate" id="location_row_aggregate">
                                <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td id='locationAggregation'>
                                    <?php /*
                        <select name='location' id='locationAggregation' class='uniform_width'>
                        <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                        <?php
                            $page_elems->getSiteOptions();
                        ?>
                        </select> */
                                    ?>
                                    <!--<input type='checkbox' name='locationAgg' id='locationAgg' value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></input>-->
                                    <?php
                                    $page_elems->getSiteOptionsCheckBoxes("locationAgg[]");
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' id='prev_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick="javascript:get_aggregate_report();" ></input>

                                    &nbsp;&nbsp;&nbsp;
                                    <span id='aggregate_report_progress_spinner'  style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div id='control_report_div' class='reports_subdiv' style='display:none'>
                    <b><?php echo LangUtil::$pageTerms['MENU_CONTROLREPORT']; ?></b>
                    <br><br>
                    <form id='control_report_form' action='control_report.php' method='post'>
                        <table>
                            <tbody>
                            <tr valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <select id='verify_test_type_control' name='t_type' class='uniform_width'>
                                        <option value=""><?php echo LangUtil::$generalTerms['SELECT_ONE']; ?>..</option>
                                        <?php $page_elems->getTestTypesSelect($_SESSION['lab_config_id']); ?>
                                    </select>
                                    <span id='control_testing_error' class='error_string' style='display:none;'>
						<?php echo LangUtil::$generalTerms['MSG_SELECT_TTYPE']; ?>
					</span>
                                </td>
                            </tr>
                            <tr class="sdate_row" id="sdate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from15", "mm_from15", "dd_from15");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr class="edate_row" id="edate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?>&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to15", "mm_to15", "dd_to15");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:get_control_report()'></input>
                                    &nbsp;&nbsp;&nbsp;
                                    <span id='stock_report_progress_spinner'  style='display:none;'>
					<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
				</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>

                <div id='disease_report_div' class='reports_subdiv' style='display:none'>
                    <b><?php echo LangUtil::$pageTerms['MENU_INFECTIONREPORT']; ?></b>
                    <br><br>
                    <form id='disease_report_form' action='report_disease.php' method='post' target='_blank'>
                        <table>
                            <tbody>
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            $lab_id=get_lab_config_id($_SESSION['user_id']);
//                            if(count($site_list) == 1)
//                            {
//                                foreach($site_list as $key=>$value)
                                    echo "<input type='hidden' name='location' id='location14' value='".$lab_id."'></input>";
//                            }
//                            else
//                            {
                                ?>
                                <tr class="location_row" id="location_row">
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                        <select name='site_list[]' id='site14' class='uniform_width' multiple>
                                            <option value='0' selected><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions();
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
//                            }
                            ?>
                            <tr class="sdate_row" id="sdate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from14", "mm_from14", "dd_from14");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr class="edate_row" id="edate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?>&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to14", "mm_to14", "dd_to14");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <select name='cat_code' id='cat_code14' class='uniform_width'>
                                        <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                        <?php
                                        $site_list = get_site_list($_SESSION['user_id']);
                                        if (count($site_list) == 1) {
                                            $page_elems->getTestCategorySelect();
                                        } else {
                                            $page_elems->getTestCategoryCountrySelect();
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
<!--                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location14' value='$key'></input>";
                                }
                            } else { ?>
                                <tr class="location_row" id="location_row">
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                    <td id='locationAggregation'>
                                        <input type='checkbox' name='locationAgg' id='locationAgg' value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></input>
                                        <?php
                                        $page_elems->getSiteOptionsCheckBoxes("locationAgg");
                                        ?>
                                    </td><br>
                                </tr>
                                <?php
                            }
                            ?>-->
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:get_disease_report()'></input>
                                    &nbsp;&nbsp;&nbsp;
                                    <span id='disease_report_progress_spinner'  style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>

                <div id='infection_aggregate_div' class='reports_subdiv' style='display:none'>
                    <b><?php echo LangUtil::$pageTerms['MENU_INFECTIONREPORT']; ?></b>
                    <br><br>
                    <form id='infection_aggregate_form' action='infection_aggregate.php' method='post' target='_blank'>
                        <table>
                            <tbody>
                            <tr class="sdate_row" id="sdate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_from", "mm_from", "dd_from");
                                    $id_list = array("yyyy_from14", "mm_from14", "dd_from14");
                                    $value_list = $monthago_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr class="edate_row" id="edate_row" valign='top'>
                                <td><?php echo LangUtil::$generalTerms['TO_DATE']; ?>&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    $name_list = array("yyyy_to", "mm_to", "dd_to");
                                    $id_list = array("yyyy_to14", "mm_to14", "dd_to14");
                                    $value_list = $today_array;
                                    $page_elems->getDatePicker($name_list, $id_list, $value_list);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <select name='cat_code' id='cat_code14' class='uniform_width'>
                                        <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                        <?php $page_elems->getTestCategoryTypesCountrySelect(); ?>
                                    </select>
                                </td>
                            </tr>
                            <tr class="location_row" id="location_row">
                                <td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;</td>
                                <td id='locationAggregation'>
                                    <input type='checkbox' name='locationAgg' id='locationAgg' value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></input>
                                    <?php
                                    $page_elems->getSiteOptionsCheckBoxes("locationAgg[]");
                                    ?>
                                </td><br>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:get_infection_report_aggregate()'></input>
                                    &nbsp;&nbsp;&nbsp;
                                    <span id='infection_aggregate_progress_spinner'  style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
						</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>

                <div id='patient_report_div' class='reports_subdiv' style='display:none'>
                    <b><?php echo LangUtil::$pageTerms['MENU_PATIENT']; ?></b>
                    <br><br>
                    <form name='preport_form' id='preport_form'>
                        <table cellpadding='4px'>
                            <?php
                            $site_list = get_site_list($_SESSION['user_id']);
                            if (count($site_list) == 1) {
                                foreach ($site_list as $key=>$value) {
                                    echo "<input type='hidden' name='location' id='location15' value='$key'></input>";
                                }
                            } else {
                                ?>
                                <tr class="location_row" id="location_row15">
                                    <td><?php echo LangUtil::$generalTerms['FACILITY']; ?></td>
                                    <td>
                                        <select name='location' id='location15' class='uniform_width'>
                                            <option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
                                            <?php
                                            $page_elems->getSiteOptions(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td>
                                    <select name='p_attrib' id='p_attrib15'>
                                        <option value='1'><?php echo LangUtil::$generalTerms['PATIENT_NAME']; ?></option>
                                        <option value='2'><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></option>
                                        <option value='0'><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></option>
                                    </select>
                                </td>
                                <td>
                                    <input type='text' name='patient_id' id='patient_id15' class='uniform_width'></input>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type='button' id='submit_button15' name='preport_button' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>' onclick='search_preport();'></input>
                                    &nbsp;&nbsp;&nbsp;
                                    <span id='preport_progress_spinner'  style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
						</span>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <div id='preport_list'>
                        </div>
                </div>

                <div id='infection_report_settings_div' class='reports_subdiv'  style='display:none;'>
                    <p style="text-align: right;"><a rel='facebox' href='#IR_rc'>Page Help</a></p>
                    <b><?php echo "Infection Report Settings"; ?></b>
                    | <a href='javascript:toggleInfectionReportSettings();' id='agg_edit_link'><?php echo LangUtil::$generalTerms['CMD_EDIT']; ?></a>
                    <br><br>
                    <div id='report_updated_msg' class='clean-orange' style='display:none;width:350px;'>
                    </div>
                    <br>
                    <div id='infection_report_settings_summary'>
                        <?php echo $page_elems->getInfectonReportSummary(); ?>
                    </div>
                    <div id='infection_report_settings_form_div' style='display:none;'>
                        <form id='infection_report_settings_preview_form' style='display:none;' name='infection_report_settings_preview_form' action='report_disease_preview.php' method='post' target='_blank'>
                            <?php # This form is cloned from agg_report_form in javascript:agg_preview() function?>
                        </form>
                        <form id='infection_report_settings_form' name='infection_report_settings_form' action='ajax/infection_report_settings_update.php' method='get'>
                            <?php $page_elems->getInfectionReportConfigureForm(); ?>
                        </form>
                    </div>
                </div>


                <?php
                # Space for additional report forms after this
                # PLUG_FORM_DIV
                ?>

            </td>
        </tr>
    </table>
<?php
$script_elems->bindEnterToClick("#patient_id8", "#submit_button8");
$script_elems->bindEnterToClick("#session_num", "#submit_button11");
$script_elems->bindEnterToClick("#specimen_id10", "#submit_button10");
$script_elems->bindEnterToClick("#specimen_id12", "#submit_button12");
$script_elems->bindEnterToClick("#patient_id15", "#submit_button15");
?>
<?php include("includes/footer.php"); ?>