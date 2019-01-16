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
//var_dump($headers);exit;
session_start();
//var_dump($_SESSION['user']->client);exit;
//$headers['X-Auth-Token'] = 123456;//fixado para teste
if (isset($headers['Authorization'])) {
    $headers['Authorization'] = str_replace(array('-',';'), array('',''), $headers['Authorization']);
    $mysqli = new mysqli('localhost', 'root', '', 'client');
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
    $select = "SELECT * FROM access_store
    WHERE active = 1 AND token = '".$headers['Authorization']."'";
    $returnQuery = $mysqli->query($select);
    if (is_object($returnQuery) && $returnQuery->num_rows === 1) {
        while ($dados = $returnQuery->fetch_array(MYSQLI_ASSOC)) {
            $host     = $dados['host'];
            $dbname   = $dados['db_name'];
            $user     = $dados['db_user'];
            $password = $dados['db_password'];
        }
    }
    $mysqli->close();
} else if(isset($_SESSION['user']->client)) {
    $mysqli = new mysqli('localhost', 'root', '', 'client');
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
    $select = "SELECT * FROM access_store
    WHERE active = 1 AND client = '".$_SESSION['user']->client."'";
    $returnQuery = $mysqli->query($select);
    if (is_object($returnQuery) && $returnQuery->num_rows === 1) {
        while ($dados = $returnQuery->fetch_array(MYSQLI_ASSOC)) {
            $host     = $dados['host'];
            $dbname   = $dados['db_name'];
            $user     = $dados['db_user'];
            $password = $dados['db_password'];
        }
    }
} else {
    $host     = false;
    $dbname   = false;
    $user     = false;
    $password = false;

}


use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;

return [
    'db' => [
        'adapters' => [
            'store-adapter' => [
                'driver' => 'Pdo',
                'dsn' => 'mysql:dbname='.$dbname.';host='.$host,
                'driver_options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ],
                'username' => $user,
                'password' => $password,
            ],
            'client-adapter' => [
                'driver' => 'Pdo',
                'dsn' => 'mysql:dbname=client;host=localhost',
                'driver_options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ],
                'username' => 'root',
                'password' => '',
            ]
        ],
    ],

    'service_manager' => [
        'factories' => [
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ],
    ],
    'session_config' => [
        // Session cookie will expire in 1 hour.
        'cookie_lifetime' => 60*60*1,
        // Session data will be stored on server maximum for 30 days.
        'gc_maxlifetime'     => 60*60*24*30,
    ],
    // Session manager configuration.
    'session_manager' => [
        // Session validators (used for security).
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ],
        'abstract_factories' => [
            \Zend\Db\Adapter\AdapterAbstractServiceFactory::class,
        ],
    ],
    // Session storage configuration.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
];
