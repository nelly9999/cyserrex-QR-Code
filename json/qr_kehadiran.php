<?php
include '../koneksi.php';

	$sql=$db->query("SELECT * FROM kehadiran");
	
?>
	<option value="">Jenis Kehadiran</option>
<?php
	while($khd = $sql->fetch_assoc()) {
?>
	<option value="<?php echo $khd['id_khd']; ?>"><?php echo $khd["nama_khd"]; ?></option>
<?php
	}
?>