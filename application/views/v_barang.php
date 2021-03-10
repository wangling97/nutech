<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Nutech Integrasi</title>

    <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>" sizes="32x32" />
    <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>" sizes="192x192" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Stylesheet -->
    <style>
        header.container,
        section.container {
            border-radius: 10px;
        }

        .shadow {
            box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);
            -webkit-box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);
        }

        .btn-primary,
        .btn-primary:hover,
        .btn-primary:focus {
            color: white;
            background-color: #fe9900;
            border-color: #fe9900;
        }

        .table-primary {
            --bs-table-bg: #fe9900;
            --bs-table-striped-bg: #fe9900;
            --bs-table-striped-color: white;
            --bs-table-active-bg: #fe9900;
            --bs-table-active-color: white;
            --bs-table-hover-bg: #fe9900;
            --bs-table-hover-color: white;
            color: white;
            border-color: #fe9900;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #fe9900;
            border-color: #fe9900;
        }
    </style>
</head>

<body>

    <div class="container">
        <?php echo $this->session->flashdata('message'); ?>

        <?php if (form_error('nama_barang') || form_error('harga_beli') || form_error('harga_jual') || form_error('stok_barang')) {
            echo '<div class="alert alert-warning alert-dismissible fade show mt-5 mb-3" role="alert"><strong>Warning</strong> Input yang Anda masukkan belum sesuai.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        } ?>
    </div>

    <header class="container shadow p-3 mt-5">
        <div class="container">
            <div class="d-flex bd-highlight">
                <div class="bd-highlight align-middle">
                    <h4 class="m-0" style="line-height: 40px;">DATA BARANG</h4>
                </div>
                <div class="ms-auto bd-highlight">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        Tambah Barang
                    </button>
                </div>
            </div>
        </div>
    </header>

    <section class="container shadow p-3 mt-5">
        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Harga Beli</th>
                        <th scope="col">Harga Jual</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Foto Barang</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($barang as $key => $value) : ?>

                        <tr>
                            <th scope="row"><?php echo $key + 1; ?></th>
                            <td><?php echo $value['nama_barang']; ?></td>
                            <td><?php echo "Rp." . number_format($value['harga_beli']); ?></td>
                            <td><?php echo "Rp." . number_format($value['harga_jual']); ?></td>
                            <td><?php echo $value['stok']; ?></td>
                            <td><img src="<?php echo base_url('assets/img/barang/' . $value['foto_barang']); ?>" alt="Foto Barang" width="100"></td>
                            <td>
                                <button class="btn btn-sm btn-success btn-edit w-100 my-1" data-bs-toggle="modal" data-bs-target="#editModal" data-idbarang="<?php echo $value['id_barang']; ?>">
                                    Edit
                                </button>
                                <form action="<?php echo base_url('barang/hapus') ?>" method="post">
                                    <input type="hidden" name="id_barang" value="<?php echo $value['id_barang']; ?>">
                                    <button class="btn btn-sm w-100 my-1 btn-danger" onclick="return confirm('Apakah Anda Yakin?')" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </section>

    <!-- Tambah Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo base_url(''); ?>" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="nama_barang" class="form-label"><span class="text-danger">*</span>Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo set_value('nama_barang'); ?>" required>
                                <?php echo form_error('nama_barang', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="harga_beli" class="form-label"><span class="text-danger">*</span>Harga Beli</label>
                                <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="<?php echo set_value('harga_beli'); ?>" min="0" required>
                                <?php echo form_error('harga_beli', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="harga_jual" class="form-label"><span class="text-danger">*</span>Harga Jual</label>
                                <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="<?php echo set_value('harga_jual'); ?>" min="0" required>
                                <?php echo form_error('harga_jual', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="col-md-12">
                                <label for="stok_barang" class="form-label"><span class="text-danger">*</span>Stok Barang</label>
                                <input type="number" class="form-control" id="stok_barang" name="stok_barang" value="<?php echo set_value('stok_barang'); ?>" min="0" required>
                                <?php echo form_error('stok_barang', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="col-md-12">
                                <label for="foto_barang" class="form-label"><span class="text-danger">*</span>Foto Barang</label>
                                <input type="file" class="form-control" id="foto_barang" name="foto_barang" required>
                                <?php echo form_error('foto_barang', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo base_url('barang/edit'); ?>" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row g-3">
                            <input type="hidden" name="edit_id_barang" id="edit_id_barang">
                            <div class="col-md-12">
                                <label for="edit_nama_barang" class="form-label"><span class="text-danger">*</span>Nama Barang</label>
                                <input type="text" class="form-control" id="edit_nama_barang" name="edit_nama_barang" required>
                                <?php echo form_error('edit_nama_barang', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_harga_beli" class="form-label"><span class="text-danger">*</span>Harga Beli</label>
                                <input type="number" class="form-control" id="edit_harga_beli" name="edit_harga_beli" min="0" required>
                                <?php echo form_error('edit_harga_beli', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_harga_jual" class="form-label"><span class="text-danger">*</span>Harga Jual</label>
                                <input type="number" class="form-control" id="edit_harga_jual" name="edit_harga_jual" min="0" required>
                                <?php echo form_error('edit_harga_jual', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="col-md-12">
                                <label for="edit_stok_barang" class="form-label"><span class="text-danger">*</span>Stok Barang</label>
                                <input type="number" class="form-control" id="edit_stok_barang" name="edit_stok_barang" min="0" required>
                                <?php echo form_error('edit_stok_barang', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="col-md-12">
                                <label for="edit_foto_barang" class="form-label"><span class="text-danger">*</span>Foto Barang</label>
                                <input type="file" class="form-control" id="edit_foto_barang" name="edit_foto_barang" required>
                                <?php echo form_error('edit_foto_barang', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <!-- Script -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            $(document).on('click', '.btn-edit', function() {
                var id_barang = $(this).data('idbarang');
                $.ajax({
                    url: '<?php echo base_url('barang/fetch'); ?>',
                    type: 'POST',
                    data: {
                        id_barang: id_barang
                    },
                    success: function(data) {
                        var json = $.parseJSON(data);
                        $('#edit_id_barang').val(json.id_barang);
                        $('#edit_nama_barang').val(json.nama_barang);
                        $('#edit_harga_beli').val(json.harga_beli);
                        $('#edit_harga_jual').val(json.harga_jual);
                        $('#edit_stok_barang').val(json.stok);
                    }
                });
            });
        });
    </script>
</body>

</html>