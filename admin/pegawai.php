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
	<a href="#" class="easyui-linkbutton" iconCls="icon-qr" plain="true" onclick="g_m_qr_pegawai()">Generate QR</a>
	<!--a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="g_m_cetak_pegawai()">Cetak QR</a-->
</div>
<table class="easyui-datagrid" title="Pegawai" style="width:100%;height:320px" id="g_pegawai"
		data-options="singleSelect:false, url:'../json/admin_pegawai.php', showFooter:true,toolbar:'#g_pegawai_tb',
					  fitColumns:true, remoteSort:true, autoRowHeight:true, rownumbers: true, singleSelect:true, pagination:true,
					  pageSize:10, pageList: [10,20,50,100]">
	<thead>
		<tr>
			<!--th data-options="field:'id_pegawaia',hidden:true"></th-->
			<th data-options="field:'id_peg',sortable:true">ID Pegawai</th>
			<th data-options="field:'nip',sortable:true">NIP</th>
			<th data-options="field:'nama',sortable:true">Nama</th>	
			<th data-options="field:'jk',sortable:true">JK</th>	
			<th data-options="field:'nama_jbt',sortable:true">Jabatan</th>
			<th data-options="field:'id_jbt',hidden:true"></th>
			<th data-options="field:'id_sts',sortable:true">Status</th>
			<th data-options="field:'tgl_lahir',sortable:true">Tanggal Lahir</th>	
			<th data-options="field:'alamat',sortable:true">Alamat</th>	
			<th data-options="field:'no_telp',sortable:true">Nomor Telepon</th>
			<th data-options="field:'foto',sortable:true">Foto</th>	
			<th data-options="field:'qr_code',sortable:true">QR Code</th>	
			<th data-options="field:'qr_lvl',sortable:true">Level QR</th>
			<th data-options="field:'qr_level',hidden:true"></th>	
		</tr>
	</thead>
</table>

<!--DIALOG TAMBAH PEGAWAI-->
<div id="g_tambah_pegawai_dlg" class="easyui-dialog" style="width:500px;top:20px"
        closed="true" buttons="#g_tambah_pegawai_dlg-buttons">
    <form id="g_tambah_pegawai_fm" method="post" novalidate style="margin:0;padding:20px 50px" enctype="multipart/form-data">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">NIP</div>
        <div style="margin-bottom:10px">
            <input name="nip" class="easyui-textbox" validType="length[6,18]" label="NIP:" style="width:350px">
        </div>
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">Data Wajib</div>
        <div style="margin-bottom:10px">
            <input name="nama" class="easyui-textbox" required="true" missingMessage="Mohon isi Nama" label="Nama:" style="width:350px">
        </div>
        <div style="margin-bottom:10px">
            <select name="jk" class="easyui-combobox" panelHeight="auto" required="true" missingMessage="Mohon pilih Jenis Kelamin" label="Jenis Kelamin:" style="width:200px">
	            <option value="L">Laki-Laki</option>
	    		<option value="P">Perempuan</option>
	    	</select>
        </div>
        <div style="margin-bottom:10px">
        	<input label="Jabatan:" class="easyui-combobox" name="id_jbt" style="width:225px"
								data-options="
								url:'../json/cmb_jabatan.php',
								method:'get',required:'true',
								valueField:'id_jbt',
								textField:'nama_jbt',
								required: 'true',
								missingMessage: 'Mohon pilih Jabatan',
								panelHeight:'auto'"></input>     
        </div>
        <div style="margin-bottom:10px">
        	<input label="Status:" class="easyui-combobox" name="id_sts" style="width:200px"
								data-options="
								url:'../json/cmb_status.php',
								method:'get',required:'true',
								valueField:'id_sts',
								textField:'nama_sts',
								required: 'true',
								missingMessage: 'Mohon pilih Status',
								panelHeight:'auto'"></input>     
        </div>
        <div style="margin-bottom:10px">
            <input name="tgl_lahir" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" required="true" missingMessage="Mohon isi Tanggal Lahir" label="Tanggal Lahir:" style="width:200px">
        </div>
        <div style="margin-bottom:10px">
            <input name="alamat" class="easyui-textbox" multiline="true" required="true" missingMessage="Mohon isi Alamat" label="Alamat:" style="width:350px">
        </div>
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">Opsional</div>
        <div style="margin-bottom:10px">
            <input name="no_telp" class="easyui-textbox" label="Nomor Telepon:" style="width:350px">
        </div>
        <div style="margin-bottom:10px">
            <input name="foto" class="easyui-filebox" accept="image/*" buttonText="Pilih Foto" label="Foto:" style="width:300px">
        </div>
    </form>
</div>
<div id="g_tambah_pegawai_dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="g_m_tambah_pegawai_simpan()" style="width:90px">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#g_tambah_pegawai_dlg').dialog('close')" style="width:90px">Batal</a>
</div>

<!--DIALOG EDIT PEGAWAI-->
<div id="g_edit_pegawai_dlg" class="easyui-dialog" style="width:500px;top:20px"
        closed="true" buttons="#g_edit_pegawai_dlg-buttons">
    <form id="g_edit_pegawai_fm" method="post" novalidate style="margin:0;padding:20px 50px" enctype="multipart/form-data">
    <input type="text" hidden name="id_peg">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">NIP</div>
        <div style="margin-bottom:10px">
            <input name="nip" class="easyui-textbox" validType="length[6,18]" label="NIP:" style="width:350px">
        </div>
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">Data Wajib</div>
        <div style="margin-bottom:10px">
            <input name="nama" class="easyui-textbox" required="true" missingMessage="Mohon isi Nama" label="Nama:" style="width:350px">
        </div>
        <div style="margin-bottom:10px">
            <select name="jk" class="easyui-combobox" panelHeight="auto" required="true" missingMessage="Mohon pilih Jenis Kelamin" label="Jenis Kelamin:" style="width:200px">
	            <option value="L">Laki-Laki</option>
	    		<option value="P">Perempuan</option>
	    	</select>
        </div>
        <div style="margin-bottom:10px">
        	<input label="Jabatan:" class="easyui-combobox" name="id_jbt" style="width:225px"
								data-options="
								url:'../json/cmb_jabatan.php',
								method:'get',required:'true',
								valueField:'id_jbt',
								textField:'nama_jbt',
								required: 'true',
								missingMessage: 'Mohon pilih Jabatan',
								panelHeight:'auto'"></input>     
        </div>
        <div style="margin-bottom:10px">
        	<input label="Status:" class="easyui-combobox" name="id_sts" style="width:200px"
								data-options="
								url:'../json/cmb_status.php',
								method:'get',required:'true',
								valueField:'id_sts',
								textField:'nama_sts',
								required: 'true',
								missingMessage: 'Mohon pilih Status',
								panelHeight:'auto'"></input>     
        </div>
        <div style="margin-bottom:10px">
            <input name="tgl_lahir" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" required="true" missingMessage="Mohon isi Tanggal Lahir" label="Tanggal Lahir:" style="width:200px">
        </div>
        <div style="margin-bottom:10px">
            <input name="alamat" class="easyui-textbox" multiline="true" required="true" missingMessage="Mohon isi Alamat" label="Alamat:" style="width:350px">
        </div>
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">Opsional</div>
        <div style="margin-bottom:10px">
            <input name="no_telp" class="easyui-textbox" label="Nomor Telepon:" style="width:350px">
        </div>
        <div style="margin-bottom:10px">
            <input name="foto" class="easyui-filebox" accept="image/*" buttonText="Pilih Foto" label="Foto:" style="width:300px">
        </div>
    </form>
</div>
<div id="g_edit_pegawai_dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="g_m_edit_pegawai_simpan()" style="width:90px">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#g_edit_pegawai_dlg').dialog('close')" style="width:90px">Batal</a>
</div>


<!--DIALOG GENERATE QR-->
<div id="g_qr_pegawai_dlg" closable="false" class="easyui-dialog" style="width:500px;top:20px"
        closed="true" buttons="#g_qr_pegawai_dlg-buttons">
    <form id="g_qr_pegawai_fm" method="post" novalidate style="margin:0;padding:20px 50px">
	    <input type="text" hidden value="H" name="level">
	    <input type="text" hidden value="5" name="size">
	    <input type="text" hidden name="id_peg">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">QR Untuk <input style="border:none;background:transparent;font-weight:bold;" name="nama"></div>
        <div style="margin-bottom:10px">
            <input label="Teks QR: " value="sman1mandastana-" type="text" class="easyui-textbox" name="qr_code1" readonly="true" style="width:206px"></input>
            <input name="qr_code2" required="true" missingMessage="Harap isi QR Code" validType="length[6,18]" class="easyui-textbox" style="width:150px">
        </div>
        <div style="margin-bottom:10px">
        	<input label="Level:" class="easyui-combobox" name="qr_level" style="width:200px"
								data-options="
								url:'../json/cmb_level.php',
								method:'get',required:'true',
								valueField:'qr_level',
								textField:'qr_lvl',
								required: 'true',
								missingMessage: 'Mohon pilih Level QR',
								panelHeight:'auto'"></input>     
        </div>
        <div style="text-align: center">
        	<img id="qr_code_img" src="temp_qr/no-qr.png" height="150px" width="150px"><br/>
        	Generate memerlukan waktu kurang lebih 5 detik.
        </div>
    </form>
</div>
<div id="g_qr_pegawai_dlg-buttons">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" onclick="g_m_qr_pegawai_cetak()" style="width:110px; position:absolute; left:0px;">Cetak QR Code</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-generate" onclick="g_m_qr_pegawai_generate()" style="width:90px">Generate</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#g_qr_pegawai_dlg').dialog('close');$('#qr_code_img').attr('src', 'temp_qr/no-qr.png');" style="width:90px">Tutup</a>
</div>


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
					$('#g_edit_pegawai_fm').form('reset'); //form edit harus direset
				} else {
					$.messager.show({
						title: 'Error',
						height: 100,
						msg: result.msg
					});
				}
			}
		});
	}

function g_m_edit_pegawai(){
	var row=$('#g_pegawai').datagrid('getSelected');
	if (row){
		$('#g_edit_pegawai_dlg').dialog('open').dialog('setTitle','Edit Pegawai');
		$('#g_edit_pegawai_fm').form('load',row);
		url = '../json/admin_pegawai_aksi.php?page=edit';
	}
	else
		$.messager.alert('Peringatan','Pilih Pegawai terlebih dahulu.','warning');

}
function g_m_edit_pegawai_simpan(){
	$('#g_edit_pegawai_fm').form('submit',{ 
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
				$('#g_edit_pegawai_dlg').dialog('close');		// close the dialog
				$('#g_pegawai').datagrid('reload');	// reload Data Grid
				$('#g_edit_pegawai_fm').form('reset'); //form edit harus direset
			} else {
				$.messager.show({
					title: 'Error',
					height: 100,
					msg: result.msg
				});
			}
		}
	});
}

function g_m_hapus_pegawai(){
		var row = $('#g_pegawai').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi','Hapus data pegawai '+row.nama,function(r){
				if (r){
					$.post('../json/admin_pegawai_aksi.php?page=hapus',{id_peg:row.id_peg},function(result){
						if (result.success){
							$.messager.show({
								title: 'Sukses',
								msg: "Data berhasil dihapus."
							})
							$('#g_pegawai').datagrid('reload');	// reload the user data
							 
						} else {
							$.messager.show({	// show error message
								title: 'Error',
								height: 100,
								msg: result.msg
							});
						}
					},'json');
				}
			});
		}
		else
			$.messager.alert('Peringatan','Pilih konsultasi yang akan dihapus.','warning');
}

var qr_val = {};
function g_m_qr_pegawai(){
		var row=$('#g_pegawai').datagrid('getSelected');
		if (row){
			var qr_qr = row.qr_code;
            var res = qr_qr.split('a-');

            $.ajax({
			    url:'temp_qr/'+qr_qr+'.png',
			    type:'HEAD',
			    error: function()
			    {
			        //file not exists
			    },
			    success: function()
			    {
			        $('#qr_code_img').attr('src', 'temp_qr/'+qr_qr+'.png');
			    }
			});
            if (qr_qr!='')
            {qr_val.file = qr_qr;}
        	else {qr_val.file = 'no-qr_2';}
			qr_val.nama = row.nama;

            $('#g_qr_pegawai_dlg').dialog('open').dialog('setTitle','QR Pegawai');
			$('#g_qr_pegawai_fm').form('load',{
				nama: row.nama,
				id_peg: row.id_peg,
				qr_level: row.qr_level,
				qr_code2: res[1]
			});

			url = '../json/admin_pegawai_aksi.php?page=qr_gen';
		}
		else
			$.messager.alert('Peringatan','Pilih Pegawai terlebih dahulu.','warning');

}

function g_m_qr_pegawai_generate(){
		$('#g_qr_pegawai_fm').form('submit',{ 
			url: url,
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');

				$.ajax({
				    url:'temp_qr/'+result.namafile,
				    type:'HEAD',
				    error: function()
				    {
				        $('#qr_code_img').attr('src', 'temp_qr/no-qr.png');
				    },
				    success: function()
				    {
				        $('#qr_code_img').attr('src', 'temp_qr/'+result.namafile);
				        qr_val.file = result.namafile.slice(0, -4);
						qr_val.nama = result.nama;
				    }
				});		
				
				if (result.success){
					$.messager.show({
						title: 'Sukses',
						msg: "Berhasil di Generate dan Disimpan"
					})
					//$('#g_qr_pegawai_dlg').dialog('close');		// close the dialog
					$('#g_pegawai').datagrid('reload');	// reload the user data
					$('#g_edit_pegawai_fm').form('reset'); //form edit harus direset
										
				} else {
					qr_val.file = 'no-qr_2';
					$.messager.show({
						title: 'Error',
						height: 100,
						timeout:7000,
						msg: result.msg
					});
				}
			}
		});
	}

function g_m_qr_pegawai_cetak(){
    var mywindow = window.open('', 'PRINT', 'height=400,width=300');

    mywindow.document.write('<html><head><title> Cetak: ' + qr_val.nama + '</title>');
    mywindow.document.write('<link rel=\'stylesheet\' href=\'../css/qr_cetak.css\'></head><body>');
    mywindow.document.write('<div class=\'qr_cetak\'>');
    mywindow.document.write('<div class=\'kop_cetak\'>');
    mywindow.document.write('<img src=\'../images/logo.png\' width=\'50\'>');
    mywindow.document.write('<span>SMAN 1 Mandastana</span>');
    mywindow.document.write('</div>');
    mywindow.document.write('<h3>' + qr_val.nama + '</h3>');
    mywindow.document.write('<img src=\'temp_qr/' + qr_val.file + '.png\'>');
    mywindow.document.write('</div></body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    //mywindow.close();

    return true;
}

</script>
</html>