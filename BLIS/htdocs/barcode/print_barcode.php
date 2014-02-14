<?php
include("redirect.php");
//include("includes/header.php");
include("barcode_lib.php");

$code_type = "code39";
$bar_width = 2;
$bar_height = 40;
$font_size = 11;

$gencode = $_REQUEST['gencode'];

$uiinfo = "code=".$_REQUEST['gencode'];
putUILog('print_barcode', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

?>
<style>
    img {
    float: right;
}
</style>
<script type="text/javascript">
    $(document).ready(function(){
        PrintElem('#barcodeList');
	});
function getBarcode(code)
{
    
    if(code == '')
        {
             alert('cannot be empty');
                return;
        }
    var count = parseInt($('#count').html()); 
    count = count + 1;
    $('#count').html(count);  
    var div = "bar"+count;
    generateBarcode(div, code);
}

function generateBarcode(div, code)
{
    var content = "<br><br><div id='"+div+"'></div>";
    $('#barcodeList').append(content);
        $("#"+div).barcode(code, '<?php echo $code_type; ?>',{barWidth:<?php echo $bar_width; ?>, barHeight:<?php echo $bar_height; ?>, fontSize:<?php echo $font_size; ?>, output:'css'});

}




    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Barcodes</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();
        //mywindow.document.show
        return true;
    }

function hide_div(div)
{
    $('#'+div).hide();
}

</script>

<?php

?>
<!--
<div id="count" style="display: none;">0</div>

Code: <input type="text" id="code" name="code"></input>
<input type="button" onclick='getBarcode();' value="Generate">  
<input type="button" value="Print" onclick="PrintElem('#barcodeList')" />
<input type='button' onclick="javascript:export_as_word('barcodeList');" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
<input type='button' onclick="javascript:export_as_pdf2('barcodeList');" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTPDF']; ?>'></input>
-->


<div id="barcodeList">

</div>
