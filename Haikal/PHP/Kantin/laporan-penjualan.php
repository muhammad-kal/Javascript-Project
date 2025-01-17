<?php

$server = "localhost";
$user = "root";
$pw = "";
$database = "kantin";

$kon = mysqli_connect($server, $user, $pw, $database) or die($kon);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="scss/style.css" rel="stylesheet" />
    <title>Laporan Penjualan Kantin Al-Fath</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>

    <div class="card col-11 mx-auto mt-4" >
        <div class="card-header bg-info text-dark">
            Data
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-bordered" id="mauexport">
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
                    $total = mysqli_query($kon, "SELECT SUM(subtotal) as 'Total' FROM transaksi_item;") -> fetch_array();
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $data['transaction_id']; ?></td>
                            <td><?php echo $data['transaction_date']; ?></td>
                            <td><?php echo $data['product_name']; ?></td>
                            <td><?php echo $data['quantity']; ?></td>
                            <td>Rp. <?php echo number_format($data['subtotal'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-center fw-bolder">Total</td>
                        <td class=" fw-bolder">Rp. <?php echo $total[0];  ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer bg-info">
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#mauexport').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

</body>

</html>