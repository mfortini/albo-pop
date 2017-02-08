<?php 
/**
 * Basic implementation for Albos consisting of rows in a table assuming that:
 * 
 * - there is just one table element in the web page
 * - this element contains an header
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
 *
 * @author Cristiano Longo
 */
require ('TableParser.php');

class AlboTableParser extends TableParser{
	private $rowParser;
	private $rows;
	private $index;
	
	
	/**
	 * Retrieve elements from the given page according to the specified row-parser.
	 * 
	 * @param DOMDocument $htmlPage
	 * @param AlboRowParser $rowParser
	 */
	public function __construct($htmlPage, $rowParser){
		parent::__construct(AlboTableParser::getTableElement($htmlPage), $rowParser);
	}
	
	/**
	 * Extract the table element from a DomDocument of a web page, assuming that
	 * there is one and only one element of type table in the web page
	 */
	public static function getTableElement($htmlPage){
		$tables=$htmlPage->getElementsByTagName("table");
		if ($tables->length<1){
			$this->rows=new DOMNodeList();
			$this->index=-1;
		}
		else if ($tables->length>1)
			throw new Exception("Multiple table elements found");
		else
			return $tables->item(0);	
	}	
}
?>