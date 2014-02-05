<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var_dump($_POST);
$id = $_POST['id'];
$situacao = $_POST['situacao'];
$situacao = $_POST['situacao'];


//if ($campo == 0) {
//    echo '<option value="0"> Selecione </option>';
//} else {
//
    $conn = mysql_connect("192.168.1.212", "limpurb", "!l11mpuurb!");
    mysql_select_db("limpurb");

    $sql = "UPDATE grande_gerador SET grande_gerador_situacao = '$situacao' WHERE grande_gerador_id = '$id'";
    $qr = mysql_query($sql) or die(mysql_error());
    

//    if (mysql_num_rows($qr) == 0) {
//        echo '<option value="0"> Não Existem Resíduos Cadastrados </option>';
//        //echo '0';
//    } else {
//        echo '<option value="0"> Selecione </option>';
//        while ($ln = mysql_fetch_assoc($qr)) {
//            echo '<option value="' . $ln["residuo_id"] . '"> ' . utf8_encode($ln["residuo_descricao"]) . ' </option>';
//        }
//    }

    mysql_close($conn);
