<?php
ob_start();
require_once 'template/header.php';


if (isset($_GET['action']) && $_GET['action'] == 'addKendaraan') {
    if (
        isset($_POST['nama_kendaraan']) &&
        isset($_POST['jenis']) &&
        isset($_POST['bbm']) &&
        isset($_POST['jumlah']) &&
        isset($_POST['keterangan'])
    ) {
        $namaKendaraan = $_POST['nama_kendaraan'];
        $jenis = $_POST['jenis'];
        $bbm = $_POST['bbm'];
        $jumlah = $_POST['jumlah'];
        $keterangan = $_POST['keterangan'];

        if (addKendaraan($namaKendaraan, $jenis, $bbm, $jumlah, $keterangan)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Kendaraan added successfully.'
            ];
            header("Location: kendaraan.php");
            exit();
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Failed to add kendaraan. Please check the input data.'
            ];
            header("Location: kendaraan.php");
            exit();
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'updateKendaraan') {
    $id = $_POST['id'];
    $namaKendaraan = $_POST['nama_kendaraan'];
    $jenis = $_POST['jenis'];
    $bbm = $_POST['bbm'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    if (!empty($id) && !empty($namaKendaraan) && !empty($jenis) && !empty($bbm) && !empty($jumlah) && !empty($keterangan)) {
        updateKendaraanData($id, $namaKendaraan, $jenis, $bbm, $jumlah, $keterangan);
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Kendaraan updated successfully.'
        ];
        header("Location: kendaraan.php");
        exit();
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Failed to update kendaraan. Please check the input data.'
        ];
        header("Location: kendaraan.php");
        exit();
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = deleteKendaraanData($id);
    if ($result) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Kendaraan deleted successfully.'
        ];
        header("Location: kendaraan.php");
        exit();
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Failed to delete kendaraan. Please try again later.'
        ];
        header("Location: kendaraan.php");
        exit();
    }
}


$kendaraanData = getKendaraanData();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Kendaraan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div> <!-- /.content-header -->

    <div class="container-fluid">
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
                        <h3 class="card-title">Daftar Kendaraan</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#addKendaraanModal">Tambah Data Kendaraan</button>
                            <a class="btn btn-danger" href="report/reportKendaraan.php">Cetak Kendaraan</a>
                        </div>
                        <table id="kendaraanTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Kendaraan</th>
                                    <th>Jenis</th>
                                    <th>BBM</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kendaraanData as $kendaraan) { ?>
                                    <tr>
                                        <td><?php echo $kendaraan['id']; ?></td>
                                        <td><?php echo $kendaraan['nama_kendaraan']; ?></td>
                                        <td><?php echo $kendaraan['jenis']; ?></td>
                                        <td><?php echo $kendaraan['bbm']; ?></td>
                                        <td><?php echo $kendaraan['jumlah']; ?></td>
                                        <td><?php echo $kendaraan['keterangan']; ?></td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-edit" data-id="<?php echo $kendaraan['id']; ?>"
                                               data-nama-kendaraan="<?php echo $kendaraan['nama_kendaraan']; ?>"
                                               data-jenis="<?php echo $kendaraan['jenis']; ?>"
                                               data-bbm="<?php echo $kendaraan['bbm']; ?>"
                                               data-jumlah="<?php echo $kendaraan['jumlah']; ?>"
                                               data-keterangan="<?php echo $kendaraan['keterangan'];?>">Edit</a>
                                            <a href="kendaraan.php?action=delete&id=<?php echo $kendaraan['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
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
</div>

<!-- Add Kendaraan Modal -->
<div class="modal fade" id="addKendaraanModal" tabindex="-1" role="dialog" aria-labelledby="addKendaraanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKendaraanModalLabel">Tambah Data Kendaraan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="?action=addKendaraan" method="post">
                <div class="modal-body">
                    <!-- Form fields for adding Kendaraan data -->
                    <div class="form-group">
                        <label for="nama_kendaraan">Nama Kendaraan</label>
                        <input type="text" class="form-control" id="nama_kendaraan" name="nama_kendaraan" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis</label>
                        <input type="text" class="form-control" id="jenis" name="jenis" required>
                    </div>
                    <div class="form-group">
                        <label for="bbm">BBM</label>
                        <select name="bbm" class="form-control" id="bbm">
                            <option value="">-- Pilih BBM --</option>
                            <option value="Pertalite">Pertalite</option>
                            <option value="Pertamax">Pertamax</option>
                            <option value="Pertamax turbo">Pertamax Turbo</option>
                            <option value="Pertamina dex">Pertamina Dex</option>
                            <option value="Solar">Solar</option>
                            <option value="Premium">Premium</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="addKendaraan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Kendaraan Modal -->
<div class="modal fade" id="editKendaraanModal" tabindex="-1" role="dialog" aria-labelledby="editKendaraanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKendaraanModalLabel">Edit Data Kendaraan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="?action=updateKendaraan" method="post" id="editKendaraanForm">
                <div class="modal-body">
                    <!-- Form fields for editing Kendaraan data -->
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_nama_kendaraan">Nama Kendaraan</label>
                        <input type="text" class="form-control" id="edit_nama_kendaraan" name="nama_kendaraan" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jenis">Jenis</label>
                        <input type="text" class="form-control" id="edit_jenis" name="jenis" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_bbm">BBM</label>
                        <select class="form-control" id="edit_bbm" name="bbm" required>
                            <option value="">Select BBM</option>
                            <option value="Pertalite">Pertalite</option>
                            <option value="Pertamax">Pertamax</option>
                            <option value="Pertamax turbo">Pertamax Turbo</option>
                            <option value="Pertamina dex">Pertamina Dex</option>
                            <option value="Solar">Solar</option>
                            <option value="Premium">Premium</option>
                            <!-- Add more options for different types of BBM -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="edit_jumlah" name="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_keterangan">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan" name="keterangan" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="updateKendaraan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once 'template/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#kendaraanTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf"]
        });

        // Menampilkan modal edit saat tombol "Edit" diklik
        $('#kendaraanTable').on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var namaKendaraan = $(this).data('nama-kendaraan');
            var jenis = $(this).data('jenis');
            var bbm = $(this).data('bbm');
            var jumlah = $(this).data('jumlah');
            var keterangan = $(this).data('keterangan');

            $('#edit_id').val(id);
            $('#edit_nama_kendaraan').val(namaKendaraan);
            $('#edit_jenis').val(jenis);
            $('#edit_bbm').val(bbm);
            $('#edit_jumlah').val(jumlah);
            $('#edit_keterangan').val(keterangan);

            $('#editKendaraanModal').modal('show');
        });

        // Mengirim data edit ke server saat formulir disubmit
        $('#editKendaraanForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function(response) {
                    alert('Data Kendaraan berhasil diupdate.');
                    $('#editKendaraanModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan saat mengupdate data Kendaraan.');
                }
            });
        });

            });
</script>
