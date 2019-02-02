<!-- (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre -->

<script type="text/javascript">
	function changeTheme(theme) {
		alert(theme);
		$.ajax({
		type : 'POST',
		url : 'users/changetheme.php?theme='+theme,
		success : function(data) {
			alert(data);
		}
	});
	}
        
        
        
</script>

<?php
#
# This is the footer file to display at the end of the file.
# Closes any open database connections, and-
# displays footer so the users know the page is done loading.
#
include("db_close.php");
LangUtil::setPageId("footer");
?>




                </div>
            </div>
        </div>
<!-- end of center pane-->
<!-- start of footer -->
<footer class="footer">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
                <div class="col-auto">
                    <ul class="list-inline list-inline-dots mb-0">
                        <li class="list-inline-item">
                            <?php
                            if($_SESSION['locale'] == "en")
                            {
                                echo "<a href='userguide/BLIS_User_Guide.pdf' target='_blank' >User Guide</a>";
                            }
                            else if($_SESSION['locale'] == "fr")
                            {
                                echo "<a href='userguide/BLIS_User_Guide.pdf' target='_blank' >Guide de l'utilisateur</a>";
                            }
                            else
                            {
                                echo "<a href='userguide/BLIS_User_Guide.pdf' target='_blank'>User Guide</a>";
                            }
                            ?>
                        </li>
                        <li class="list-inline-item">
                              <a href="feedback/comments.php?src=<?php echo $_SERVER['PHP_SELF']; ?>">Comments</a>
                        </li>
                        <li class="list-inline-item">
                            <?php
                            if($_SESSION['locale'] !== "en")
                            {
                                echo "<a href=\"lang_switch?to=en\">English</a>";
                            }
                            else
                            {
                                echo "English";
		                    }
                            ?>
                        </li>
                        <li class="list-inline-item">
                           <?php
                            if($_SESSION['locale'] !== "fr")
		                    {
                                echo "<a href=\"lang_switch?to=fr\">Francais</a>";
		                    }
                            else
		                    {
                                echo "Francais";
                            }
                            ?>
                        </li>
                        <li class="list-inline-item">
                            <?php
                            if($_SESSION['locale'] !== "default")
                            {
                                echo "<a href=\"lang_switch?to=default\">Default</a>";
                            }
                            else
                            {
                                echo "Default";
                            }
                            ?>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
                    C4G BLIS v<?php echo $VERSION; ?> - <?php echo LangUtil::getPageTerm("FOOTER_MSG"); ?>
                    <?php
                    /*Change Theme: <a href=javascript:changeTheme('Blue');>Blue</a> | <a href=javascript:changeTheme('Grey');>Grey*/
                    if($TRACK_LOADTIME)
                    {
                        $endtime = microtime();
                        $endarray = explode(" ", $endtime);
                        $endtime = $endarray[1] + $endarray[0];
                        $totaltime = $endtime - $starttime; 
                        $totaltime = round($totaltime,5);
                        $page_name = $_SERVER['PHP_SELF'];
                        $page_name_parts = explode("/", $page_name);
                        $file_name = $page_name_parts[count($page_name_parts)-1].".dat";
                        $file_handle = fopen("../feedback/loadtimes/".$file_name, "a");
                        fwrite($file_handle, $totaltime."\n");
                        fclose($file_handle);
                        echo "<br>$file_name This page loaded in $totaltime seconds.";
                    }
                    if($TRACK_LOADTIMEJS)
                    {
                        echo "<script type='text/javascript'>alert(new Date().getTime() - t.getTime());</script>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--end of bottom_pane-->
</div>
</body>
</html>