<?php
session_start();

//membuat koneksi database
$conn = mysqli_connect("localhost","root","","stockbarang");

//menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn,"Insert into stock (namabarang, deskripsi, stock) values('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index.php');
    } else {
        echo 'GAGAL TAMBAH BARANG';
        header('location:index.php');
    }
};

//menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn, "insert into masuk (idbarang, keterangan, qty) values ('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock ='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");

    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'GAGAL TAMBAH BARANG';
        header('location:masuk.php');
    }
};

//menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar = mysqli_query($conn, "insert into keluar (idbarang, penerima, qty) values ('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock ='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");

    if($addtokeluar&&$updatestockmasuk){
        header('location:keluar.php');
    } else {
        echo 'GAGAL TAMBAH BARANG';
        header('location:keluar.php');
    }
};

//update info barang
if(isset($_POST['updatebarang'])){
    $idb =  $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang = '$idb'");
    if($update){
        header('location:index.php');
    }else {
        echo 'GAGAL UPDATE';
        header('location:index.php');
    }
}

//menghapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    }else {
        echo 'GAGAL HAPUS';
        header('location:index.php');
    }
}

//mengubah (update) data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb =  $_POST['idb'];
    $idm =  $_POST['idm'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrng){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock ='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty ='$qty' where idmasuk='$idm'");
            if($kuranginstocknya&&$updatenya){
                header('location:masuk.php');
            }else {
                echo 'GAGAL HAPUS';
                header('location:masuk.php');
                }
            } else {
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskrg - $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock ='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty ='$qty' where idmasuk='$idm'");
            if($kuranginstocknya&&$updatenya){
                header('location:masuk.php');
            }else {
                echo 'GAGAL EDIT';
                header('location:masuk.php');
                }
            }
}

//menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
        header('location:masuk.php');
    }else {
        echo 'GAGAL HAPUS';
        header('location:index.php');
    }
}

//mengubah (update) data barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb =  $_POST['idb'];
    $idk =  $_POST['idk'];
    $namabarang = $_POST['namabarang'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrng){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock ='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty ='$qty' penerima='$penerima' where idkeluar='$idk'");
            if($kuranginstocknya&&$updatenya){
                header('location:keluar.php');
            }else {
                echo 'GAGAL HAPUS';
                header('location:keluar.php');
                }
            } else {
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskrg + $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock ='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty ='$qty', penerima='$penerima' where idkeluar='$idk'");
            if($kuranginstocknya&&$updatenya){
                header('location:keluar.php');
            }else {
                echo 'GAGAL EDIT';
                header('location:keluar.php');
                }
            }
}

//menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok+$qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata){
        header('location:keluar.php');
    }else {
        echo 'GAGAL HAPUS';
        header('location:keluar.php');
    }
}



?>