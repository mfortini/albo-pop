<?php 
/**
 * A page to share feed items.
 * 
 * Copyright 2016 Cristiano Longo
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
require ('constants.php');
require ('../jCityGov/AlbojCityGovParserFactory.php');
require ('AlboGravinaDiCataniaEntryParser.php');

$factory=new AlbojCityGovParserFactory (ALBO_URL, SELECTION_FORM_URL, 
		new AlboGravinaDiCataniaEntryParser() );

$year=$_GET['year'];
$number=$_GET['number'];

if (!isset($year) || !isset($number))
	die("E' necessario specificare anno e numero di registro.");

$entryList = $factory->createByYearAndNumber($year, $number);
if (!$entryList->valid())
  die("Nessun elemento col numero anno registro $year e numero registro $number");
$entry=$entryList->current();
$date=$entry->data_inizio_pubblicazione->format(DATE_FORMAT);  
$title="Albo POP Comune di Gravina di Catania - Avviso $year / $number del $date";
$logo="http://albopop.it/images/logo.png";
$description='Tipologia:'.$entry->tipo_atto.','.$entry->sottotipo_atto
.'. Oggetto:'.$entry->oggetto;

$link=$entry->url;
$css="../RSS/sharer.css";
$supporter_name=null;
$news=null;

require("../RSS/sharer-template.php");
?>
