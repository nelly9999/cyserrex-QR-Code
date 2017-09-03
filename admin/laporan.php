<html>
<script type="text/javascript">
$("li a").removeClass("active");
$( ".laporan a" ).addClass( "active" );
$('.halmn').append('Laporan');
</script>
<?php 
$submit_bln = 0;
$submit_thn = 0;
if(isset($_POST['oke']))
{
	$submit_bln = $_POST['bulan'] ? $_POST['bulan'] : 0;
	$submit_thn = $_POST['tahun'] ? $_POST['tahun'] : 0;
}
?>
<!--TABLE/GRID LAPORAN -->
<div id="g_laporan_tb">
<form style="display:inline;" id="laporan_form" action="" method="post">
	<select id="bulan_c" class="easyui-combobox" data-options="prompt:'Bulan',value:'',required: true,missingMessage:'Pilih Bulan'" name="bulan" style="width:100px;">
        <option value="1">Januari</option>
        <option value="2">Februari</option>
        <option value="3">Maret</option>
        <option value="4">April</option>
        <option value="5">Mei</option>
        <option value="6">Juni</option>
        <option value="7">Juli</option>
        <option value="8">Agustus</option>
        <option value="9">September</option>
        <option value="10">Oktober</option>
        <option value="11">Nopember</option>
        <option value="12">Desember</option>
    </select>
	<input class="easyui-combobox" plain="true" name="tahun" style="width:80px" id="tahun_c"
					data-options="url:'../json/cmb_statistik_tahun.php',
								method:'get',
								prompt:'Tahun',
								required: true,
								valueField:'tahun',
								textField:'tahun',
								panelHeight:'auto',
								missingMessage:'Pilih Tahun'
								">
	<input name="oke" hidden="true"></input>
</form>
	<a href="#" class="easyui-linkbutton" plain="true" iconCls="icon-search" name="submit" id="lihat">Lihat</a>
	<a href="#" class="easyui-linkbutton" plain="true" iconCls="icon-print" id="cetak" onclick="cetak_laporan()">Cetak</a>
</div>
<table class="easyui-datagrid" title="Bulan: <?php echo $submit_bln ?>. Tahun: <?php echo $submit_thn ?>." style="width:100%;height:320px" id="g_laporan"
		data-options="singleSelect:false, url:'../json/admin_laporan.php?bulan_c=<?php echo $submit_bln ?>&tahun_c=<?php echo $submit_thn ?>', showFooter:true,toolbar:'#g_laporan_tb',
					  fitColumns:true, remoteSort:true, autoRowHeight:true, rownumbers: true, singleSelect:true, pagination:true,
					  pageSize:10, pageList: [10,20,50,100]">
	<thead>
		<tr>
			<th data-options="field:'nip',sortable:true">NIP</th>
			<th data-options="field:'nama',sortable:true">Nama</th>
			<span class="lprn">	
			<?php
			$tgl = date_create($submit_thn.'-'.$submit_bln.'-01');
			$bulan = date_format($tgl,'m');
			$tahun = date_format($tgl,'Y');
			$total_hari = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun)+1;
			 for ($i=1;$i<$total_hari;$i++) { 
			 	$cek_minggu = $tahun.'-'.$bulan.'-'.$i;
			 	if(date('N', strtotime($cek_minggu)) >= 7)
			 		{$iw="<b style='color:red;'>".$i."</b>";}
			 	else 
			 		{$iw=$i;}
			?>
				<th data-options="field:'tgl<?php echo $i ?>'"><?php echo $iw ?></th>	
			<?php 
			} 
			?>
			</span>
			<th data-options="field:'jumlah'">Jumlah Kehadiran</th>
		</tr>
	</thead>
</table>
<script type="text/javascript">
	$(document).ready(function() { 
    $('#lihat').click(function() {
    	if ($('#laporan_form').form('validate'))
		{
        	$('#laporan_form').submit();
    	}
    });
});
	function cetak_laporan(){
		if ($('#laporan_form').form('validate'))
		{
        	var bulan_c = $('#bulan_c').val();
        	var tahun_c = $('#tahun_c').val();

        	var win = window.open('../json/admin_laporan_cetak.php?bulan='+bulan_c+'&tahun='+tahun_c, '_self');
  			win.focus();
    	}
	}
</script>
</html>