<?php
/**
 * Created by PhpStorm.
 * User: Ewerson
 * Date: 18/04/18
 * Time: 11:07
 */

require 'vendor/autoload.php';

use Ewersonfc\BBboleto\BancoDoBrasil;

$data = [
	'clientId' => 'eyJpZCI6IjgwNDNiNTMtZjQ5Mi00YyIsImNvZGlnb1B1YmxpY2Fkb3IiOjEwOSwiY29kaWdvU29mdHdhcmUiOjEsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxfQ',
	'clientSecret' => 'eyJpZCI6IjBjZDFlMGQtN2UyNC00MGQyLWI0YSIsImNvZGlnb1B1YmxpY2Fkb3IiOjEwOSwiY29kaWdvU29mdHdhcmUiOjEsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MX0'
];


$bancoDoBrasil = new BancoDoBrasil($data);

