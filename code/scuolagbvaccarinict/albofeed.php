<?php
/**
 * Generate the feed of Albo POP for Scuola GB Vaccarini Catania
 * (see https://web.spaggiari.eu/sdg/app/default/albo_pretorio.php?sede_codice=CTII0016)
 * 
 * Copyright 2017 Cristiano Longo
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
require ('../phpalbogenerator/AlboPopGenerator.php');
require ('AlboScuolaGBVaccariniCTParserFactory.php');
require ('../phpalbogenerator/AlboToRSSItemConverterIdentity.php');

$generator = new AlboPopGenerator ( new AlboScuolaGBVaccariniCTParserFactory (), new AlboToRSSItemConverterIdentity() );
$generator->outputFeed ( "Albo POP del Liceo Scientifico Gian Battista Vaccarini di Catania", "Versione POP dell'Albo Albo POP del Liceo Scientifico Gian Battista Vaccarini di Catania", "http://dev.opendatasicilia.it/albopop/scuolagbvaccarinict/albofeed.php" );
?>