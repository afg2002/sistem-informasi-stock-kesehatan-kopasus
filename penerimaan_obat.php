<?php
ob_start();
require_once 'template/header.php';


if (isset($_GET['action']) && $_GET['action'] == 'updateObat') {
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $idObat = $_POST['id_obat'];
    $stok_masuk = $_POST['stok_masuk'];

    $emptyFields = [];
    if (empty($id)) {
        $emptyFields[] = 'id';
    }
    if (empty($tanggal)) {
        $emptyFields[] = 'tanggal';
    }
    if (empty($idObat)) {
        $emptyFields[] = 'id_obat';
    }
    if (!isset($stok_masuk) || $stok_masuk === '') {
        $emptyFields[] = 'stok_$stok_masuk';
    }
    

    if (empty($emptyFields)) {
        updateDataPenerimaanObat($id, $tanggal, $idObat, $stok_masuk);
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Data updated successfully.'
        ];
        header("Location: penerimaan_obat.php?success=1");
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Missing data in the following field(s): ' . implode(', ', $emptyFields)
        ];
        header("Location: penerimaan_obat.php?success=0");
        exit();
    }
}



// Mendapatkan data obat dari database
$dataAnalgetik = getPenerimaanObatDataAnalgetik();
$dataAntibiotic = getPenerimaanObatDataAntibiotic();
$dataGigi = getPenerimaanObatDataGigi();
$dataReagentLab = getPenerimaanObatDataReagentLab();
$obatData = getObatData();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penerimaan Data Obat</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Penerimaan Data Obat</li>
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
        <h3 >Penerimaan Daftar Obat</h3>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <a href="obat.php" class="btn btn-danger"><< Data Obat</a>
        </div>
            <h5 class="mt-5"><b>Kategori Obat : ANALGETIK/ANTIPRETIK</b></h5>
            <a class="btn btn-danger" href="report/obat_masuk/reportObatAnalgetik.php">Cetak Obat Analgetik</a>
            <table id="obatAnalgetik" class="table table-bordered table-striped" >
        <!-- Struktur tabel (header) -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Obat</th>
                <th>Stok Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <!-- Isi tabel -->
        <tbody>
            <?php foreach ($dataAnalgetik as $obat) : ?>
                <tr>
                    <td><?php echo $obat['id']; ?></td>
                    <td><?php echo $obat['tanggal']; ?></td>
                    <td><?php echo $obat['nama_obat']; ?></td>
                    <td><?php echo $obat['stok_masuk']; ?></td>
                    <td>
                        <a href="#" class="btn btn-primary btn-edit" data-id="<?php echo $obat['id']; ?>" data-tanggal="<?php echo $obat['tanggal']; ?>" data-nama-obat="<?php echo $obat['nama_obat']; ?>" data-jumlah="<?php echo $obat['stok_masuk']; ?>" data-id>Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
             <h5 class="mt-5"><b>Kategori Obat : ANTIBIOTIC</b></h5>
             <a class="btn btn-danger" href="report/obat_masuk/reportObatAntibiotic.php">Cetak Obat Antibiotic</a>
            <table id="obatAntibiotic" class="table table-bordered table-striped" >
        <!-- Struktur tabel (header) -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Obat</th>
                <th>Stok Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <!-- Isi tabel -->
        <tbody>
            <?php foreach ($dataAntibiotic as $obat) : ?>
                <tr>
                    <td><?php echo $obat['id']; ?></td>
                    <td><?php echo $obat['tanggal']; ?></td>
                    <td><?php echo $obat['nama_obat']; ?></td>
                    <td><?php echo $obat['stok_masuk']; ?></td>
                    <td>
                        <a href="#" class="btn btn-primary btn-edit" data-id="<?php echo $obat['id']; ?>" data-tanggal="<?php echo $obat['tanggal']; ?>" data-nama-obat="<?php echo $obat['nama_obat']; ?>" data-jumlah="<?php echo $obat['stok_masuk']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
             <h5 class="mt-5"><b>Kategori Obat : GIGI</b></h5>
            <table id="obatGigi" class="table table-bordered table-striped" >
            <a class="btn btn-danger" href="report/obat_masuk/reportObatGigi.php">Cetak Obat Gigi</a>
        <!-- Struktur tabel (header) -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Obat</th>
                <th>Stok Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <!-- Isi tabel -->
        <tbody>
            <?php foreach ($dataGigi as $obat) : ?>
                <tr>
                    <td><?php echo $obat['id']; ?></td>
                    <td><?php echo $obat['tanggal']; ?></td>
                    <td><?php echo $obat['nama_obat']; ?></td>
                    <td><?php echo $obat['stok_masuk']; ?></td>
                    <td>
                        <a href="#" class="btn btn-primary btn-edit" data-id="<?php echo $obat['id']; ?>" data-tanggal="<?php echo $obat['tanggal']; ?>" data-nama-obat="<?php echo $obat['nama_obat']; ?>" data-jumlah="<?php echo $obat['stok_masuk']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
             <h5 class="mt-5"><b>Kategori Obat : REAGENT LAB</b></h5>
             <a class="btn btn-danger" href="report/obat_masuk/reportObatReagentLab.php">Cetak Obat Reagent Lab</a>
            <table id="obatReagentLab" class="table table-bordered table-striped" >
        <!-- Struktur tabel (header) -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Obat</th>
                <th>Stok Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <!-- Isi tabel -->
        <tbody>
            <?php foreach ($dataReagentLab as $obat) : ?>
                <tr>
                    <td><?php echo $obat['id']; ?></td>
                    <td><?php echo $obat['tanggal']; ?></td>
                    <td><?php echo $obat['nama_obat']; ?></td>
                    <td><?php echo $obat['stok_masuk']; ?></td>
                    <td>
                        <a href="#" class="btn btn-primary btn-edit" data-id="<?php echo $obat['id']; ?>" data-tanggal="<?php echo $obat['tanggal']; ?>" data-nama-obat="<?php echo $obat['nama_obat']; ?>" data-jumlah="<?php echo $obat['stok_masuk']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

<!-- Modal Edit Data Obat -->
<div class="modal fade" id="editObatModal" tabindex="-1" aria-labelledby="editObatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="penerimaan_obat.php?action=updateObat" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editObatModalLabel">Edit Data Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_obat">Nama Obat</label>
                        <select class="form-control" id="edit_nama_obat" name="id_obat" required>
                            <?php foreach ($obatData as $obat) : ?>
                                <option value="<?php echo $obat['id']; ?>"><?php echo $obat['nama_obat']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_jumlah">Stok Masuk</label>
                        <input type="number" class="form-control" id="edit_jumlah" name="stok_masuk" required>
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
        // $('#obatAnalgetik #obatAntibiotic #obatGigi #obatReagentLab').DataTable();
        $('#obatAnalgetik').DataTable();
        $('#obatAntibiotic').DataTable();
        $('#obatGigi').DataTable();
        $('#obatReagentLab').DataTable();


    
    $('#obatAnalgetik, #obatAntibiotic, #obatGigi, #obatReagentLab').on('click', '.btn-edit', function() {
    var id = $(this).data('id');
    var tanggal = $(this).data('tanggal');
    tanggal = tanggal.substring(0, 10); // Extract only the date portion
    var namaObat = $(this).data('nama-obat');
    var jumlah = $(this).data('jumlah');

    $('#edit_id').val(id);
    $('#edit_tanggal').val(tanggal);
    
    // $('#edit_nama_obat').val(namaObat);
    $('#edit_jumlah').val(jumlah);
    // Menyaring opsi yang sesuai dengan kategoriObat
    var optionToSelect = $("#edit_nama_obat option").filter(function() {
            return $(this).text() === namaObat;
        });

        // Menandai opsi yang sesuai sebagai terpilih
        optionToSelect.prop('selected', true);
    // console.log()

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
