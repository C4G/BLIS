<?php
include("redirect.php");
include("includes/header.php");
include("barcode_lib.php");

$code_type = "code39";
$bar_width = 2;
$bar_height = 40;
$font_size = 11;
$gencode = $_REQUEST['gencode'];
$uiinfo = "code=".$_REQUEST['gencode'];
putUILog('get_barcode', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
?>
<style>
    img {
    float: right;
}
</style>
<script type="text/javascript">
    $(document).ready(function(){
	});
function getBarcode()
{
    var code = $('#code').val();
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
    generateRemoveLink(div);
}

function generateBarcode(div, code)
{
    var content = "<br><br><div id='"+div+"'></div>";
    $('#barcodeList').append(content);
        $("#"+div).barcode(code, '<?php echo $code_type; ?>',{barWidth:<?php echo $bar_width; ?>, barHeight:<?php echo $bar_height; ?>, fontSize:<?php echo $font_size; ?>, output:'css'});

}

function generateRemoveLink(div)
{
    var divR = div+"Remove";
    var oc = "hide_div('"+div+"')";
    var content = "<div float class='remove' id ='"+divR+"' >"+"<img src='includes/img/knob_cancel.png' alt='Remove' onclick=\""+oc+"\";' />"+"</div>";
    $('#barcodeList').append(content);
}


function removeAllLinks(classname)
{
    $("."+classname).hide();
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
<p style="text-align: right;"><a rel='facebox' href='#generate_barcode_help'>Page Help</a></p>

<div id="count" style="display: none;">0</div>

Code: <input type="text" id="code" name="code"></input>
<input type="button" onclick='getBarcode();' value="Generate">  
<input type="button" value="Print" onclick="PrintElem('#barcodeList')" />

<div id="barcodeList">

</div>
