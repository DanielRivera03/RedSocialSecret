<?php
session_start();
$_SESSION['id_usuario'] = 1;
$_POST = array(
    'cancion' => 'Choosin Texas',
    'artista' => 'Ella Langley',
    'audio_url' => 'https://audio-ssl.itunes.apple.com/itunes-assets/AudioPreview116/v4/b8/ab/af/b8abafa9-052a-9cc9-5b7c-3b0222f67645/mzaf_3681408892606553880.plus.aac.p.m4a',
    'nota' => 'lorem',
    'start_time' => 0,
    'end_time' => 30
);
$_GET['accion'] = 'publicar';
require('cNotasMusica.php');
