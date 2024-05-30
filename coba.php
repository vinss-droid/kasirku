<!DOCTYPE html>

<html lang="en">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>kodingbuton.com</title>

</head>

<body bgcolor="#33CCCC">

  <h2>
    <center>
      <font color="#FFFFFF"> Tutorial Input Field Hitung Otomatis Pada PHP</font>
    </center>
  </h2>

  <h4>
    <center>
      <font color="#FFFFFF"> kodingbuton.com</font>
    </center>
  </h4><br>

  <form name="autoSumForm">

    <table bgcolor="#F09" align="center">

      <tr>

        <td><b>Harga Barang</b> </td>

        <td><input type='text' name='harga' onFocus="startCalc();" onBlur="stopCalc();" /></td>

      </tr>

      <tr>

        <td><b>Jumlah</b> </td>

        <td><input type='text' name='jumlah' onFocus="startCalc();" onBlur="stopCalc();" /></td>

      </tr>

      <tr>

        <td><b>Potongan Harga</b> </td>

        <td><input type='text' name="diskon" onFocus="startCalc();" onBlur="stopCalc();" /></td>

      </tr>

      <tr>

        <td><b>Total Bayar</b> </td>

        <td><input type="text" name="total" value="0" readonly> </td>

      </tr>

    </table>

  </form>

  <script>
    function startCalc() {
      interval = setInterval("calc()", 1);
    }

    function calc() {
      one = document.autoSumForm.harga.value;
      two = document.autoSumForm.jumlah.value;
      three = document.autoSumForm.diskon.value;
      document.autoSumForm.total.value = (one * 1) * (two * 1) - (three * 1);
    }

    function stopCalc() {
      clearInterval(interval);
    }
  </script>
</body>

</html>