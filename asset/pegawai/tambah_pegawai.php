<?php
	session_start();
	include '../../koneksi/koneksi.php';
	include '../../fungsi/register/index.php';
	include '../../fungsi/sidebar/index.php';

	Sidebar();
	
	?>
	<section class="content-header">
      	<h1>
        	Tambah Data Pegawai Baru
        	<small></small>
      	</h1>
      	<ol class="breadcrumb">
        	<li><a href="../pegawai/"><i class="fa fa-user"></i> Pegawai</a></li>
        	<li class="">Tambah Data Pegawa</li>
      	</ol>
	</section>
	<?php

	if (!empty($_SESSION['username']) AND !empty($_SESSION['jabatan'])) {
		FormRegister();
	}else{
		FormRegisterPengunjung();
	}

	CloseSidebar();

?>