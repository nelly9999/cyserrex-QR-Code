<html>
<script type="text/javascript">
$("li a").removeClass("active");
$( ".statistik a" ).addClass( "active" );
$('.halmn').append('Statistik');
</script>
<script src="chart/Chart.bundle.js"></script>
<script src="chart/utils.js"></script>
<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    </style>

<!--TABLE/GRID PRESENSI -->
<div id="g_statistik_tb">
	<input class="easyui-combobox" style="width:150px" id="id_peg"
					data-options="url:'../json/cmb_statistik.php',
								method:'get',
								prompt:'Nama Pegawai',
								valueField:'id_peg',
								textField:'nama',
								panelHeight:'auto',
								onSelect: function(rec){					
									var url = '../json/admin_statistik.php?id_peg='+rec.id_peg;
									$('#g_statistik').datagrid('reload', url);
									$.ajax({ 
									        type: 'GET', 
									        url: '../json/admin_statistik.php?id_peg='+rec.id_peg, 
									        success: function (data) { 
									            $('#g_statistik').datagrid({title: 'Nama: '+data.rows[0].nama});
									            $('#total').html(data.rows2.total_k);
									            $('#kerja').html(data.rows2.kerja_t);
									        }
									    });
									}
	">
	<a href="#" class="easyui-linkbutton" iconCls="icon-trashdel" plain="true" onclick="g_m_hapus_presensi()">Batas Jam Masuk</a>
	<!--a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="g_m_cetak_pegawai()">Cetak QR</a-->
	<span id="total" style="padding: 0 5px 0 5px; border-left:1px solid #000;height:500px"><b>Total:</b> -</span> 
	<span id="kerja" style="padding: 0 5px 0 5px; border-left:1px solid #000;height:500px"><b>Rata2 Kerja Perhari:</b> -</span>
</div>
<table class="easyui-datagrid" title="Semua Pegawai" style="width:100%;height:320px" id="g_statistik"
		data-options="singleSelect:false, url:'../json/admin_statistik.php', showFooter:true,toolbar:'#g_statistik_tb',
					  fitColumns:true, remoteSort:true, autoRowHeight:true, rownumbers: true, singleSelect:true, pagination:true,
					  pageSize:10, pageList: [10,20,50,100]">
	<thead>
		<tr>
			<!--th data-options="field:'id_pegawaia',hidden:true"></th-->
			<!--th data-options="field:'id_peg',sortable:true">ID Pegawai</th-->
			<th data-options="field:'tgl',sortable:true">Tanggal</th>	
			<th data-options="field:'jam_msk',sortable:true">Jam Masuk</th>
			<th data-options="field:'jam_plg',sortable:true">Jam Pulang</th>	
			<th data-options="field:'lama_k',sortable:true">Lama Kerja</th>
			<th data-options="field:'terlambat',sortable:true">Terlambat</th>
		</tr>
	</thead>
</table>


<div id="container" style="width: 75%;">
        <canvas id="canvas"></canvas>
</div>
<script>
        var MONTHS = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"];
        var color = Chart.helpers.color;
        var barChartData = {
            labels: <?php echo json_encode($noArr); ?>,
            datasets: [ {
                label: 'Total Presensi',
                backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: [1,2,3]
            }]

        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: '<?php echo $namanya ?>'
                    },
                    scales: {
				        yAxes: [{
				            display: true,
				            ticks: {
				                suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
				                // OR //
				                //beginAtZero: true   // minimum value will be 0.
				            }
				        }]
				    }
                }
            });

        };      

    </script>
</html>