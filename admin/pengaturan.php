<html>
<script type="text/javascript">
$("li a").removeClass("active");
$( ".pengaturan a" ).addClass( "active" );
$('.halmn').append('Pengaturan');
</script>
<style type="text/css">
#settings>tbody>tr>td:nth-child(1) {
	width:180px;
}

#settings>tbody>tr>td:nth-child(2) {
	padding: 5px 0 5px 0;
}
</style>
<?php
$myFile = "../js/webcodecamjquery.js";
$lines = file($myFile);
$kontras_fm = explode(': ',$lines[64].''); 
$kontras_fm = str_replace(',','', $kontras_fm[1]); 
$cerah_fm = explode(': ',$lines[61].''); 
$cerah_fm = str_replace(',','', $cerah_fm[1]); 
$zoom_fm = explode(': ',$lines[58].''); 
$zoom_fm = str_replace(',','', $zoom_fm[1]);
$tajam_fm = explode(': ',$lines[66].''); 
$tajam_fm = str_replace(',','', $tajam_fm[1]); 
$h_p_fm = explode(': ',$lines[63].''); 
$h_p_fm = str_replace(',','', $h_p_fm[1]);   
$flip_h = explode(': ',$lines[57].''); 
$flip_h = str_replace(',','', $flip_h[1]);
$flip_v = explode(': ',$lines[56].''); 
$flip_v = str_replace(',','', $flip_v[1]);  
?>
<form id="pengaturan_fm" method="post">
    <table id="settings">
    	<tr>
    		<td>Kontras:</td>
    		<td><input name="kontras" class="easyui-slider" value="<?php echo $kontras_fm; ?>" style="width:300px" data-options="showTip:true,min:-128,max:128"></td>
    	</tr>
    	<tr>
    		<td>Kecerahan:</td>
    		<td><input name="cerah" class="easyui-slider" value="<?php echo $cerah_fm; ?>" style="width:300px" data-options="showTip:true,min:0,max:128"></td>
    	</tr>
    	<tr>
    		<td>Zoom:</td>
    		<td><input name="zoom" class="easyui-slider" value="<?php echo $zoom_fm; ?>" style="width:300px" data-options="showTip:true,min:0,max:10"></td>
    	</tr>
        <tr>
            <td>Ketajaman:</td>
            <td><input name="tajam" class="easyui-switchbutton" <?php if($tajam_fm=="[0 -1 0 -1 5 -1 0 -1 0]"."\n") echo 'checked'; ?>></td>
        </tr>
        <tr>
            <td>Hitam Putih:</td>
            <td><input name="hitam_p" class="easyui-switchbutton" <?php if($h_p_fm==1) echo 'checked'; ?>></td>
        </tr>
        <tr>
            <td>Putar Horizontal:</td>
            <td><input name="p_horiz" class="easyui-switchbutton" <?php if($flip_h==1) echo 'checked'; ?>></td>
        </tr>
        <tr>
            <td>Putar Vertical:</td>
            <td><input name="p_vert" class="easyui-switchbutton" <?php if($flip_v==1) echo 'checked'; ?>></td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="padding: 20px 0 0 0;">
            <a href="javascript:void(0)" class="easyui-linkbutton" style="width:100px;height:50px" onClick="SimpanP()">Simpan</a>
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">
function SimpanP() {
    $.ajax({
           type: "POST",
           url: '../json/admin_pengaturan.php?page=simpan',
           data: $("#pengaturan_fm").serialize(), // serializes the form's elements.
           success: function(data)
            {        
                $.messager.show({
                    title:'Sukses',
                    msg:'Berhasil disimpan.',
                    timeout:5000,
                    showType:'show'
                });
            }
    });
}
</script>
</html>