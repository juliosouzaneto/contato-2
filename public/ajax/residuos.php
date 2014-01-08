<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$campo = $_POST['campo'];
$tipo = $_POST['tipo'];

if ($campo == 0) {
    echo '<option value="0"> Selecione </option>';
} else {



    $conn = mysql_connect("localhost", "root", "root");
    mysql_select_db("SG_COL_LIXO");



    $sql = "select * from residuo where tipo_residuo_fk = '$campo'";
    $qr = mysql_query($sql) or die(mysql_error());

    if (mysql_num_rows($qr) == 0) {
        echo '<option value="0"> Não Existem Resíduos Cadastrados </option>';
        //echo '0';
    } else {
        echo '<option value="0"> Selecione </option>';
        while ($ln = mysql_fetch_assoc($qr)) {
            echo '<option value="' . $ln["residuo_id"] . '"> ' . utf8_encode($ln["residuo_descricao"]) . ' </option>';
        }
    }

    mysql_close($conn);
}