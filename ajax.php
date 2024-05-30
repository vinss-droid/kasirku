<?php
include "config.php";
$barang = mysqli_fetch_array(mysqli_query($config, "select * from barang where id_barang  ='$_GET[id_barang]'"));
$data_barang = array(
  'nama_barang'      =>  $barang['nama_barang'],
  'harga_barang'     =>  $barang['harga_barang'],
);
echo json_encode($data_barang);