<html>
<script type="text/javascript">
$("li a").removeClass("active");
$( ".cuti_tugas a" ).addClass( "active" );
$('.halmn').append('Cuti/Tugas');
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
                <td>Nama Pegawai:</td>
                <td><input class="easyui-combobox" plain="true" name="pegawai" style="width:150px" id="pegawai"
                    data-options="url:'../json/cmb_pegawai.php',
                                method:'get',
                                prompt:'Pegawai',
                                required: true,
                                valueField:'id_peg',
                                textField:'pegawai',
                                panelHeight:'auto',
                                missingMessage:'Pilih Pegawai'
                                "></td>
            </tr>
            <tr>
                <td>Keterangan:</td>
                <td><input id="ket" class="easyui-textbox" data-options="multiline:true, required: true, missingMessage:'Isi Keterangan',prompt:'Isi Keterangan'" name="ket" style="width:300px;height:100px"></td>
            </tr>
            <tr>
                <td>Dari Tanggal:</td>
                <td><input id="dari_tgl" name="tgl_awal" class="easyui-datebox" data-options="missingMessage:'Isi Tanggal',required: true,formatter:myformatter,parser:myparser,prompt:'Tanggal'" style="width:150px"></td>
            </tr>
             <tr>
                <td>Hingga Tanggal:</td>
                <td><input id="hingga_tgl" name="tgl_akhir" class="easyui-datebox" data-options="missingMessage:'Isi Tanggal',required: true,formatter:myformatter,parser:myparser,prompt:'Tanggal'" style="width:150px"></td>
            </tr>
            <tr>
            <td colspan="2" align="center" style="padding: 20px 0 0 0;">
            <a href="javascript:void(0)" class="easyui-linkbutton" style="width:100px;height:50px" onClick="SimpanKlik()">Simpan</a>
            </td>
            </tr>
        </table>
        <?php
        }
        ?>
    </form>
    </td>
</tr>
</table>
<script type="text/javascript">
function myformatter(date){
        var y = date.getFullYear();
        var m = date.getMonth()+1;
        var d = date.getDate();
        return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
    }

    function myparser(s){
        if (!s) return new Date();
        var ss = (s.split('-'));
        var y = parseInt(ss[0],10);
        var m = parseInt(ss[1],10);
        var d = parseInt(ss[2],10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
            return new Date(y,m-1,d);
        } else {
            return new Date();
        }
    }
//---sampai disini
function SimpanKlik() {
    if ($('#jam_msk').form('validate'))
    {
        $.ajax({
               type: "POST",
               url: '../json/admin_cuti_tugas.php?page=simpanCuti',
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