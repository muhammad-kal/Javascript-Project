<?php

$server = "localhost";
$user = "root";
$pw = "";
$database = "kantin";

$kon = mysqli_connect($server, $user, $pw, $database) or die($kon);
$id_harga_produk = "";
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == "pesan") {
        $id_produk = $_GET['id'];
        $harga_produk_query = mysqli_query($kon, "SELECT (harga) FROM produk  WHERE id = $id_produk;");
        while ($harga_produk = mysqli_fetch_array($harga_produk_query)) {
            $id_harga_produk = $harga_produk[0];
        }
        $transaksi = mysqli_query($kon, "INSERT INTO transaksi (id, tanggal) VALUE  (NULL, curdate())");
        $id_transaksi = mysqli_insert_id($kon);
        $transaksi_item = mysqli_query($kon, "INSERT INTO `transaksi_item` (`id`, `id_transaksi`, `id_produk`, `kuantitas`, `subtotal`) VALUES (NULL, $id_transaksi, $id_produk, '1', $id_harga_produk);");

        if ($transaksi_item) {
            echo "<script>
            alert('Pesanan sudah tercatat!');
            document.location = 'index.php';
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="scss/style.css" rel="stylesheet" />
    <title>SnackSpot Al-Fath</title>
</head>

<body>
    <div class="container mt-5">
        <a href="" class="btn btn-primary" data-bs-target="#modalinput" data-bs-toggle="modal">
            Tambah Item
        </a>
        <?php
        if (isset($_GET['mode']) == 'list') {
        ?>
            <a href="index.php?" class="btn btn-warning">
                Kembali
            </a>

        <?php
        } else {
        ?>
            <a href="index.php?mode=list" class="btn btn-success">
                List Item
            </a>

        <?php
        }
        ?>
        <button href="" value="Export Excel" type="button" class="btn btn-success" onclick="window.open('laporan-penjualan.php');">
            Export EXCEL
        </button>
    </div>
    <div class="container mt-5">
        <?php
        if (isset($_GET['mode']) == 'list') {
        ?>
            <table class="table table-hover table-striped">
                <thead>
                    <th>No.</th>
                    <th>ID Produk</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Tersedia?</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $list = mysqli_query($kon, "SELECT * FROM produk ORDER BY id DESC");
                    while ($data = mysqli_fetch_array($list)) {
                    ?>
                        <tr>
                            <td><?= $no++ . "." ?></td>
                            <td>00<?= $data['id'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><img src="Gambar/<?= $data['gambar'] ?>" width="50px"></td>
                            <td><?php $tersedia = $data['is_tersedia'];
                                echo ($tersedia ? 'Ya' : 'Tidak'); ?></td>
                            <form method="post">
                                <?php
                                if (isset($_GET['id'])) {
                                ?>
                                    <td><a class="btn btn-<?php echo ($_GET['id'] == $data['id']) ? "primary" : "success"; ?>" href="index.php?mode=<?= $_GET['mode'] ?>&aksi=edit&id=<?= $data['id'] ?>" name="bedit" <?php echo (($_GET['id'] == $data['id']) ? ' data-bs-target="#modaledit" data-bs-toggle="modal"' : ''); ?>><?php echo ($_GET['id'] == $data['id']) ? "Tekan Lagi untuk Edit" : "Edit"; ?></a></td>
                                <?php
                                } else {
                                ?>
                                    <td><a class="btn btn-success" href="index.php?mode=<?= $_GET['mode'] ?>&aksi=edit&id=<?= $data['id'] ?>">Edit</a></td>
                                <?php
                                }
                                ?>
                            </form>
                        </tr>
                        <?php
                        ?>
                    <?php }
                    ?>


                    <?php
                    if (isset($_GET['aksi']) == 'edit') {

                        // Edit Modal
                        $edit = mysqli_query($kon, "SELECT * FROM produk WHERE id = '$_GET[id]'");
                        $edit_tampil = mysqli_fetch_array($edit);
                        $edit_nama = $edit_tampil['nama'];
                        $edit_harga = $edit_tampil['harga'];
                        $edit_gambar = $edit_tampil['gambar'];
                        $edit_is_tersedia = $edit_tampil['is_tersedia'];
                    ?>
                        <div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Menu</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="enama" class="form-label">
                                                    Nama Item
                                                </label>
                                                <input type="text" name="enama" id="enama" class="form-control" placeholder="Masukkan Nama Item" value="<?= $edit_nama ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="eharga" class="form-label">
                                                    Harga Item
                                                </label>
                                                <div class="d-flex">
                                                    <p class="form-label" style="margin-right: 5%;">Rp. </p>
                                                    <input type="number" name="eharga" id="eharga" class="form-control" placeholder="Masukkan Harga Item" value="<?= $edit_harga ?>">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Gambar Item</label>
                                                <img src="Gambar/<?= $edit_gambar ?>" width="100px" />
                                                <input type="file" name="egambar" id="egambar" class="form-control mt-1" value="<?= $edit_gambar ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">
                                                    Apakah Tersedia?
                                                </label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="etersedia" name="etersedia" value="1" <?php echo ($edit_is_tersedia ? "checked" : "") ?>>
                                                    <label class="form-check-label text-muted" for="etersedia">*Centang jika tersedia</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="reset" class="btn btn-warning" name="ereset">Reset</button>
                                                <button type="submit" class="btn btn-danger" name="ehapus" onclick="return confirm('Apakah yakin ingin menghapus data?');">Hapus</button>
                                                <button type="submit" class="btn btn-primary" name="iedit">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if (isset($_POST['iedit'])) {
                                $edit_aksi = mysqli_query($kon, "SELECT * FROM produk WHERE id = '$_GET[id]'");
                                $edit_tampil = mysqli_fetch_array($edit_aksi);
                                $input_nama = $_POST['enama'];
                                $input_harga = $_POST['eharga'];
                                $gambar = $_FILES['egambar']['name'];
                                @$tmp_gambar = $_FILES['egambar']['tmp_name'];

                                $timestamp = time();
                                $new_name = $timestamp . $gambar;
                                if ($gambar == NULL) {
                                    $new_name = $edit_tampil['gambar'];
                                }

                                $qry = mysqli_query($kon, "UPDATE produk SET nama='$input_nama', harga = '$input_harga', gambar='$new_name', is_tersedia = '$_POST[etersedia]' WHERE id = '$_GET[id]';");

                                $lokasi_gambar = 'Gambar/' . $new_name;
                                move_uploaded_file($tmp_gambar, $lokasi_gambar);

                                echo "<script>alert('Item Berhasil di-Update!'); document.location = 'index.php'</script>";
                            } elseif (isset($_POST['ehapus'])) {
                                $data_hapus = mysqli_query($kon, "SELECT * FROM produk WHERE id = '$_GET[id]'")->fetch_assoc();
                                $lokasi = 'Gambar/' . $data_hapus['gambar'];

                                unlink($lokasi);
                                $hapus_aksi = mysqli_query($kon, "DELETE FROM produk WHERE id = '$_GET[id]';");
                                if ($hapus_aksi) {
                                    echo "
                                        <script>alert('Data berhasil dihapus!); document.location = index.php'</script>
                                    ";
                                }
                            }
                            ?>
                        <?php
                    }
                        ?>

                        </div>

                </tbody>
            </table> <?php
                    }
                        ?>
    </div>
    <div class="container col-md-5 ">
        <form method="POST">
            <div class="input-group mb-3">
                <input type="text " class="form-control" placeholder="Masukkan Nama Item" value="<?= @$_POST['icari'] ?>" name="icari">
                <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
                <button type="reset" class="btn btn-warning" name="breset">Reset</button>
            </div>
        </form>
    </div>
    <div class="container mt-5 d-flex flex-wrap justify-content-center">

        <?php
        if (isset($_POST['bcari'])) {
            $keyword = $_POST['icari'];
            $tampil_query = "SELECT * FROM produk WHERE is_tersedia = TRUE AND nama LIKE '%$keyword%' OR harga LIKE '%$keyword%' OR id LIKE '%$keyword%' ORDER BY id DESC;";
        } else {
            $tampil_query = "SELECT * FROM produk WHERE is_tersedia = TRUE ORDER BY id DESC;";
        }
        $tampil = mysqli_query($kon, $tampil_query);
        while ($data = mysqli_fetch_array($tampil)) { ?>


            <div class="card col-4 m-4 col-md-4 col-lg-2" style="">
                <img class="card-img-top " src="Gambar/<?= $data['gambar']; ?>" alt="Card image cap" style="width:100%">
                <div class="card-body mx-auto row ">
                    <h5 class="card-title fw-bold text-center"><?= $data['nama']; ?></h5>
                    <h6 class="card-text text-center " style="">Rp. <?= $data['harga']; ?></h6>
                    <a href="index.php?aksi=pesan&id=<?= $data['id']; ?>" name="tpesan" class="btn btn-primary text-center col-12 py-3" style="" onclick="return confirm('Tambahakan pesanan?')">Pesan!</a>
                </div>
            </div>


        <?php
        }

        ?>



    </div>

    <div class="card col-11 mx-auto mt-4">
        <div class="card-header bg-info text-dark">
            Data
        </div>
        <div class="card-body">
            <div class="col-md-6 mx-auto">
                <!-- <form method="POST">
                    <div class="input-group mb-3">
                        <input type="text " class="form-control" placeholder="Masukkan Nama Barang" value="<?= @$_POST['icari'] ?>" name="icari">
                        <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
                        <button class="btn btn-danger" name="breset" type="reset">Reset</button>
                    </div>
                </form> -->
            </div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor = 1;
                    $q = "SELECT 
                    t.id AS transaction_id,
                    t.tanggal AS transaction_date,
                    p.nama AS product_name,
                    ti.kuantitas AS quantity,
                    ti.subtotal AS subtotal
                    FROM 
                        transaksi t
                    JOIN 
                        transaksi_item ti ON t.id = ti.id_transaksi
                    JOIN 
                        produk p ON ti.id_produk = p.id
                    ORDER BY 
                        t.tanggal DESC, t.id DESC;";


                    $result = mysqli_query($kon, $q);
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?= $data['transaction_id']; ?></td>
                            <td><?= $data['transaction_date']; ?></td>
                            <td><?= $data['product_name']; ?></td>
                            <td><?= $data['quantity']; ?></td>
                            <td>Rp. <?= number_format($data['subtotal'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-info">
        </div>
    </div>

    <!-- Modal Input-->
    <div class="modal fade" id="modalinput" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Menu Baru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="inama" class="form-label">
                                Nama Item
                            </label>
                            <input type="text" name="inama" id="inama" class="form-control" placeholder="Masukkan Nama Item">
                        </div>
                        <div class="mb-3">
                            <label for="iharga" class="form-label">
                                Harga Item
                            </label>
                            <div class="d-flex">
                                <p class="form-label" style="margin-right: 5%;">Rp. </p>
                                <input type="number" name="iharga" id="iharga" class="form-control" placeholder="Masukkan Harga Item">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Gambar Item</label>
                            <input type="file" name="igambar" id="igambar" class="form-control mt-1">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">
                                Apakah Tersedia?
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="itersedia" name="itersedia" value="1" checked>
                                <label class="form-check-label text-muted" for="itersedia">*Centang jika tersedia</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="reset" class="btn btn-warning" name="ireset">Reset</button>
                            <button type="submit" class="btn btn-primary" name="isimpan">Simpan Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['isimpan'])) {
        $input_nama = $_POST['inama'];
        $input_harga = $_POST['iharga'];

        $gambar = $_FILES['igambar']['name'];
        @$tmp_gambar = $_FILES['igambar']['tmp_name'];

        $timestamp = time();
        $new_name = $timestamp . $gambar;

        $qry = mysqli_query($kon, "INSERT INTO produk VALUES (NULL, '$input_nama', '$input_harga', '$new_name', '$_POST[itersedia]');");

        $lokasi_gambar = 'Gambar/' . $new_name;
        move_uploaded_file($tmp_gambar, $lokasi_gambar);

        echo "<script>alert('Item berhasil ditambahkan!'); document.location = 'index.php'</script>";
    }
    ?>


    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>