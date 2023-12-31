<?php 
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Dotenv\Dotenv;
use Model\ActiveRecord;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';



ActiveRecord::setDB($db);