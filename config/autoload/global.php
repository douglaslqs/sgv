<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
$host     = null;
$dbname   = null;
$user     = null;
$password = null;

//Verifica se recebeu o token e se é valido
//busca as credenciais do banco store e seta no adapter
$headersObj = apache_request_headers();
$headers    = (array)$headersObj;
$headers['X-Auth-Token'] = 123456;//fixado para teste
if (isset($headers['X-Auth-Token'])) {
    $mysqli = new mysqli('localhost', 'root', '', 'client');
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
    $select = "SELECT * FROM access_store
    WHERE active = 1 AND token = '".$headers['X-Auth-Token']."'";
    $returnQuery = $mysqli->query($select);
    if (count($returnQuery) === 1) {
        while ($dados = $returnQuery->fetch_array(MYSQLI_ASSOC)) {            
            $host     = $dados['host'];
            $dbname   = $dados['db_name'];
            $user     = $dados['db_user'];
            $password = $dados['db_password'];
        }
    }
    $mysqli->close();
} else {
    $host     = false;
    $dbname   = false;
    $user     = false;
    $password = false;
}
return [
    // ...
];
