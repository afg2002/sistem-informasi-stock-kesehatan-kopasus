<?php
ob_start();
require_once 'template/header.php';


// Menangani form tambah data obat
if (isset($_GET['action']) && $_GET['action'] == 'addObat') {
    if (
        isset($_POST['tanggal']) &&
        isset($_POST['nama_obat']) &&
        isset($_POST['merk']) &&
        isset($_POST['jumlah']) &&
        isset($_POST['jenis']) &&
        isset($_POST['keterangan'])&&
        isset($_POST['kategori_obat'])
    ) {
        $tanggal = $_POST['tanggal'];
        $namaObat = $_POST['nama_obat'];
        $merk = $_POST['merk'];
        $jumlah = $_POST['jumlah'];
        $jenis = $_POST['jenis'];
        $keterangan = $_POST['keterangan'];
        $id_kategori_obat = $_POST['kategori_obat'];

        if (addObat($tanggal, $namaObat, $merk, $jumlah, $jenis, $keterangan, $id_kategori_obat)) {
            header("Location: obat.php?success=1");
            exit();
        } else {
            header("Location: obat.php?success=0");
            exit();
        }
    }
}

//Refactor
if (isset($_GET['action']) && $_GET['action'] == 'updateObat') {
    $id = $_POST['edit_id'];
    $tanggal = $_POST['edit_tanggal'];
    $namaObat = $_POST['edit_nama_obat'];
    $merk = $_POST['edit_merk'];
    $jumlah = $_POST['edit_jumlah'];
    $jenis = $_POST['edit_jenis'];
    $keterangan = $_POST['edit_keterangan'];
    $id_kategori_obat = $_POST['edit_kategori_obat'];

    // var_dump($id_kategori_obat);

    if (!empty($id) && !empty($tanggal) && !empty($namaObat) && !empty($merk) && !empty($jumlah) && !empty($jenis) && !empty($keterangan) && !empty($id_kategori_obat)) {
        updateObatData($id, $tanggal, $namaObat, $merk, $jumlah, $jenis, $keterangan,$id_kategori_obat);
        header("Location: obat.php?success=1");
        
    } else {
        header("Location: obat.php?success=0");
    }
}

// Menangani aksi penghapusan data obat
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = deleteObatData($id);
    if ($result) {
        header("Location: obat.php?success=1"); // Redirect to success page
    } else {
        header("Location: obat.php?success=0"); // Redirect to failure page
        
    }

    exit(); // Stop further processing
}

// Mendapatkan data obat dari database
$obatData = getObatData();
$analgetikData = getAnalgetikData();
$antibioticData = getAntibioticData();
$gigiData = getGigiData();
$reagentLabData = getReagentLabData();
$kategoriObatData = getKategoriObatData();



?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Obat</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Obat</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div> <!-- /.content-header -->
<!-- Tampilkan flash message jika ada -->
<?php if (isset($_SESSION['flash_message'])) : ?>
    <?php
    $flashMessage = $_SESSION['flash_message'];
    $alertType = ($flashMessage['type'] == 'success') ? 'success' : 'danger';
    $alertMessage = $flashMessage['message'];
    ?>

    <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
        <?php echo $alertMessage; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php unset($_SESSION['flash_message']); // Hapus pesan setelah ditampilkan ?>
<?php endif; ?>

<!-- Tabel untuk menampilkan data obat -->
<div class="card">
    <div class="card-header">
        <h3 >Daftar Obat</h3>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#addObatModal">[+]Tambah Data Obat</a>
            <a href="penerimaan_obat.php" class="btn btn-danger">Penerimaan Obat</a>
            <a href="pengeluaran_obat.php" class="btn btn-danger">Pengeluaran Obat</a>
        </div>
            <h5 class="mt-5"><b>Kategori Obat : ANALGETIK/ANTIPRETIK</b></h5>
            <a class="btn btn-danger" href="report/reportObatAnalgetik.php">Cetak Obat Analgetik</a>
            <table id="analgetikTable" class="table table-bordered table-striped" data-source="getObatData.php?kategori=analgetik">
        <!-- Struktur tabel (header) -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Obat</th>
                <th>Merk</th>
                <th>Jumlah</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <!-- Isi tabel -->
        <tbody>
            <?php foreach ($analgetikData as $obat) : ?>
                <tr>
                    <td><?php echo $obat['id']; ?></td>
                    <td><?php echo $obat['tanggal']; ?></td>
                    <td><?php echo $obat['nama_obat']; ?></td>
                    <td><?php echo $obat['merk']; ?></td>
                    <td><?php echo $obat['jumlah']; ?></td>
                    <td><?php echo $obat['jenis']; ?></td>
                    <td><?php echo $obat['keterangan']; ?></td>
                    <td>
                        <a href="#" class="btn btn-primary btn-edit" data-id="<?php echo $obat['id']; ?>" data-nama-obat="<?php echo $obat['nama_obat']; ?>" data-merk="<?php echo $obat['merk']; ?>" data-jumlah="<?php echo $obat['jumlah']; ?>" data-jenis="<?php echo $obat['jenis']; ?>" data-tanggal="<?php echo $obat['tanggal']; ?>" data-keterangan="<?php echo $obat['keterangan']; ?>">Edit</a>
                        <a href="obat.php?action=delete&id=<?php echo $obat['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h5 class="mt-5"><b>Kategori Obat : ANTIBIOTIC</b></h5>
    <a class="btn btn-danger" href="report/reportObatAntibiotic.php">Cetak Obat Antibiotic</a>
        <table id="antibioticTable" class="table table-bordered table-striped" data-source="getObatData.php?kategori=analgetik">
    <!-- Struktur tabel (header) -->
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Nama Obat</th>
            <th>Merk</th>
            <th>Jumlah</th>
            <th>Jenis</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <!-- Isi tabel -->
    <tbody>
        <?php foreach ($antibioticData as $obat) : ?>
            <tr>
                <td><?php echo $obat['id']; ?></td>
                <td><?php echo $obat['tanggal']; ?></td>
                <td><?php echo $obat['nama_obat']; ?></td>
                <td><?php echo $obat['merk']; ?></td>
                <td><?php echo $obat['jumlah']; ?></td>
                <td><?php echo $obat['jenis']; ?></td>
                <td><?php echo $obat['keterangan']; ?></td>
                <td>
                    <a href="#" class="btn btn-primary btn-edit" data-id="<?php echo $obat['id']; ?>" data-tanggal="<?php echo $obat['tanggal']; ?>" data-nama-obat="<?php echo $obat['nama_obat']; ?>" data-merk="<?php echo $obat['merk']; ?>" data-jumlah="<?php echo $obat['jumlah']; ?>" data-jenis="<?php echo $obat['jenis']; ?>" data-keterangan="<?php echo $obat['keterangan']; ?>">Edit</a>
                    <a href="obat.php?action=delete&id=<?php echo $obat['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h5 class="mt-5"><b>Kategori Obat : GIGI</b></h5>
<a class="btn btn-danger" href="report/reportObatGigi.php">Cetak Obat Gigi</a>
        <table id="gigiTable" class="table table-bordered table-striped" data-source="getObatData.php?kategori=analgetik">
    <!-- Struktur tabel (header) -->
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Nama Obat</th>
            <th>Merk</th>
            <th>Jumlah</th>
            <th>Jenis</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <!-- Isi tabel -->
    <tbody>
        <?php foreach ($gigiData as $obat) : ?>
            <tr>
                <td><?php echo $obat['id']; ?></td>
                <td><?php echo $obat['tanggal']; ?></td>
                <td><?php echo $obat['nama_obat']; ?></td>
                <td><?php echo $obat['merk']; ?></td>
                <td><?php echo $obat['jumlah']; ?></td>
                <td><?php echo $obat['jenis']; ?></td>
                <td><?php echo $obat['keterangan']; ?></td>
                <td>
                    <a href="#" class="btn btn-primary btn-edit" data-id="<?php echo $obat['id']; ?>" data-tanggal="<?php echo $obat['tanggal']; ?>" data-nama-obat="<?php echo $obat['nama_obat']; ?>" data-merk="<?php echo $obat['merk']; ?>" data-jumlah="<?php echo $obat['jumlah']; ?>" data-jenis="<?php echo $obat['jenis']; ?>" data-keterangan="<?php echo $obat['keterangan']; ?>">Edit</a>
                    <a href="obat.php?action=delete&id=<?php echo $obat['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h5 class="mt-5"><b>Kategori Obat : REAGENT LAB</b></h5>
<a class="btn btn-danger" href="report/reportObatReagentLab.php">Cetak Obat ReagentLab</a>
        <table id="reagentLabTable" class="table table-bordered table-striped" data-source="getObatData.php?kategori=analgetik">
    <!-- Struktur tabel (header) -->
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Nama Obat</th>
            <th>Merk</th>
            <th>Jumlah</th>
            <th>Jenis</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <!-- Isi tabel -->
    <tbody>
        <?php foreach ($reagentLabData as $obat) : ?>
            <tr>
                <td><?php echo $obat['id']; ?></td>
                <td><?php echo $obat['tanggal']; ?></td>
                <td><?php echo $obat['nama_obat']; ?></td>
                <td><?php echo $obat['merk']; ?></td>
                <td><?php echo $obat['jumlah']; ?></td>
                <td><?php echo $obat['jenis']; ?></td>
                <td><?php echo $obat['keterangan']; ?></td>
                <td>
                    <a href="#" class="btn btn-primary btn-edit" data-id="<?php echo $obat['id']; ?>" data-tanggal="<?php echo $obat['tanggal']; ?>" data-nama-obat="<?php echo $obat['nama_obat']; ?>" data-merk="<?php echo $obat['merk']; ?>" data-jumlah="<?php echo $obat['jumlah']; ?>" data-jenis="<?php echo $obat['jenis']; ?>" data-keterangan="<?php echo $obat['keterangan']; ?>">Edit</a>
                    <a href="obat.php?action=delete&id=<?php echo $obat['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



    </div>
</div>

<!-- Modal Tambah Data Obat -->
<div class="modal fade" id="addObatModal" tabindex="-1" aria-labelledby="addObatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="obat.php?action=addObat" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addObatModalLabel">Tambah Data Obat</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_obat">Nama Obat</label>
                        <input type="text" class="form-control" id="nama_obat" name="nama_obat" required>
                    </div>
                    <div class="form-group">
                        <label for="merk">Merk</label>
                        <input type="text" class="form-control" id="merk" name="merk" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis</label>
                        <select class="form-control" id="jenis" name="jenis" required>
                        <option value="">Pilih Bentuk Sediaan Obat</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Kapsul">Kapsul</option>
                        <option value="Sirup">Sirup</option>
                        <option value="Injeksi">Injeksi</option>
                        <option value="Salep">Salep</option>
                        <option value="Krim">Krim</option>
                        <option value="Gel">Gel</option>
                        <option value="Suppositoria">Suppositoria</option>
                        <option value="Larutan">Larutan</option>
                        <option value="Emulsi">Emulsi</option>
                        <option value="Suspensi">Suspensi</option>
                        <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                    </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kategori_obat">Kategori Obat</label>
                        <select class="form-control" id="kategori_obat" name="kategori_obat" required>
                            <option value="-">-- Pilih Kategori Obat -- </option>
                            <?php foreach ($kategoriObatData as $kategori) : ?>
                                <option value="<?php echo $kategori['id']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Edit Data Obat -->
<div class="modal fade" id="editObatModal" tabindex="-1" aria-labelledby="editObatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="obat.php?action=updateObat" id="editObatForm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editObatModalLabel">Edit Data Obat</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="form-group">
                        <label for="edit_tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="edit_tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_obat">Nama Obat</label>
                        <input type="text" class="form-control" id="edit_nama_obat" name="edit_nama_obat" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_merk">Merk</label>
                        <input type="text" class="form-control" id="edit_merk" name="edit_merk" required>
                    </div>
                    <!-- Disabled input karena tidak perlu diisi -->
                    <div class="form-group">
                        <label for="edit_jumlah">Jumlah</label>
                        <input type="number" disabled class="form-control" id="edit_jumlah" name="edit_jumlah" required>
                        <p class="text-muted">Jika ingin mengedit jumlah, silakan pergi ke bagian penerimaan dan pengeluaran.</p>
                    </div>
                    <div class="form-group">
                        <label for="edit_jenis">Jenis</label>
                        <select class="form-control" id="edit_jenis" name="edit_jenis" required>
                        <option value="">Pilih Bentuk Sediaan Obat</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Kapsul">Kapsul</option>
                        <option value="Sirup">Sirup</option>
                        <option value="Injeksi">Injeksi</option>
                        <option value="Salep">Salep</option>
                        <option value="Krim">Krim</option>
                        <option value="Gel">Gel</option>
                        <option value="Suppositoria">Suppositoria</option>
                        <option value="Larutan">Larutan</option>
                        <option value="Emulsi">Emulsi</option>
                        <option value="Suspensi">Suspensi</option>
                        <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                    </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_keterangan">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan" name="edit_keterangan" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kategori_obat">Kategori Obat</label>
                        <select class="form-control" id="edit_kategori_obat" name="edit_kategori_obat" required>
                            <?php foreach ($kategoriObatData as $kategori) : ?>
                                <option value="<?php echo $kategori['id']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once 'template/footer.php'; ?>
<script>
    $(document).ready(function() {
        $('#analgetikTable').DataTable();
        $('#antibioticTable').DataTable();
        $('#gigiTable').DataTable();
        $('#reagentLabTable').DataTable();


    /// Tambahkan kelas "btn-edit" ke tombol "Edit" di setiap tabel
    $('#analgetikTable, #antibioticTable, #gigiTable, #reagentLabTable').on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        var tanggal = $(this).data('tanggal');
        var namaObat = $(this).data('nama-obat');
        var merk = $(this).data('merk');
        var jumlah = $(this).data('jumlah');
        var jenis = $(this).data('jenis');
        var keterangan = $(this).data('keterangan');
        // Mendapatkan ID tabel yang sesuai
//         1
// ANALGETIK/ANTIPRETIK
	
// Edit Edit
// Copy Copy
// Delete Delete
// 2
// ANTIBIOTIC
	
// Edit Edit
// Copy Copy
// Delete Delete
// 3
// GIGI
	
// Edit Edit
// Copy Copy
// Delete Delete
// 4
// REAGENT LAB
        var tableId = $(this).closest('table').attr('id');
        console.log('Tabel ID:', tableId);
        var kategoriObat;
        if(tableId == 'analgetikTable'){
            kategoriObat = 'ANALGETIK/ANTIPRETIK';
        }else if(tableId == 'antibioticTable'){
            kategoriObat = 'ANTIBIOTIC';
        }else if(tableId == 'gigiTable'){
            kategoriObat = 'GIGI';
        }else if (tableId == 'reagentLabTable'){
            kategoriObat = 'REAGENT LAB';
        }
        console.log(kategoriObat);

        // Menyaring opsi yang sesuai dengan kategoriObat
        var optionToSelect = $("#edit_kategori_obat option").filter(function() {
            return $(this).text() === kategoriObat;
        });

        // Menandai opsi yang sesuai sebagai terpilih
        optionToSelect.prop('selected', true);


        $('#edit_id').val(id);
        $('#edit_tanggal').val(tanggal);
        $('#edit_nama_obat').val(namaObat);
        $('#edit_merk').val(merk);
        $('#edit_jumlah').val(jumlah);
        $('#edit_jenis').val(jenis);
        // $("#edit_kategori_obat").val(2);
        $('#edit_keterangan').val(keterangan);

        $('#editObatModal').modal('show');
    });


    // Mengirim data edit ke server saat formulir disubmit
    $('#editObatForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(response) {
                alert('Data Obat berhasil diupdate.');
                $('#editObatModal').modal('hide');
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan saat mengupdate data Obat.');
            }
        });
    });
});

</script>
