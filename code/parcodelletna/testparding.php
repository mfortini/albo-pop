<?php 
require('AlboParcoDellEtnaParserFactory.php');
$factory=new AlboParcoDellEtnaParserFactory();
$parser=$factory->createFromWebPage();
foreach ($parser as $e){
	echo "$e \n";
}
?>