<html>
<script type="text/javascript">
$("li a").removeClass("active");
$( ".pegawai a" ).addClass( "active" );
</script>

<!--TABLE/GRID PEGAWAI -->
	<div id="g_bimbingan_tb">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="g_m_tambah_konsul_pkl()">Tambah</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="g_m_edit_konsul_pkl()">Edit</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-trashdel" plain="true" onclick="g_m_hapus_konsul_pkl()">Hapus</a>
	</div>
	<table class="easyui-datagrid" title="Pegawai" style="width:100%;height:320px" id="g_bimbingan"
			data-options="singleSelect:false, url:'', showFooter:true,toolbar:'#g_bimbingan_tb',
						  fitColumns:true, remoteSort:true, autoRowHeight:true, rownumbers: true, singleSelect:true
						  ">
		<thead>
			<tr>
				<th data-options="field:'id_bimbingan',hidden:true"></th>
				<th data-options="field:'tgl_bimbingan',sortable:true">NIP</th>
				<th data-options="field:'diterima',sortable:true">Nama</th>	
				<th data-options="field:'materi_bimbingan',sortable:true">Jabatan</th>
				<th data-options="field:'tgl_bimbingan',sortable:true">NIP</th>
				<th data-options="field:'diterima',sortable:true">Nama</th>	
				<th data-options="field:'materi_bimbingan',sortable:true">Jabatan</th>	
				<th data-options="field:'tgl_bimbingan',sortable:true">NIP</th>
				<th data-options="field:'diterima',sortable:true">Nama</th>	
				<th data-options="field:'materi_bimbingan',sortable:true">Jabatan</th>		
			</tr>
		</thead>
	</table>


</html>