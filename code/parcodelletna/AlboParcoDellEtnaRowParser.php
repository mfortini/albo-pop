<?php 
/**
 * A parser for Parco dell'Etna notice board rows
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
 *
 * @author Cristiano Longo
 *
 */
require ('../phpparsing/AlboRowParser.php');

class AlboParcoDellEtnaRowParser implements AlboRowParser{

	/**
	 * Convert a table row into an Albo-specific entry object.
	 *
	 * @param DOMElement $row
	 */
	function parseRow($row){
		return "Unimplemented";
	}
}

?>