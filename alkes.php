<?php
ob_start();

require_once 'template/header.php';

if (isset($_GET['action']) && $_GET['action'] == 'addAlkes') {
    // Memeriksa apakah semua field data Alkes telah diisi
    $errors = [];
    if (empty($_POST['nama_materil'])) {
        $errors['nama_materil'] = 'Nama Materil tidak boleh kosong.';
    }
    if (empty($_POST['satuan'])) {
        $errors['satuan'] = 'Satuan tidak boleh kosong.';
    }
    if (empty($_POST['merk_type'])) {
        $errors['merk_type'] = 'Merk Type tidak boleh kosong.';
    }
    if (!isset($_POST['kondisi'])) {
        $errors['kondisi'] = 'Kondisi harus dipilih.';
    }
    if (empty($_POST['keterangan'])) {
        $errors['keterangan'] = 'Keterangan tidak boleh kosong.';
    }
    if (!isset($_POST['kategori_id']) || empty($_POST['kategori_id'])) {
        $errors['kategori_id'] = 'Kategori harus dipilih.';
    }

    // Jika tidak ada error, simpan data ke database
    if (empty($errors)) {
        $namaMateril = $_POST['nama_materil'];
        $merkType = $_POST['merk_type'];
        $satuan = $_POST['satuan'];
        $kondisi = $_POST['kondisi'];
        $keterangan = $_POST['keterangan'];
        $kategoriId = $_POST['kategori_id'];

        // Memanggil fungsi addAlkes untuk menyimpan data Alkes ke database
        if (addAlkes($namaMateril, $merkType, $satuan, $kondisi, $keterangan, $kategoriId)) {
            // Redirect ke halaman sukses atau tampilkan pesan sukses
            header("Location: alkes.php?success=1");
            exit();
        } else {
            // Redirect ke halaman gagal atau tampilkan pesan gagal
            header("Location: alkes.php?success=0");
            exit();
        }
    } else {
        // Jika ada field yang kosong, set session flash message untuk pesan error
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Silakan lengkapi semua field sebelum menyimpan. <br>' . implode('<br>', $errors)
        ];
        header("Location: alkes.php"); // Redirect back to the form page
        exit();
    }
}


// Menangani form update data Alkes
if (isset($_GET['action']) && $_GET['action'] == 'updateAlkes') {
    // Ambil data dari $_POST
    $id = $_POST['edit_id'];
    $namaMateril = $_POST['nama_materil'];
    $merk_type = $_POST['merk_type'];
    $kondisi = $_POST['kondisi'];
    $satuan = $_POST["satuan"];
    $keterangan = $_POST['keterangan'];
    $kategoriId = $_POST['kategori_id'];

    // Inisialisasi array untuk menyimpan pesan kesalahan
    $errors = [];

    // Validasi setiap field
    if (empty($namaMateril)) {
        $errors[] = "Nama Materil harus diisi";
    }
    if (empty($merk_type)) {
        $errors[] = "Merk Type harus diisi";
    }
    if (empty($kondisi)) {
        $errors[] = "Kondisi harus dipilih";
    }
    if (empty($satuan)) {
        $errors[] = "Satuan harus diisi";
    }
    if (empty($keterangan)) {
        $errors[] = "Keterangan harus diisi";
    }
    if (empty($kategoriId)) {
        $errors[] = "Kategori Alkes harus dipilih";
    }

    // Jika terdapat error, set session flash_message dengan type danger dan pesan kesalahan
    if (!empty($errors)) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Silakan lengkapi semua field sebelum menyimpan. <br>' . implode('<br>', $errors)
        ];
        header("Location: alkes.php");
        exit();
    }

    // Jika semua validasi berhasil, lakukan proses update data Alkes
    updateAlkesData($id, $namaMateril, $merk_type, $satuan, $kondisi, $keterangan, $kategoriId);
    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Data Alkes berhasil diupdate.'
    ];
    header("Location: alkes.php");
    exit();
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
$kategoriAlkesData = getKategoriAlkesData();
$kategoriNames = getNamaKategoriAlkes();
$kondisiNames = getNamaKondisi();
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
                            <h3 >All Data Alkes</h3>
                            <table  class="table table-bordered table-striped alkesTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Alkes</th>
                                        <th>Nama Materil</th>
                                        <th>Merk Type</th>
                                        <th>Satuan</th>
                                        <th>Kondisi</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                <?php foreach ($alkesData as $alkes): ?>
                                        <tr>
                                            <td><?php echo $alkes['id']; ?></td>
                                            <td><?php echo $alkes['nama_kategori']; ?></td>
                                            <td><?php echo $alkes['nama_materil']; ?></td>
                                            <td><?php echo $alkes['merk_type']; ?></td>
                                            <td><?php echo $alkes['satuan']; ?></td>
                                            <td><?php echo $alkes['nama_kondisi']; ?></td>
                                            <td><?php echo $alkes['keterangan']; ?></td>
                                            <td><?php echo $alkes['tanggal']; ?></td>
                                            <td>
                                            <a href="#" class="btn btn-primary btn-edit test" data-id="<?php echo $alkes['id']; ?>"
                                            data-kategori_id="<?php echo $alkes['kategori_id']; ?>"
                                                data-tanggal="<?php echo $alkes['tanggal']; ?>"
                                                data-nama-materil="<?php echo $alkes['nama_materil']; ?>"
                                                data-merk_type="<?php echo $alkes['merk_type']; ?>"
                                                data-kondisi="<?php echo $alkes['kondisi_id']; ?>"
                                                data-satuan="<?php echo $alkes['satuan']; ?>"
                                                data-keterangan="<?php echo $alkes['keterangan'];?>">Edit</a>
                                                <a href="alkes.php?action=delete&id=<?php echo $alkes['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($alkesData)): ?>
                                        <tr>
                                            <td colspan="9" class="text-center">Tidak ada data Alkes yang tersedia.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <h4 style="margin-top: 100px;"><strong><u><center>Daftar alkes berdasarkan nama alkes</center></u></strong></h4>
                            <?php
                                foreach ($kategoriNames as $id => $kategori) {
                                    $alkesData = getDataAlkesByNamaKategori($kategori);

                                    // Output title for the table
                                    echo '<h3 style="margin-top: 50px;"><u>' . $kategori . '</u></h2>';
                                    echo '<a class="btn btn-danger" href="report/reportAlkes.php?nama_alkes='.$kategori.'">Cetak Data'.$kategori.' </a>';
                                    // Output HTML table with margin and bordered style
                                    echo '<table class="table table-bordered table-striped alkesTable" style="margin-bottom: 20px;">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th>ID</th>';
                                    echo '<th>Nama Kategori</th>';
                                    echo '<th>Nama Materil</th>';
                                    echo '<th>Merk Type</th>';
                                    echo '<th>Satuan</th>';
                                    echo '<th>Kondisi</th>';
                                    echo '<th>Keterangan</th>';
                                    echo '<th>Tanggal</th>';
                                    echo '<th>Aksi</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';

                                    if (!empty($alkesData)) {
                                        foreach ($alkesData as $alkes) {
                                            echo '<tr>';
                                            echo '<td>' . $alkes['id'] . '</td>';
                                            echo '<td>' . $alkes['nama_kategori'] . '</td>';
                                            echo '<td>' . $alkes['nama_materil'] . '</td>';
                                            echo '<td>' . $alkes['merk_type'] . '</td>';
                                            echo '<td>' . $alkes['satuan'] . '</td>';
                                            echo '<td>' . $alkes['nama_kondisi'] . '</td>';
                                            echo '<td>' . $alkes['keterangan'] . '</td>';
                                            echo '<td>' . $alkes['tanggal'] . '</td>';
                                            echo '<td>';
                                            echo '<a href="#" class="btn btn-primary btn-edit" data-id="' . $alkes['id'] . '"
                                                data-kategori_id="' . $alkes['kategori_id'] . '"
                                                data-tanggal="' . $alkes['tanggal'] . '"
                                                data-nama-materil="' . $alkes['nama_materil'] . '"
                                                data-merk_type="' . $alkes['merk_type'] . '"
                                                data-kondisi="' . $alkes['nama_kondisi'] . '"
                                                data-satuan="' . $alkes['satuan'] . '"
                                                data-keterangan="' . $alkes['keterangan'] . '">Edit</a>';
                                            echo ' <a href="alkes.php?action=delete&id=' . $alkes['id'] . '" class="btn btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</a>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        // If no data for this category, display a single row with colspan
                                        echo '<tr>';
                                        echo '<td colspan="9" class="text-center">Tidak ada data untuk kategori: ' . $kategori . '</td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody>';
                                    echo '</table>';
                                }
                                ?>


                            <h4 style="margin-top: 100px;"><strong><u><center>Daftar alkes berdasarkan kondisi</center></u></strong></h4>
                            <?php
                                foreach ($kondisiNames as $kondisi) {
                                    $alkesData = getDataAlkesByNamaKondisi($kondisi["nama_kondisi"]);

                                    // Output title for the table
                                    echo '<h3 style="margin-top: 50px;"><u>' . $kondisi["nama_kondisi"] . '</u></h2>';
                                    echo '<a class="btn btn-danger" href="report/reportAlkes.php?nama_kondisi='.$kondisi["nama_kondisi"].'">Cetak Data '.$kondisi["nama_kondisi"].' </a>';
                                    // Output HTML table with margin and bordered style
                                    echo '<table class="table table-bordered table-striped alkesTable" style="margin-bottom: 20px;">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th>ID</th>';
                                    echo '<th>Nama Kategori</th>';
                                    echo '<th>Nama Materil</th>';
                                    echo '<th>Merk Type</th>';
                                    echo '<th>Satuan</th>';
                                    echo '<th>Kondisi</th>';
                                    echo '<th>Keterangan</th>';
                                    echo '<th>Tanggal</th>';
                                    echo '<th>Aksi</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';

                                    if (!empty($alkesData)) {
                                        foreach ($alkesData as $alkes) {
                                            echo '<tr>';
                                            echo '<td>' . $alkes['id'] . '</td>';
                                            echo '<td>' . $alkes['nama_kategori'] . '</td>';
                                            echo '<td>' . $alkes['nama_materil'] . '</td>';
                                            echo '<td>' . $alkes['merk_type'] . '</td>';
                                            echo '<td>' . $alkes['satuan'] . '</td>';
                                            echo '<td>' . $alkes['nama_kondisi'] . '</td>';
                                            echo '<td>' . $alkes['keterangan'] . '</td>';
                                            echo '<td>' . $alkes['tanggal'] . '</td>';
                                            echo '<td>';
                                            echo '<a href="#" class="btn btn-primary btn-edit" data-id="' . $alkes['id'] . '"
                                                data-kategori_id="' . $alkes['kategori_id'] . '"
                                                data-tanggal="' . $alkes['tanggal'] . '"
                                                data-nama-materil="' . $alkes['nama_materil'] . '"
                                                data-merk_type="' . $alkes['merk_type'] . '"
                                                data-kondisi="' . $alkes['nama_kondisi'] . '"
                                                data-satuan="' . $alkes['satuan'] . '"
                                                data-keterangan="' . $alkes['keterangan'] . '">Edit</a>';
                                            echo ' <a href="alkes.php?action=delete&id=' . $alkes['id'] . '" class="btn btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</a>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        // If no data for this category, display a single row with colspan
                                        echo '<tr>';
                                        echo '<td colspan="9" class="text-center">Tidak ada data untuk kondisi: ' . $kondisi["nama_kondisi"] . '</td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody>';
                                    echo '</table>';
                                }
                                ?>

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
                    <div class="form-group">
                        <label for="nama_materil">Nama Materil</label>
                        <input type="text" class="form-control" id="nama_materil" name="nama_materil" required>
                    </div>
                    <div class="form-group">
                        <label for="merk_type">Merk Type</label>
                        <input type="text" class="form-control" id="merk_type" name="merk_type" required>
                    </div>
                    <div class="form-group">
                        <label for="kondisi">Kondisi</label>
                        <select class="form-control" id="kondisi" name="kondisi" required>
                            <option value="-">-- Pilih Kondisi -- </option>
                            <?php foreach ($kondisiNames as $kondisi) : ?>
                                <option value="<?php echo $kondisi['id']; ?>"><?php echo $kondisi['nama_kondisi']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Alkes</label>
                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                            <option value="-">-- Pilih Kategori Alkes -- </option>
                            <?php foreach ($kategoriAlkesData as $kategori) : ?>
                                <option value="<?php echo $kategori['id']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
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
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="form-group">
                        <label for="edit_nama_materil">Nama Materil</label>
                        <input type="text" class="form-control" id="edit_nama_materil" name="nama_materil" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_merk_type">Merk Type</label>
                        <input type="text" class="form-control" id="edit_merk_type" name="merk_type" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_kondisi">Kondisi</label>
                        <select class="form-control" id="edit_kondisi" name="kondisi" required>
                            <option value="">Pilih kondisi alat kesehatan</option>
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_satuan">Satuan</label>
                        <input type="text" class="form-control" id="edit_satuan" name="satuan" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_keterangan">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan" name="keterangan" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_kategori_id">Alkes</label>
                        <select class="form-control" id="edit_kategori_id" name="kategori_id" required>
                            <option value="-">-- Pilih Kategori Alkes --</option>
                            <?php foreach ($kategoriAlkesData as $kategori) : ?>
                                <option value="<?php echo $kategori['id']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="editAlkes">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once 'template/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('.alkesTable').DataTable();
    });

    $('.alkesTable').on('click', '.test', function() {
        console.log("test")
    });

    $(document).ready(function() {
    // Menampilkan modal edit saat tombol "Edit" diklik
    $('.alkesTable').on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        var satuan = $(this).data('satuan');
        var namaMateril = $(this).data('nama-materil');
        var satuan = $(this).data('satuan');
        var merk_type = $(this).data('merk_type');
        var kondisi = $(this).data('kondisi');
        var kategori_id = $(this).data('kategori_id');
        var keterangan = $(this).data('keterangan');

        $('#edit_id').val(id);
        $('#edit_satuan').val(satuan);
        $('#edit_nama_materil').val(namaMateril);
        $('#edit_merk_type').val(merk_type);
        $('#edit_satuan').val(satuan);
        $('#edit_kondisi').val(kondisi);
        $('#edit_keterangan').val(keterangan);
        $('#edit_kategori_id').val(kategori_id);
        

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