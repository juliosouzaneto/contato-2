<?php
// Campo que fez requisição
$campo = $_GET['campo'];
// Valor do campo que fez requisição
$valor = $_GET['valor'];
 
// Verificando o campo login
if ($campo == "login") {
 
	if ($valor == "") {
		echo "Preencha o campo com seu login";
	} elseif (strlen($valor) > 28) {
		echo "O login deve ter no máximo 28 caracteres";
	} elseif (strlen($valor) < 4) {
		echo "O login deve ter no minímo 4 caracteres";
	} elseif (!preg_match('/^[a-z\d_]{4,28}$/i', $valor)) {
		echo "O login deve conter somente letras e numeros.";
	}
 
}
 
// Verificando o campo email
if ($campo == "email") {
 
	        if(!preg_match
('/^[a-z0-9.-_+]+@[a-z0-9-_]+.([a-z0-9-_]+.)*?[a-z]+$/is', $valor)) {
		echo "Preencha com um email válido"; //
	}
 
}
 
// Verificando o campo CPF
if ($campo == "cpf") {
 
	 if (!preg_match('/^([0-9]){3}\.([0-9]){3}\.([0-9]){3}-([0-9]){2}+$/is', $valor)) {
		echo "Digite um CPF valido";
	}
 
}
// Verificando o campo cep
if ($campo == "cep") {

	 if (!preg_match('/^[0-9]{5}-[0-9]{3}+$/is', $valor)) {
		echo "Digite um cep valido";
	}
 
}
if ($campo == "inputRazaoSocial") {

	 if (!preg_match('/^[0-9]{5}-[0-9]{3}+$/is', $valor)) {
		echo "Digite um cep valido";
	}
 
}
if ($campo == "grande_gerador_razao_social") {

	 if (!preg_match('/^[0-9]{5}-[0-9]{3}+$/is', $valor)) {
		echo "Digite um cep valido";
	}
 
}
 else {
     echo "Nenhum Campo verificado";
    
}
 
// Acentuação
header("Content-Type: text/html; charset=ISO-8859-1",true);
?>