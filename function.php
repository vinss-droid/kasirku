<?php
$conn = mysqli_connect("localhost", "root", "", "kasir");

function tambah($data)
{
  global $conn;

  $id_barang = $_POST["id_barang"];
  $nama_barang = htmlspecialchars($data["nama_barang"]);
  $harga_barang = htmlspecialchars($data["harga_barang"]);
  $quantity = htmlspecialchars($data["quantity"]);
  $subtotal = htmlspecialchars($data["subtotal"]);
  $tgl_input = htmlspecialchars($data["tgl_input"]);

  $query = "INSERT INTO keranjang VALUES (NULL, '$id_barang', '$nama_barang', '$harga_barang', '$quantity', '$subtotal', '$tgl_input', '', '', '')";
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function hapus($id)
{
  global $conn;
  mysqli_query($conn, "DELETE FROM keranjang WHERE id_cart = $id");
  return mysqli_affected_rows($conn);
}
