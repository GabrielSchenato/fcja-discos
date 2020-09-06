<?php
header('Content-Type: text/html; charset=utf-8');
try {
    $db = new PDO('mysql:host=;dbname=', '', '');
    $db->query("SET NAMES 'utf8'");
    $db->query('SET character_set_connection=utf8');
    $db->query('SET character_set_client=utf8');
    $db->query('SET character_set_results=utf8');
} catch (PDOException $e) {
    print $e->getMessage();
}