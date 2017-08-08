<html>
<script type="text/javascript">
$("li a").removeClass("active");
$( ".pegawai a" ).addClass( "active" );
$('.halmn').append('Pegawai');
</script>

<!--TABLE/GRID PEGAWAI -->
<div id="g_pegawai_tb">
	<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="g_m_tambah_pegawai()">Tambah</a>
	<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="g_m_edit_pegawai()">Edit</a>
	<a href="#" class="easyui-linkbutton" iconCls="icon-trashdel" plain="true" onclick="g_m_hapus_pegawai()">Hapus</a>
	<a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="g_m_cetak_pegawai()">Cetak QR</a>
</div>
<table class="easyui-datagrid" title="Pegawai" style="width:1080px;height:320px" id="g_pegawai"
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

<!--DIALOG TAMBAH PEGAWAI-->
<div id="g_tambah_pegawai_dlg" class="easyui-dialog" style="left:350px;top:200px;" closed="true" 
	buttons="#g_tambah_pegawai_dlg-buttons" >
		<form id="g_tambah_pegawai_fm" method="post">
			<table cellpadding="5">
				<tr>
					<td>Tanggal</td><td>:</td>
					<td><input class="easyui-datebox" type="text" name="tgl_bimbingan" data-options="frequired:'true'" style="width:100px"></input></td>
				</tr>
				<tr>
					<td>Nama Pegawai</td><td>:</td>
					<td><input class="easyui-textbox" name="materi_bimbingan" data-options="multiline:true" style="height:60px; width:350px"></input></td>
				</tr>
			</table>
		</form>
	</div>	
	<div id="g_tambah_pegawai_dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok"     onclick="g_m_tambah_pegawai_simpan()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#g_tambah_pegawai_dlg').dialog('close')">Cancel</a>
	</div>	

<script type="text/javascript">

function g_m_tambah_pegawai(){
			$('#g_tambah_pegawai_dlg').dialog('open').dialog('setTitle','Tambah Pegawai');
			$('#g_tambah_pegawai_fm').form('clear');		
			url = '../json/admin_pegawai_aksi.php?page=simpan';
	}

function g_m_tambah_pegawai_simpan(){
		$('#g_tambah_pegawai_fm').form('submit',{ 
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
					$('#g_tambah_pegawai_dlg').dialog('close');		// close the dialog
					$('#g_pegawai').datagrid('reload');	// reload the user data
				} else {
					$.messager.show({
						title: 'Error',
						msg: result.msg
					});
				}
			}
		});
	}


</script>


</html>