<?php 
/**
 * This script produce the rss feed from the web page of the albo of the municipality of
 * Gravina di Catania.
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
require ('../phpalbogenerator/AlboPopGenerator.php');
require ('../jCityGov/AlbojCityGovParserFactory.php');
//require ('../jCityGov/AlbojCityGovItemConverter.php');
require ('AlboGravinaDiCataniaItemConverter.php');
require('AlboGravinaDiCataniaEntryParser.php');

//$itemConverter=new AlbojCityGovItemConverter ("http://dev.opendatasicilia.it/albopop/gravinadicatania/sharer.php");
$itemConverter=new AlboGravinaDiCataniaItemConverter();
$generator = new AlboPopGenerator ( new AlbojCityGovParserFactory (ALBO_URL, SELECTION_FORM_URL, new AlboGravinaDiCataniaEntryParser()), 
		$itemConverter );
$generator->outputFeed ("Albo POP del Comune di Gravina di Catania", "Versione POP dell'Albo Pretorio del Comune di Gravina di Catania", 
		"http://dev.opendatasicilia.it/albopop/gravinadicatania/albofeed.php");
?>