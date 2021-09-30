<?php
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "berita";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if($_GET['hal'] == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE berita set
											     id_berita = '$_POST[tid_berita]',
                                                 id_kategori = '$_POST[tid_kategori]',
											 	judul = '$_POST[tjudul]',
											      isi = '$_POST[tisi]',
                                                  gambar = '$_POST[tgambar]',
                                                  pengirim = '$_POST[tpengirim]',
											 WHERE id_berita = '$_GET[tid]'
										   ");
			if($edit) //jika edit sukses
			{
				echo "<script>
						alert('Edit data suksess!');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Edit data GAGAL!!');
						document.location='index.php';
				     </script>";
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO berita (id_berita, judul, isi, gambar, pengirim)
										  VALUES ('$_POST[tid_berita]', 
										  		 '$_POST[judul]', 
										  		 '$_POST[isi]',
                                                   '$_POST[gambar]',
                                                   '$_POST[pengirim]'
										 ");
			if($simpan) //jika simpan sukses
			{
				echo "<script>
						alert('Simpan data suksess!');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Simpan data GAGAL!!');
						document.location='index.php';
				     </script>";
			}
		}


		
	}


	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if($_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM berita WHERE id_berita = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
				$vid_berita = $data['id_berita'];
				$vjudul = $data['judul'];
                $visi = $data['isi'];
                $vgambar = $data['gambar'];
                $vpengirim = $data['pengirim'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM berita WHERE id_berita = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Hapus Data Suksess!!');
						document.location='index.php';
				     </script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Tugas Crud OOP</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
	<!-- Awal Card Form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Penambahan Berita
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>ID Berita</label>
	    		<input type="number" name="tid_kategori" value="<?=@$vid_berita?>" class="form-control" required>
	    	</div>

	    	<div class="form-group">
	    		<label>Judul Berita</label>
	    		<input type="text" name="tnm_kategori" value="<?=@$vjudul?>" class="form-control" required>
	    	</div>

	    	<div class="form-group">
	    		<label>Isi</label>
	    		<textarea class="form-control" name="tdeskripsi" ><?=@$visi?></textarea>
	    	</div>

            <div class="form-group">
	    		<label>Gambar</label>
	    		<input type="file" name="tnm_kategori" value="<?=@$vgambar?>" class="form-control" required>
	    	</div>

            <div class="form-group">
	    		<label>Pengirim</label>
	    		<input type="text" name="tnm_kategori" value="<?=@$cpengirim?>" class="form-control" required>
	    	</div>

	    	<br>
	    	<button type="submit" class="btn btn-warning" name="bsimpan">Save</button>
	    	<button type="reset" class="btn btn-dark" name="breset">Clear</button>

	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form -->

	<!-- Awal Card Tabel -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftar Berita
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>ID Berita</th>
	    		<th>Judul Berita</th>
	    		<th>Isi</th>
	    		<th>Gambar</th>
                <th>Pengirim</th>
	    	</tr>
	    	<?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from berita order by id_berita asc");
	    		while($data = mysqli_fetch_array($tampil)) :

	    	?>
	    	<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data['id_berita']?></td>
	    		<td><?=$data['judul']?></td>
	    		<td><?=$data['isi']?></td>
                <td><?=$data['gambar']?></td>
                <td><?=$data['pengirim']?></td>
	    		<td>
	    			<a href="index.php?hal=edit&id=<?=$data['id_berita']?>" class="btn btn-primary"> Edit </a>
	    			<a href="index.php?hal=hapus&id=<?=$data['id_berita']?>" 
	    			   onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-success"> Hapus </a>
	    		</td>
	    	</tr>
	    <?php endwhile; //penutup perulangan while ?>
	    </table>

	  </div>
	</div>
	<!-- Akhir Card Tabel -->

</div>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>