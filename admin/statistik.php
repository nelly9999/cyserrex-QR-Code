<html>
<script type="text/javascript">
$("li a").removeClass("active");
$( ".statistik a" ).addClass( "active" );
$('.halmn').append('Statistik');
</script>

<?php
include '../koneksi.php';
$cek=$db->query("SELECT * FROM presensi pr 
		  		 LEFT JOIN pegawai p ON p.id_peg=pr.id_peg
		  		 WHERE p.id_peg='2'");
if(!$cek){
die($db->error);
}
echo "<table border='1'>";
$hari=0;
$jam=0;
$mnt=0;
$dtk=0;
while ($row = $cek->fetch_assoc())
	  {
echo "	<tr>
			<td>$row[nama]</td>
			<td>$row[tgl]</td>
			<td>$row[jam_msk]</td>
			<td>$row[jam_plg]</td>
		</tr>";

		if ($row['jam_msk'] > $row['jam_plg'])
			{ $tl=date('Y-m-d', strtotime($tl=$row['tgl'] . ' +1 day')); }
		else
			{$tl=$row['tgl'];}

		$awal  = date_create($row['tgl'].' '.$row['jam_msk']);
		$akhir = date_create($tl.' '.$row['jam_plg']);
		$selisih = date_diff($awal,$akhir);
		$hari+=$selisih->d;
		$jam+=$selisih->h;
		$mnt+=$selisih->i;
		$dtk+=$selisih->s;
	  }


echo "</table>";
echo $hari.' Hari. '.$jam.' Jam. '.$mnt.' Menit. '.$dtk.' Detik';
?>

</html>