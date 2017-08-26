<html>
<head>
	<link rel="icon" href="../images/favico.ico" type="image/ico" sizes="32x32"> 
	<title>Administrator</title>

	<link rel="stylesheet" href="../css/qr_admin.css">
	<link rel="stylesheet" href="../easyui/themes/ui-sunny/easyui.css">
	<link rel="stylesheet" href="../easyui/themes/icon.css">
	<script type="text/javascript" src="../easyui/jquery.min.js"></script>	
	<script type="text/javascript" src="../easyui/jquery.easyui.min.js"></script>	
</head>
<body>

<nav>
	<ul>
        <li class="pegawai"><a href="index.php?p=pegawai">Pegawai</a></li>
        <li class="presensi"><a href="index.php?p=presensi">Presensi</a></li>
		<li class="laporan"><a href="index.php?p=laporan">Laporan</a></li>
		<li class="statistik"><a href="index.php?p=statistik">Statistik</a></li>
		<li class="pengaturan"><a href="index.php?p=pengaturan">Pengaturan</a></li>
        <li class="logout"><a href="index.php?p=logout">Logout</a></li>
	</ul>
</nav>
<div id="header2">
	<div class="halaman"><h3>Halaman <div class="halmn"></div></h3></div>
	<div class="user">Selamat datang, USER</div>
</div>
 
<div id="konten">
	<?php
	$pages_dir = '../admin';
	if(!empty($_GET['p'])){
		$pages = scandir($pages_dir, 0);
		unset($pages[0], $pages[1]);

		$p = $_GET['p'];
		if(in_array($p.'.php', $pages)){
			include($pages_dir.'/'.$p.'.php');
		} else {
			echo 'Halaman tidak ditemukan! :(';
		}
	} else {
		include($pages_dir.'/pegawai.php');
	}
	?>
</div>
</body>
</html>