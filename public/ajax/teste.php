<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//var_dump($_POST);
$id = $_POST['id'];
$situacao = $_POST['situacao'];





$conn = mysql_connect("192.168.1.212", "limpurb", "!l11mpuurb!");
mysql_select_db("limpurb");



$sql = "UPDATE grande_gerador SET grande_gerador_situacao = '$situacao' WHERE grande_gerador_id = '$id'";
$qr = mysql_query($sql) or die(mysql_error());



mysql_close($conn);


var_dump($_POST);
