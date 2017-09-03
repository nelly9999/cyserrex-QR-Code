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
    select:invalid { 
    	color: gray; 
    }
    </style>
 <script type="text/javascript">
var chart_data = new Array();
var chart_label = new Array();
 </script>
<p id='demo'></p>
<p id='demo2'></p>
<!--TABLE/GRID PRESENSI -->
<div id="g_statistik_tb">
<form style="display:inline;" id="statistik_form">
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
	<input class="easyui-combobox" plain="true" style="width:80px" id="tahun_c"
					data-options="url:'../json/cmb_statistik_tahun.php',
								method:'get',
								prompt:'Tahun',
								required: true,
								valueField:'tahun',
								textField:'tahun',
								panelHeight:'auto',
								missingMessage:'Pilih Tahun'
								">
	<input class="easyui-combobox" plain="true" style="width:150px" id="id_peg"
					data-options="url:'../json/cmb_statistik.php',
								method:'get',
								prompt:'Nama Pegawai',
								required: true,
								valueField:'id_peg',
								textField:'nama',
								panelHeight:'auto',
								missingMessage:'Pilih Pegawai'
								">
</form>
	<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="g_m_lihat_presensi()">Lihat</a>
	<!--a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="g_m_cetak_pegawai()">Cetak QR</a-->
	<span id="total" style="padding: 0 5px 0 10px; height:500px"><b>Total:</b> -</span> 
	<span id="kerja" style="padding: 0 5px 0 5px; border-left:1px solid #000;height:500px"><b>Rata2 Kerja Perhari:</b> -</span>
</div>
<table class="easyui-datagrid" title="Nama: -" style="width:100%;height:320px" id="g_statistik"
		data-options="singleSelect:false, url:'../json/admin_statistik.php', showFooter:true,toolbar:'#g_statistik_tb',
					  fitColumns:true, remoteSort:true, autoRowHeight:true, rownumbers: true, singleSelect:true, pagination:true,
					  pageSize:10, pageList: [10,20,50,100]">
	<thead>
		<tr>
			<!--th data-options="field:'id_pegawaia',hidden:true"></th-->
			<!--th data-options="field:'id_peg',sortable:true">ID Pegawai</th-->
			<th data-options="field:'jam_chart',hidden:true"></th>
			<th data-options="field:'tgl',sortable:true">Tanggal</th>	
			<th data-options="field:'jam_msk',sortable:true">Jam Masuk</th>
			<th data-options="field:'jam_plg',sortable:true">Jam Pulang</th>	
			<th data-options="field:'lama_k',sortable:true">Lama Kerja</th>
			<th data-options="field:'terlambat',sortable:true">Terlambat</th>
		</tr>
	</thead>
</table>

<div id="container" style="width: 500px;">
        <canvas id="canvas"></canvas>
</div>
<script>
	function g_m_lihat_presensi(){
		if ($('#statistik_form').form('validate'))
		{
			var id_peg = $('#id_peg').val();
			var bulanC = $('#bulan_c').val();	
			var tahunC = $('#tahun_c').val();				
			var url = '../json/admin_statistik.php?id_peg='+id_peg+'&bulan_c='+bulanC+'&tahun_c='+tahunC;
			$('#g_statistik').datagrid('reload', url);
			$.ajax({ 
			        type: 'GET', 
			        url: '../json/admin_statistik.php?id_peg='+id_peg+'&bulan_c='+bulanC+'&tahun_c='+tahunC, 
			        success: function (data) {
				        barChartData.labels.splice(0, 30); // remove chart
			            window.myBar.update();
			        	$('#g_statistik').datagrid({title: 'Nama: '+data.rows[0].nama});
			            $('#total').html(data.rows2.total_k);
			            $('#kerja').html(data.rows2.kerja_t);									           
			            for (var n=0; n<data.rows.length; n++)
			            {
			            	chart_label[n] = data.rows[n].tanggal;
			            	chart_data[n] = data.rows[n].jam_chart;    	
			            }										        		
				        window.myBar.update();	
			        }
			    });
		}
	}
    var color = Chart.helpers.color;
    var barChartData = {
        labels: chart_label,
        datasets: [ {
            label: 'Lama Waktu (Jam)',
            backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
            borderColor: window.chartColors.blue,
            borderWidth: 1,
            data: chart_data
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
                    text: 'Chart Presensi Perbulan',
                },
                scales: {
			        yAxes: [{
			            display: true,
			            ticks: {
			                suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
			                // OR //
			                //beginAtZero: true   // minimum value will be 0.
			            },
			            scaleLabel: {
					        display: true,
					        labelString: 'Jam'
					      }
			        }],
			        xAxes: [{
				      scaleLabel: {
				        display: true,
				        labelString: 'Tanggal'
				      }
				    }]
			    }
            }
        });

    };      

    </script>
</html>