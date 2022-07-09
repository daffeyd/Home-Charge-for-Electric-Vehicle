<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: barcode reader ::</title>

<script language="javascript" src="utilities.js"></script> 
<script language="javascript">
function onEnter(e){
	var key=e.keyCode || e.which;
	if(key==13){
		showCell();
	}
}

function showCell(){
	iObj=document.getElementById("indexCell");
	index=iObj.value.trim();
	newIndex=eval(index)+1;
	
	rObj=document.getElementById("readBarcode");
	valBarcode=rObj.value.trim();

	rObj.value="";rObj.focus(); iObj.value=newIndex;
	doRequested('viewResult'+index,'readCell.php?val='+valBarcode+'&index='+newIndex,false);
}
</script>
</head>

<body onload="document.getElementById('readBarcode').focus();">
<table width="100%">
	<tr>
    	<td style="width:180px">NAMA BARANG</td>
        <td style="width:180px">JUMLAH</td>
        <td style="width:180px">HARGA</td>
        <td style="width:180px">TOTAL</td>
    </tr>
</table>
<div id="viewResult0">
</div>
<input type="text" id="readBarcode" name="readBarcode" onkeypress="onEnter(event)" />
<input type="text" id="indexCell" name="indexCell" value="0" style="display:none" />
</body>
</html>
