<?php
ob_start();

require_once 'template/header.php';

// Memeriksa apakah permintaan "addAlkes" dikirimkan
if (isset($_GET['action']) && $_GET['action'] == 'addAlkes') {
    // Memeriksa apakah semua field data Alkes telah diisi
    if (isset($_POST['tanggal']) && isset($_POST['nama_alkes']) && isset($_POST['jumlah']) && isset($_POST['jenis']) && isset($_POST['keterangan'])) {
        $tanggal = $_POST['tanggal'];
        $namaAlkes = $_POST['nama_alkes'];
        $jumlah = $_POST['jumlah'];
        $jenis = $_POST['jenis'];
        $keterangan = $_POST['keterangan'];

        // Memanggil fungsi addAlkes untuk menyimpan data Alkes ke database
        if (addAlkes($tanggal, $namaAlkes, $jumlah, $jenis, $keterangan)) {
            // Redirect ke halaman sukses atau tampilkan pesan sukses
            header("Location: alkes.php?success=1");
            exit();
        } else {
            // Redirect ke halaman gagal atau tampilkan pesan gagal
            header("Location: alkes.php?success=0");
            exit();
        }
    }
}

// Menangani form update data Alkes
if (isset($_GET['action']) && $_GET['action'] == 'updateAlkes') {
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $namaAlkes = $_POST['nama_alkes'];
    $jumlah = $_POST['jumlah'];
    $jenis = $_POST['jenis'];
    $keterangan = $_POST['keterangan'];

    // Memeriksa apakah semua field data Alkes telah diisi
    if (!empty($id) && !empty($tanggal) && !empty($namaAlkes) && !empty($jumlah) && !empty($jenis) && !empty($keterangan)) {
        updateAlkesData( $id, $tanggal, $namaAlkes, $jumlah, $jenis, $keterangan);
        header("Location: alkes.php?success=1");
        
    } else {
        // Jika ada field yang kosong, redirect ke halaman gagal atau tampilkan pesan gagal
        header("Location: alkes.php?success=0");
        exit();
    }
}

// Menangani aksi penghapusan data Alkes
// Assuming $conn is a valid MySQLi connection
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = deleteAlkesData($id);
    if ($result) {
        header("Location: alkes.php?success=1"); // Redirect to success page
    } else {
        header("Location: alkes.php?success=0"); // Redirect to failure page
    }
    exit();
}


// Mendapatkan data Alkes dari database
$alkesData = getAlkesData();
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Alat Kesehatan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

        
        <div class="container-fluid">
            <!-- Selipkan alert code php nya -->
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (isset($_SESSION['flash_message'])) {
                        $flashMessage = $_SESSION['flash_message'];
                        unset($_SESSION['flash_message']); // Hapus pesan setelah ditampilkan
                        $alertType = ($flashMessage['type'] == 'success') ? 'success' : 'danger';
                        $alertMessage = $flashMessage['message'];

                        echo '<div class="alert alert-' . $alertType . ' alert-dismissible fade show" role="alert">';
                        echo $alertMessage;
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';
                       
                    }
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Alkes</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button class="btn btn-danger" data-toggle="modal" data-target="#addAlkesModal">Tambah Data Alkes</button>
                                <a class="btn btn-danger" href="report/reportAlkes.php">Cetak Data Alkes</a>
                            </div>
                            <table id="alkesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Nama Alkes</th>
                                        <th>Jumlah</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($alkesData as $alkes) { ?>
                                        <tr>
                                            <td><?php echo $alkes['id']; ?></td>
                                            <td><?php echo $alkes['tanggal']; ?></td>
                                            <td><?php echo $alkes['nama_alkes']; ?></td>
                                            <td><?php echo $alkes['jumlah']; ?></td>
                                            <td><?php echo $alkes['jenis']; ?></td>
                                            <td><?php echo $alkes['keterangan']; ?></td>
                                            <td>
                                            <a href="#" class="btn btn-primary btn-edit" data-id="<?php echo $alkes['id']; ?>"
                                                data-tanggal="<?php echo $alkes['tanggal']; ?>"
                                                data-nama-alkes="<?php echo $alkes['nama_alkes']; ?>"
                                                data-jumlah="<?php echo $alkes['jumlah']; ?>"
                                                data-jenis="<?php echo $alkes['jenis']; ?>"
                                                data-keterangan="<?php echo $alkes['keterangan'];?>">Edit</a>
                                                <a href="alkes.php?action=delete&id=<?php echo $alkes['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Add Alkes Modal -->
<div class="modal fade" id="addAlkesModal" tabindex="-1" role="dialog" aria-labelledby="addAlkesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAlkesModalLabel">Tambah Data Alkes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="?action=addAlkes" method="post">
                <div class="modal-body">
                    <!-- Form fields for adding Alkes data -->
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_alkes">Nama Alkes</label>
                        <input type="text" class="form-control" id="nama_alkes" name="nama_alkes" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis</label>
                        <select class="form-control" id="jenis" name="jenis" required>
                            <option value="">Pilih jenis alat kesehatan</option>
                            <option value="Alat Diagnostik">Alat Diagnostik</option>
                            <option value="Alat Pengukur">Alat Pengukur</option>
                            <option value="Alat Terapi">Alat Terapi</option>
                            <option value="Alat Medis">Alat Medis</option>
                            <option value="Alat Bantu Mobilitas">Alat Bantu Mobilitas</option>
                            <option value="Alat Bantu Medis">Alat Bantu Medis</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="addAlkes">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Alkes Modal -->
<div class="modal fade" id="editAlkesModal" tabindex="-1" role="dialog" aria-labelledby="editAlkesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAlkesModalLabel">Edit Data Alkes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="?action=updateAlkes" method="post">
                <div class="modal-body">
                    <!-- Form fields for editing Alkes data -->
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_alkes">Nama Alkes</label>
                        <input type="text" class="form-control" id="edit_nama_alkes" name="nama_alkes" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="edit_jumlah" name="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jenis">Jenis</label>
                        <select class="form-control" id="edit_jenis" name="jenis" required>
                            <option value="">Pilih jenis alat kesehatan</option>
                            <option value="Alat Diagnostik">Alat Diagnostik</option>
                            <option value="Alat Pengukur">Alat Pengukur</option>
                            <option value="Alat Terapi">Alat Terapi</option>
                            <option value="Alat Medis">Alat Medis</option>
                            <option value="Alat Bantu Mobilitas">Alat Bantu Mobilitas</option>
                            <option value="Alat Bantu Medis">Alat Bantu Medis</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_keterangan">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan" name="keterangan" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="updateAlkes">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'template/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#alkesTable').DataTable();
    });

    $(document).ready(function() {
    // Menampilkan modal edit saat tombol "Edit" diklik
    $('#alkesTable').on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        var tanggal = $(this).data('tanggal');
        var namaAlkes = $(this).data('nama-alkes');
        var jumlah = $(this).data('jumlah');
        var jenis = $(this).data('jenis');
        var keterangan = $(this).data('keterangan');

        $('#edit_id').val(id);
        $('#edit_tanggal').val(tanggal);
        $('#edit_nama_alkes').val(namaAlkes);
        $('#edit_jumlah').val(jumlah);
        $('#edit_jenis').val(jenis);
        $('#edit_keterangan').val(keterangan);

        $('#editAlkesModal').modal('show');
    });

    // Mengirim data edit ke server saat formulir disubmit
    $('#editAlkesForm').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(response) {
                // Handle response from server (success message, error message, etc.)
                // Misalnya, tampilkan pesan sukses dan refresh tabel Alkes
                alert('Data Alkes berhasil diupdate.');
                $('#editAlkesModal').modal('hide');
                refreshTable();
            },
            error: function(xhr, status, error) {
                // Handle error response from server
                // Misalnya, tampilkan pesan error kepada pengguna
                alert('Terjadi kesalahan saat mengupdate data Alkes.');
            }
        });
    });

    // Fungsi untuk mereset dan memuat ulang tabel Alkes
    function refreshTable() {
        // Reset form edit
        $('#editAlkesForm')[0].reset();

        // Muat ulang data tabel Alkes
        var table = $('#alkesTable').DataTable();
        table.ajax.reload();
    }
});
</script>