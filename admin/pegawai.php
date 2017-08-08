<html>
<script type="text/javascript">
$("li a").removeClass("active");
$( ".pegawai a" ).addClass( "active" );
</script>

<!--TABLE/GRID PEGAWAI -->
<div id="g_pegawai_tb">
	<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="g_m_tambah_konsul_pkl()">Tambah</a>
	<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="g_m_edit_konsul_pkl()">Edit</a>
	<a href="#" class="easyui-linkbutton" iconCls="icon-trashdel" plain="true" onclick="g_m_hapus_konsul_pkl()">Hapus</a>
	<a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="g_m_hapus_konsul_pkl()">Cetak QR</a>
</div>
<table class="easyui-datagrid" title="Pegawai" style="width:1080px;height:320px" id="g_bimbingan"
		data-options="singleSelect:false, url:'../json/admin_pegawai.php', showFooter:true,toolbar:'#g_pegawai_tb',
					  fitColumns:true, remoteSort:true, autoRowHeight:true, rownumbers: true, singleSelect:true
					  ">
	<thead>
		<tr>
			<!--th data-options="field:'id_pegawaia',hidden:true"></th-->
			<th data-options="field:'id_peg',sortable:true">ID Pegawai</th>
			<th data-options="field:'nip',sortable:true">NIP</th>
			<th data-options="field:'nama',sortable:true">Nama</th>	
			<th data-options="field:'id_jbt',sortable:true">Jabatan</th>
			<th data-options="field:'id_sts',sortable:true">Status</th>
			<th data-options="field:'tgl_lahir',sortable:true">Tanggal Lahir</th>	
			<th data-options="field:'alamat',sortable:true">Alamat</th>	
			<th data-options="field:'no_telp',sortable:true">Nomor Telepon</th>
			<th data-options="field:'foto',sortable:true">Foto</th>	
			<th data-options="field:'qr_code',sortable:true">QR Code</th>		
		</tr>
	</thead>
</table>

<script type="text/javascript">
/*
function g_m_tambah_konsul_pkl(){
			$('#g_tambah_konsul_dlg').dialog('open').dialog('setTitle','Tambah Bimbingan Konsul');
			$('#g_tambah_konsul_fm').form('clear');		
			url = 'json/g_pkl_bimbingan_konsul_aksi.php?page=simpan&id_tim=<?php echo $id_tim ?>';
	}

function g_m_tambah_konsul_pkl_save(){
		$('#g_tambah_konsul_fm').form('submit',{ 
			url: url,
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');

				if (result.success){
					$.messager.show({
						title: 'Sukses',
						msg: "Data Berhasil Disimpan"
					})
					$('#g_tambah_konsul_dlg').dialog('close');		// close the dialog
					$('#g_bimbingan').datagrid('reload');	// reload the user data
				} else {
					$.messager.show({
						title: 'Error',
						msg: result.msg
					});
				}
			}
		});
	}
*/

</script>


</html>