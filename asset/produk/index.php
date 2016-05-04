<?php
	error_reporting(E_ALL & ~E_NOTICE);
	session_start();
	include '../../koneksi/koneksi.php';
	include '../../fungsi/sidebar/index.php';
	include '../../fungsi/produk/index.php';
	include '../login/check_login_pegawai.php';

	if (empty($_SESSION['username']) OR empty($_SESSION['jabatan'])) {
		header('location:../login/');
	}

	Sidebar();
	
	?>
	<section class="content-header">
      	<h1>
        	Produk
        	<small></small>
      	</h1>
      	<ol class="breadcrumb">
        	<li><a href=""><i class="fa fa-user"></i> Produk</a></li>
      	</ol>
	</section>

	<?php
		//jika manager yang masuk
		if (!empty($user_check) AND $jabatan == "manager" OR $jabatan=="direktur" OR $jabatan=="inventori") {
			?>
				<!-- Main content -->
				<section class="content">
					<!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
					<center>
					</center>
					<center>
						
						<?php
							//Jika pegawai inventori yang masuk
							if ($jabatan=="inventori") {
									//select kategori
									$sql = "SELECT id_kategori, nama_kategori FROM kategori_produk";							
									$stmt = $db->prepare($sql);
									$stmt->execute();

									$stmt->bind_result($id_kategori, $nama_kategori);
									
								?>
								<form method="post" action="">
							        <div class="box-header">
							          	<div class="box-tools pull-right">
							            	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							            	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
							          	</div>
							        	<!-- /.box-header -->
							        	<div class="box-body">
							          		<div class="row">
							          			<div class="box-header with-border">
													<h4 class="box-title">Tambah Produk</h5>
													<div class="box-tools pull-right">
										            	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
													</div>
												</div>
							            		<div class="col-md-6">
							              			<!-- /.form-group -->
							              			<div class="form-group">
														<input class="form-control" id="kode_produk" type="text" name="kode_produk" placeholder="Kode Produk" required>							                		
							              			</div>
							              			<div class="form-group">
									                	<select class="form-control select2" style="width: 100%;" name="kategori" required>
									                		<option selected="selected">Kategori Produk</option>
									                		<?php
																while ($stmt->fetch()) {
																	?>
																		<option value="<?php echo $id_kategori;?>"><?php echo $nama_kategori; ?></option>
																	<?php
																}
															?>
									                	</select>
									              	</div>
							              			<!-- /.form-group -->
							            		</div>
							            		<!-- /.col -->
									            <div class="col-md-6">
									              	<div class="form-group">
									                	<input class="form-control" id="nama_produk" name="nama_produk" type="text" placeholder="Nama Produk" required>
									              	</div>
									              	<!-- /.form-group -->
									              	<div class="form-group">
									                	<input class="form-control" id="harga" type="text" name="harga" placeholder="Harga Rp.0,00" required>
									              	</div>
							              			<!-- /.form-group -->
							            		</div>
							            		<div class="col-md-1"><button class="btn btn-primary" name="simpan">Simpan</button></div>
							            		<div class="col-md-12">
							            		<?php							            		
													if (isset($_POST['simpan'])) {
														//jika tombol submit ditekan maka excute fungsi ini
														TambahDataProduk();
													}
												?>
												</div>	
							            		<!-- /.col -->
							          		</div>
							          		<!-- /.row -->
							        	</div>
							        </form>
									
									<hr/>	
								<?php
							}

							//Tampilkan Data Produk 
							$sql = "SELECT id_produk, kode_produk, nama_produk, harga, status_produk, nama_kategori FROM produk, kategori_produk WHERE produk.id_kategori = kategori_produk.id_kategori";							
							$stmt = $db->prepare($sql);
							$stmt->execute();

							$stmt->bind_result($id_produk, $kode_produk, $nama_produk, $harga, $status_produk, $nama_kategori);
						?>
						<center>
							<h2><small>Daftar Produk Lumpur Mas</small></h2>
						</center>	
						<table style="width:90%" class="table table-stripped">
							<tr>
								<th>No</th>
								<th>Kode Produk</th>
								<th>Nama Produk</th>
								<th>Harga</th>
								<th>Kategori</th>
								<?php
									if ($jabatan=="inventori") {
										?>
											<th colspan="2"></th>
										<?php
									}
								?>
							</tr>
						<?php
							$no = 1;
							while ($stmt->fetch()) {
							?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td><?php echo $kode_produk; ?></td>
								<td><?php echo $nama_produk; ?></td>
								<td>
									<?php 
										//format rupiah
										$jumlah_desimal ="2";
										$pemisah_desimal =",";
										$pemisah_ribuan =".";

										echo "Rp." .number_format($harga, $jumlah_desimal, $pemisah_desimal, $pemisah_ribuan); 
									?>
								</td>
								<td><?php echo $nama_kategori; ?></td>
								<?php
									if ($jabatan=="inventori") {
										?>
											<td><a href="edit_produk.php?id_produk=<?php echo $id_produk;?>">Edit</a></td>
											<td><a href="hapus_produk.php?id_produk=<?php echo $id_produk;?>">Hapus</a></td>
										<?php
									}
								?>
							</tr>
							<?php
							}				
						?>
						</table>
					</center>
					<div class="box-footer">
		          		
					</div>
					</div>
				</section>					
			<?php
		}else{
			//alihkan url jika bukan manager
			header('location:../login/');
		}

		CloseSidebar();
	?>