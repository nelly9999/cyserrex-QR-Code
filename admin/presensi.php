<html>
<script type="text/javascript">
$("li a").removeClass("active");
$( ".presensi a" ).addClass( "active" );
$('.halmn').append('Presensi');
</script>

<!--TABLE/GRID PRESENSI -->
<div id="g_presensi_tb">
	<a href="#" class="easyui-linkbutton" iconCls="icon-reload"  plain="true" onclick="Reset()">Refresh</a>
	<input class="easyui-datebox" plain="true" style="width:125px" id="tgl"
					data-options="method:'get',
								prompt:'Taggal Presensi',
								panelHeight:'200px',
								onSelect: function(date){
									var tanggal = ('0' + date.getDate()).slice(-2);
									var bulan = ('0' + (date.getMonth()+1)).slice(-2);					
									var url = '../json/admin_presensi.php?tgl='+date.getFullYear()+'-'+bulan+'-'+tanggal;
									$('#g_presensi').datagrid('reload', url);
									}
	">
	<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="g_m_tambah_presensi()">Tambah</a>
	<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="g_m_edit_presensi()">Edit</a>
	<a href="#" class="easyui-linkbutton" iconCls="icon-trashdel" plain="true" onclick="g_m_hapus_presensi()">Hapus</a>
	<!--a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="g_m_cetak_pegawai()">Cetak QR</a-->
</div>
<table class="easyui-datagrid" title="Presensi" style="width:100%;height:320px" id="g_presensi"
		data-options="singleSelect:false, url:'../json/admin_presensi.php', showFooter:true,toolbar:'#g_presensi_tb',
					  fitColumns:true, remoteSort:true, autoRowHeight:true, rownumbers: true, singleSelect:true, pagination:true,
					  pageSize:10, pageList: [10,20,50,100]">
	<thead>
		<tr>
			<!--th data-options="field:'id_pegawaia',hidden:true"></th-->
			<!--th data-options="field:'id_peg',sortable:true">ID Pegawai</th-->
			<th data-options="field:'tgl',sortable:true">Tanggal</th>
			<th data-options="field:'nip',sortable:true">NIP</th>
			<th data-options="field:'nama',sortable:true">Nama</th>		
			<th data-options="field:'jam_msk',sortable:true">Jam Masuk</th>
			<th data-options="field:'jam_plg',sortable:true">Jam Pulang</th>	
		</tr>
	</thead>
</table>

<script type="text/javascript">
		function Reset(){
		$('#g_presensi').datagrid('load','../json/admin_presensi.php');
		$('#tgl').datebox('setValue','');
	}
</script>

</html>