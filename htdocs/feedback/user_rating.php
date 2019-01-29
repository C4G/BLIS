<html>
<head>
    <title>
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="./favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>Login - C4G BLIS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <script src="./assets/js/require.min.js"></script>
    <script>
        requirejs.config({
            baseUrl: '.'
        });

    </script>
    <!-- Dashboard Core -->
    <link href="./assets/css/dashboard.css" rel="stylesheet" />
    <script src="./assets/js/dashboard.js"></script>
    <!-- c3.js Charts Plugin -->
    <link href="./assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
    <script src="./assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="./assets/plugins/maps-google/plugin.css" rel="stylesheet" />
    <script src="./assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="./assets/plugins/input-mask/plugin.js"></script>

    <script type='text/javascript'>
        function submit_rating() {
            //$('#submit_progress').show();
            //$('#rating_form').ajaxSubmit({
            //    success: function() {
            //        $('#submit_progress').hide();
                    window.location = "logout.php";
            //    }
            //});
        }

        function skip_to_logout() {
            //document.getElementById("skipped").setAttribute("value", "-1");
            //$('#submit_progress').show();
            //$('#rating_form').ajaxSubmit({
            //    success: function() {
            //        $('#submit_progress').hide();
                    window.location = "logout.php";
            //    }
            //});
        }

    </script>
    <?php include("../includes/styles.php"); ?>
    <?php
    #
    # Saves user_ratings before proceeding to logout
    #


    include("../includes/db_lib.php");
    include("../includes/script_elems.php");
    include("../includes/page_elems.php");
    $script_elems = new ScriptElems();
    $page_elems = new PageElems();

    $script_elems->enableJQuery();
    $script_elems->enableJQueryForm();
    ?>

</head>

<body class="">
    <div class="page">
        <div class="page-main">
            <div class="my-3 my-md-5">
                <div class="container">
                    <div class="page-header">
                        <h1 class="page-title">User Rating</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <form name="rating_form" id="rating_form" action="user_rating_submit.php" class="form-group">
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="hidden" name="skipped" id="skipped" value="0">

                                <div class="form-label">How would you rate this experience with BLIS?</div>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input name="rating" id="rating" type="radio" value="1" class="custom-control-input">
                                        <div class="custom-control-label">1. Highly satisfactory</div>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="rating" id="rating" type="radio" value="2" class="custom-control-input">
                                        <div class="custom-control-label">2. Somewhat satisfactory</div>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="rating" id="rating" type="radio" value="3" class="custom-control-input" checked>
                                        <div class="custom-control-label">3. Neither satisfactory nor unsatisfactory</div>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="rating" id="rating" type="radio" value="4" class="custom-control-input">
                                        <div class="custom-control-label">4. Unsatisfactory</div>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="rating" id="rating" type="radio" value="5" class="custom-control-input">
                                        <div class="custom-control-label">5. Highly unsatisfactory</div>
                                    </label>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="form-label">Comments:</label>
                                    <textarea rows="5" columns="24" name="comments" id="comments" type="textbox" maxlength="2048" class="form-control"></textarea>
                                </div>


                                <div class="form-group">
                                    <span id='submit_progress' style='display:none;'>
                                        <?php echo $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
                                    </span>
                                </div>

                                <div class="btn-list">
                                    <a class="btn btn-primary btn-block" onclick="submit_rating()">
                                        <?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?></a>
                                    <a class="btn btn-secondary btn-block" onclick="skip_to_logout()">
                                        <?php echo LangUtil::$generalTerms['CMD_SKIP']; ?></a>
                                </div>
                            </form>

                            <?php
                            if($_SESSION['locale'] != "fr")
                            {
                            ?>

                            <?php
                            }
                            else
                            {
                                # Show in francais
                            ?>

                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
