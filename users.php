<?php
ob_start();

require_once 'template/header.php';



// Add User
if (isset($_GET['action']) && $_GET['action'] == 'addUser') {
    if (
        isset($_POST['username']) &&
        isset($_POST['password']) &&
        isset($_POST['role']) && 
        isset($_POST['full_name'])
    ) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $full_name = $_POST['full_name'];
        $role = $_POST['role'];
        
        $result = addUser($username, $password, $role, $full_name);
        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'User added successfully.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Failed to add user. Username might already exist or there was an error with the input data.'
            ];
        }
        header("Location: users.php");
        exit();
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Failed to add user. Invalid input data.'
        ];
        header("Location: users.php");
        exit();
    }
}

// Update User
if (isset($_GET['action']) && $_GET['action'] == 'updateUser') {
    if(isset($_POST['edit_user_id'])) {
        $id = $_POST['edit_user_id'];
        $username = $_POST['edit_username'];
        $password = $_POST['edit_password'];
        $role = $_POST['edit_role'];
        $full_name = $_POST['edit_full_name'];

        $result = updateUser($id, $username, $password, $role, $full_name);
        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'User updated successfully.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Failed to update user. Username might already exist or there was an error with the input data.'
            ];
        }
        
        header("Location: users.php");
        exit();
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Failed to update user. Invalid input data.'
        ];
        header("Location: users.php");
        exit();
    }
}


if (isset($_GET['action']) && $_GET['action'] == 'deleteUser') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $result = deleteUser($id);
        if ($result) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'User deleted successfully.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Failed to delete user. Please try again later.'
            ];
        }
        header("Location: users.php");
        exit();
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Failed to delete user. Invalid user ID.'
        ];
        header("Location: users.php");
        exit();
    }
}



$getUser = getUserData();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Users</li>
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
        <h3 >Daftar Users</h3>
    </div>
    <div class="card-body">
    <div class="mb-3">
        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#addUserModal">[+]Tambah Data User</a>
        <a class="btn btn-danger" href="report/reportUsers.php">Cetak Data User</a>
    </div>
    <table id="usersTable" class="table table-bordered table-striped" data-source="users.php">
        <!-- Struktur tabel (header) -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <!-- Isi tabel -->
        <tbody>
            <?php
            // Mengambil data pengguna dari database dan mengisi tabel
            foreach ($getUser as $user) {
                echo '<tr>';
                echo '<td>' . $user['id'] . '</td>';
                echo '<td>' . $user['username'] . '</td>';
                echo '<td>'. $user['full_name'] . '</td>';
                echo '<td>'. $user['role'] . '</td>';
                echo '<td>';
                echo '<a class="btn btn-primary mr-2 btn-edit" href="#" data-role="' . $user['role'] . '" data-fullname="' . $user['full_name'] . '" data-id="' . $user['id'] . '" data-username="' . $user['username'] . '" data-toggle="modal" data-target="#editUserModal">Edit</a>';
                echo '<a class="btn btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')" href="users.php?action=deleteUser&id=' . $user['id'] . '" >Hapus</a>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

    
</div>

<!-- Modal Tambah Data Pengguna -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="users.php?action=addUser" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah Data Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        
                    </div>
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <!-- select option role -->
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="user">User</option>
                            <option value="operator">Operator</option>
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

<!-- Modal Edit Data Pengguna -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="users.php?action=updateUser" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit Data Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_user_id" name="edit_user_id">
                    <div class="form-group">
                        <label for="edit_username">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="edit_username" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_password">Password</label>
                        <input type="password" class="form-control" id="edit_password" name="edit_password">
                        <p style="color:red">*Kosongkan jika tidak ingin diupdate</p>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="edit_full_name" name="edit_full_name" required>
                    </div>
                    <!-- select option role -->
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="edit_role" id="edit_role" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="user">User</option>
                            <option value="operator">Operator</option>
                        </select>
                    </div>
                    <!-- Anda dapat menambahkan kolom lainnya sesuai kebutuhan -->
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
        $('#usersTable').DataTable()

        $("#usersTable").on("click", ".btn-edit", function() {
            var id = $(this).data('id');
            var username = $(this).data('username');
            var full_name = $(this).data('fullname');
            var role = $(this).data('role');
            console.log(role);
            $("#edit_user_id").val(id);
            $("#edit_username").val(username);
            $("#edit_full_name").val(full_name);
            $("#edit_role").val(role);
        });

        
    })
</script>
