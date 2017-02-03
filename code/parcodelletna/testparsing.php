<?php 
require('AlboParcoDellEtnaParserFactory.php');
$factory=new AlboParcoDellEtnaParserFactory();
$parser=$factory->createFromWebPage();
foreach ($parser as $e){
	$dateAsStr=$e->date->format('d/m/Y');
	$number=$e->number;
	echo "$dateAsStr $number\n";
	echo "$e->title\n";
	echo "$e->link\n\n";
}
?>