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

#kepala>tbody>tr>td {
    vertical-align: top;
    padding-right: 50px;
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

include '../koneksi.php';

?>
<table id="kepala">
<tr>
    <td>
    <form id="pengaturan_fm" method="post">
        <table id="settings">
            <th>
                <td><b><h3>Pengaturan Kamera</h3></b></td>
            </th>
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
    </td>
    <td>
    <form id="jam_msk" method="post">
        <?php 
         $sql=$db->query("SELECT * FROM JAM WHERE id='1'");
            if(!$sql){
               die($db->error);
              }
            while($row = $sql->fetch_assoc()) {
            ?>                
            
        <table id="settings">
            <tr>
                <td colspan="2"><b><h3>Jam Masuk/Keluar/Pulang</h3></b></td>
            </tr>
            <tr>
                <td>Jam Masuk:</td>
                <td><input name="j_msk" value="<?php echo $row['j_msk']; ?>" class="easyui-timespinner" data-options="missingMessage:'Isi Jam',required: true" style="width:150px"></td>
            </tr>
            <tr>
                <td>Jam Keluar:</td>
                <td><input name="j_keluar" value="<?php echo $row['j_keluar']; ?>" class="easyui-timespinner" data-options="missingMessage:'Isi Jam',required: true" style="width:150px"></td>
            </tr>
            <tr>
                <td>Jam Masuk (Keluar):</td>
                <td><input name="j_keluar_msk" value="<?php echo $row['j_keluar_msk']; ?>" class="easyui-timespinner" data-options="missingMessage:'Isi Jam',required: true" style="width:150px"></td>
            </tr>
            <tr>
                <td>Jam Pulang:</td>
                <td><input name="j_plg" value="<?php echo $row['j_plg']; ?>" class="easyui-timespinner" data-options="missingMessage:'Isi Jam',required: true" style="width:150px"></td>
            </tr>
            <tr>
            <td colspan="2" align="center" style="padding: 20px 0 0 0;">
            <a href="javascript:void(0)" class="easyui-linkbutton" style="width:100px;height:50px" onClick="SimpanJam()">Simpan</a>
            </td>
            </tr>
        </table>
        <?php
        }
        ?>
    </form>
    </td>
    <td>
    <form id="pass" method="post">
        <table id="settings">
            <th>
                <td><b><h3>Pengaturan Akun</h3></b></td>
            </th>
            <tr>
                <td>Password baru:</td>
                <td><input name="passw1" class="easyui-textbox" data-options="missingMessage:'Isi password',required: true" type="password" style="width:300px"></td>
            </tr>
            <tr>
                <td>Konfirmasi password baru:</td>
                <td><input name="passw2" class="easyui-textbox" data-options="missingMessage:'Isi password kembali',required: true" type="password" type="password" style="width:300px"></td>
            </tr>
            <tr>
                <td colspan="2" align="center" style="padding: 20px 0 0 0;">
                <a href="javascript:void(0)" class="easyui-linkbutton" style="width:100px;height:50px" onClick="SimpanPass()">Simpan</a>
                </td>
            </tr>
        </table>
    </form>
    </td>
</tr>
</table>
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
function SimpanPass() {
    if ($('#pass').form('validate'))
    {
        $.ajax({
               type: "POST",
               url: '../json/admin_pengaturan.php?page=simpanPass',
               data: $("#pass").serialize(), // serializes the form's elements.
               success: function(data)
                {        
                    var data = eval('('+data+')');

                    if (data.success){
                        $.messager.show({
                            title:'Sukses',
                            msg:'Password Berhasil disimpan.',
                            timeout:5000,
                            showType:'show'
                        })
                    } else {
                        $.messager.show({
                            title: 'Error',
                            timeout:5000,
                            msg: data.msg,
                            showType:'show'
                        });
                    }
                }
        });
    }
}
function SimpanJam() {
    if ($('#jam_msk').form('validate'))
    {
        $.ajax({
               type: "POST",
               url: '../json/admin_pengaturan.php?page=simpanJam',
               data: $("#jam_msk").serialize(), // serializes the form's elements.
               success: function(data)
                {        
                    var data = eval('('+data+')');

                    if (data.success){
                        $.messager.show({
                            title:'Sukses',
                            msg:'Jam Berhasil disimpan.',
                            timeout:5000,
                            showType:'show'
                        })
                    } else {
                        $.messager.show({
                            title: 'Error',
                            timeout:5000,
                            msg: data.msg,
                            showType:'show'
                        });
                    }
                }
        });
    }
}
</script>
</html>