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
require ('./AlboParcoDellEtnaEntry.php');
define('DATE_FORMAT','d/m/Y');

/**
 * @author cristianolongo
 *
 */
class AlboParcoDellEtnaRowParser implements AlboRowParser{

	private $baseUri;
	
	/**
	 * 
	 * @param String $baseUri base uri for links
	 */
	public function __construct($baseUri) {
		$this->baseUri=$baseUri;
	}
	
	/**
	 * Convert a table row into an Albo-specific entry object.
	 *
	 * @param DOMElement $row
	 */
	function parseRow($row){
		$cells=$row->getElementsByTagName("td");
		$entry=new AlboParcoDellEtnaEntry();
		$entry->date=DateTime::createFromFormat('d/m/Y',
				$cells[0]->textContent);
		$entry->number=$cells[1]->textContent;
		$anchor=$cells[2]->getElementsByTagName('a')->item(0);
		$entry->title=$anchor->textContent;
		$entry->link=$this->baseUri.$anchor->getAttribute('href');
		return $entry;
	}
}

?>