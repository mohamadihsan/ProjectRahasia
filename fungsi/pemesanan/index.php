<?php
	
	/*========================= TAMBAH DATA PEMESANAN ========================*/
	function TambahDataPemesanan()
	{
		include '../../koneksi/koneksi.php';

		//inisialisasi
		$status_garansi = $_POST['status_garansi'];
		$produk = $_POST['produk'];
		$jumlah_beli = $_POST['jumlah_beli'];
		$member = $_POST['member'];
		$username = $_POST['username'];
		$nama_garansi = $_POST['nama_garansi'];
		$telp_garansi = $_POST['telp_garansi'];

		if ($member=="M") {
			$nama_pelanggan_trx = $username;

			$sql = "SELECT id_user FROM pelanggan WHERE nama='$username'";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$stmt->bind_result($id_user);
			$stmt->fetch();
			$stmt->close();

			$sql = "SELECT no_telp FROM pelanggan WHERE id_user='$id_user'";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$stmt->bind_result($telp);
			$stmt->fetch();
			$stmt->close();
		}else{
			$nama_pelanggan_trx = $nama_garansi;
			$telp = $telp_garansi;
		}

		//insert ke transaksi
		$sql = "INSERT INTO transaksi (nama_garansi, telp_garansi) VALUES(?, ?)";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('ss', $nama_pelanggan_trx, $telp);
		if($stmt->execute()){
			$stmt->insert_id;
			$_SESSION['status_operasi_tr'] = "berhasil_menyimpan";
		}else{
			$_SESSION['status_operasi_tr'] = "gagal_menyimpan";
		}
		$stmt->close();

		$sql = "SELECT id_transaksi FROM transaksi ORDER BY id_transaksi DESC LIMIT 1";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($id_transaksi);
		$stmt->fetch();
		$stmt->close();

		for($i=0;$i<count($produk);$i++){
			//insert ke detail transaksi
			$sql = "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah_beli) VALUES(?, ?, ?)";
			$stmt = $db->prepare($sql);
			$stmt->bind_param('isi', $id_transaksi, $produk[$i], $jumlah_beli[$i]);
			if($stmt->execute()){
				$_SESSION['status_operasi_tr'] = "berhasil_menyimpan";
			}else{
				$_SESSION['status_operasi_tr'] = "gagal_menyimpan";
			}
			$stmt->close();
		}

		//select id trx
		$sql = "SELECT id_transaksi FROM transaksi ORDER BY id_transaksi DESC LIMIT 1";
		$stmt = $db->prepare($sql);
		$stmt->execute();

		$stmt->bind_result($id_transaksi);
		$stmt->fetch();
		$stmt->close();

		//select data produk
		$sql = "SELECT detail_transaksi.id_transaksi, detail_transaksi.id_produk, jumlah_beli, nama_garansi, telp_garansi, nama_produk, kode_produk, harga FROM detail_transaksi, transaksi, produk WHERE detail_transaksi.id_transaksi='$id_transaksi' AND transaksi.id_transaksi=detail_transaksi.id_transaksi AND detail_transaksi.id_produk=produk.id_produk";
		$stmt = $db->prepare($sql);
		$stmt->execute();

		$stmt->bind_result($id_transaksi, $id_produk, $jumlah_beli, $nama_garansi, $telp_garansi, $nama_produk, $kode_produk, $harga);

		$total_bayar = 0;

		while ($stmt->fetch()) {
			$total_bayar = $total_bayar + ($harga*$jumlah_beli);
		}

		$_SESSION['total_bayar'] = $total_bayar;
		$stmt->close();	

		//Update Transaksi
		$status_transaksi = "L";

		$sql = "UPDATE transaksi SET status_transaksi = ?, total_bayar = ? WHERE id_transaksi = ?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('sii', $status_transaksi, $total_bayar, $id_transaksi);
		if($stmt->execute()){
			$_SESSION['status_operasi_tr'] = "berhasil_update_total_bayar";
		}else{
			$_SESSION['status_operasi_tr'] = "gagal_update_total_bayar";
		}
		$stmt->close(); 

		//update poin pelanggan
		/*if ($member=="M") {

			$sql = "SELECT id_pelanggan, poin FROM pelanggan WHERE nama='$username'";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$stmt->bind_result($id_pelanggan, $poin_pelanggan);
			$stmt->fetch();
			$stmt->close();

			//perhitungan poin
			$temp_poin = $total_bayar / 100000;
			$poin = $poin_pelanggan + $temp_poin;

			$sql = "UPDATE pelanggan SET poin = ? WHERE id_pelanggan = ?";
			$stmt = $db->prepare($sql);
			$stmt->bind_param('ii', $poin, $id_pelanggan);
			$stmt->execute();
			$stmt->close();
		}*/
	}

	/*========================= EDIT DATA PEMESANAN ========================*/
	function EditDataPemesanan()
	{
		include '../../koneksi/koneksi.php';

		//inisialisasi
		$nama_kategori = $_POST['nama_kategori'];
		$id_kategori_produk = $_POST['id_kategori'];

		//update ke tabel pegawai
		$sql = "UPDATE kategori_produk SET nama_kategori = ? WHERE id_kategori = ?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('si', $nama_kategori, $id_kategori_produk);
		if($stmt->execute()){
			$_SESSION['status_operasi_tr'] = "berhasil_memperbaharui";
		}else{
			$_SESSION['status_operasi_tr'] = "gagal_memperbaharui";
		}
		$stmt->close();
	}

	function EditTanggalPengambilan()
	{
		include '../../koneksi/koneksi.php';

		//inisialisasi
		$tanggal_pengambilan = $_POST['tanggal_pengambilan'];
		$id_pemesanan = $_POST['id_pemesanan'];
 		$status_pemesanan = "SL";

		//update ke tabel pemesanan
		$sql = "UPDATE pemesanan SET status_pemesanan = ?, tgl_pengambilan = ? WHERE id_pemesanan = ?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('ssi', $status_pemesanan, $tanggal_pengambilan, $id_pemesanan);
		if($stmt->execute()){
			$_SESSION['status_operasi_tr'] = "berhasil_memperbaharui";
		}else{
			$_SESSION['status_operasi_tr'] = "gagal_memperbaharui";
		}
		$stmt->close();

		$tanggal = Tanggal($tanggal_pengambilan);

		//get id pelanggan
		$sql = "SELECT id_pelanggan FROM pemesanan WHERE id_pemesanan='$id_pemesanan'";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($id_pelanggan);
		$stmt->fetch();
		$stmt->close();

		//get no telp
		$sql = "SELECT no_telp FROM pelanggan WHERE id_pelanggan='$id_pelanggan'";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($no_telp);
		$stmt->fetch();
		$stmt->close();

		$userkey="hyb10z"; // userkey zenziva

        $passkey="0000"; // passkey zenziva

        $text ="Terima Kasih telah melakukan pemesanan di toko kami. Barang pesanan anda dapat diambil pada tanggal: ";

        $pesan =$text.$tanggal;

        $url = "https://reguler.zenziva.net/apps/smsapi.php";$curlHandle = curl_init();

        curl_setopt($curlHandle, CURLOPT_URL, $url);

        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$no_telp.'&pesan='.urlencode($pesan));

    	curl_setopt($curlHandle, CURLOPT_HEADER, 0);

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);

        curl_setopt($curlHandle, CURLOPT_POST, 1);

        $results = curl_exec($curlHandle);

        curl_close($curlHandle);
	}

	/*========================= HAPUS DATA PEMESANAN ========================*/
	function HapusDataPemesanan()
	{
		include '../../koneksi/koneksi.php';

		//inisialisasi
		$id_pemesanan = $_GET['id_pemesanan'];

		//hapus dari tabel pemesanan
		$sql = "DELETE FROM pemesanan WHERE id_pemesanan = ?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('i', $id_pemesanan);
		if($stmt->execute()){
			$_SESSION['status_operasi_pemesanan'] = "berhasil_menghapus";
		}else{
			$_SESSION['status_operasi_pemesanan'] = "gagal_menghapus";
		}
		$stmt->close();
	}

	function TransaksiPembayaranPemesanan()
	{
		//select id trx
		$sql = "SELECT id_transaksi FROM transaksi ORDER BY id_transaksi DESC LIMIT 1";
		$stmt = $db->prepare($sql);
		$stmt->execute();

		$stmt->bind_result($id_transaksi);
		$stmt->fetch();
		$stmt->close();

		//select data produk
		$sql = "SELECT detail_transaksi.id_transaksi, detail_transaksi.id_produk, jumlah_beli, nama_garansi, telp_garansi, nama_produk, kode_produk, harga FROM detail_transaksi, transaksi, produk WHERE detail_transaksi.id_transaksi='$id_transaksi' AND transaksi.id_transaksi=detail_transaksi.id_transaksi AND detail_transaksi.id_produk=produk.id_produk";
		$stmt = $db->prepare($sql);
		$stmt->execute();

		$stmt->bind_result($id_transaksi, $id_produk, $jumlah_beli, $nama_garansi, $telp_garansi, $nama_produk, $kode_produk, $harga);

		$total_bayar = 0;

		while ($stmt->fetch()) {
			$total_bayar = $total_bayar + ($harga*$jumlah_beli);
		}
		$stmt->close();	

		//Update Transaksi
		$status_transaksi = "L";

		$sql = "UPDATE status_transaksi, total_bayar SET id_transaksi = ? WHERE id_transaksi = ?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('si', $status_transaksi, $id_kategori_produk);
		if($stmt->execute()){
			$_SESSION['status_operasi_tr'] = "berhasil_memperbaharui";
		}else{
			$_SESSION['status_operasi_tr'] = "gagal_memperbaharui";
		}
		$stmt->close();
	}

	/*========================= KIRIM BUKTI PEMBAYARAN ========================*/
	function KirimBuktiPembayaran()
	{
		include '../../koneksi/koneksi.php';

		//inisialisasi
		$id_pemesanan = $_POST['id_pemesanan'];
		$bukti_transfer = $_FILES["gambar_bukti_pembayaran"]["name"]; 
		$file_basename = substr($bukti_transfer, 0, strripos($bukti_transfer, '.')); // get ekstensi 
		$file_ext = substr($bukti_transfer, strripos($bukti_transfer, '.')); // get nama file 

		$folder = "../../asset/gambar/pemesanan/bukti_transfer/";


		if ($_FILES["bukti_transfer"]["error"] > 0){
		 	// udate ke table pemesanan
		 	$status_pemesanan = "DP";
			$sql = "UPDATE pemesanan SET status_pemesanan = ?, bukti_transfer = ? WHERE id_pemesanan = ?";
			$stmt = $db->prepare($sql);
			$stmt->bind_param('ssi', $status_pemesanan, $bukti_transfer, $id_pemesanan);
			if($stmt->execute()){
				$_SESSION['status_operasi_p'] = "berhasil_dikirim";
			}else{
				$_SESSION['status_operasi_p'] = "gagal_dikirim";
			}
			$stmt->close();
		}else{	 	 
			// Rename file
		 	$newfilename = md5($file_basename) . $file_ext;

		 	// cek apakah file sudah ada 
		 	if (file_exists("$folder".$newfilename)){
		 		$_SESSION['status_operasi_p'] = "gagal_dikirim";
		 	}else{ 
		 		//simpan gambar ke folder lalu save path/url ke database
		 		if(move_uploaded_file($_FILES["gambar_bukti_pembayaran"]["tmp_name"],"$folder".$bukti_transfer)){
		 			//update ke tabel pemesanan
		 			$status_pemesanan = "DP";
					$sql = "UPDATE pemesanan SET status_pemesanan = ?, bukti_transfer = ? WHERE id_pemesanan = ?";
					$stmt = $db->prepare($sql);
					$stmt->bind_param('ssi', $status_pemesanan, $bukti_transfer, $id_pemesanan);
					if($stmt->execute()){
						$_SESSION['status_operasi_p'] = "berhasil_dikirim";
					}else{
						$_SESSION['status_operasi_p'] = "gagal_dikirim";
					}
					$stmt->close();
		 		}else{
		 			$_SESSION['status_operasi_p'] = "gagal_dikirim";
		 		}
		 	}	
	 	}	
	}
?>
