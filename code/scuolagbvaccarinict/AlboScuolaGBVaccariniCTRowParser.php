<?php 
/**
 * A parser for Scuola GB Vaccarini notice board rows
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
 *
 * @author Cristiano Longo
 *
 */
require ('../phpparsing/AlboRowParser.php');
require ('../RSS/RSSFeedItem.php');
define('DATE_FORMAT','d/m/Y');

/**
 * @author cristianolongo
 *
 */
class AlboScuolaGBVaccariniCTRowParser implements AlboRowParser{

	private $baseUri;
	private $errCount;
	
	/**
	 * 
	 * @param String $baseUri base uri for links
	 */
	public function __construct($baseUri) {
		$this->baseUri=$baseUri;
	}
	
	/**
	 * Convert a table row into an RSS Feed Item
	 *
	 * @param DOMElement $row
	 */
	function parseRow($row){
		$cells=$row->getElementsByTagName('td');
		$noticeEl=$cells->item(1);
		$entry=new RSSFeedItem();
		$entry->description=$noticeEl->textContent;
		
		$spans=$noticeEl->getElementsByTagName('span');
		$entry->title=$spans->item(0)->textContent;
 		$entry->pubDate=DateTime::createFromFormat('d/m/Y',
 				$spans->item(2)->textContent);
 		
		$docDivList=$cells->item(3)->getElementsByTagName('div');
		if ($docDivList->length==0){
	 		$entry->link="http://error.com";
	 		$entry->guid="error".($this->errCount++);
		} else {
 			$docId=$docDivList->item(0)->getAttribute("id_doc");
 			$entry->link="https://web.spaggiari.eu/sdg/app/default/view_documento.php?a=akVIEW_FROM_ID&id_documento=$docId&sede_codice=CTII0016";
 			$entry->guid=$entry->link;
		}
		return $entry;
	}
	
	/**
	 * Perform some preprocessing on a table cell content in order
	 * to get it as plain text.
	 *
	 * @param DOMElement $td
	 */
	private function getElementPlainContent($td){
		return 	html_entity_decode(trim(
				str_replace("\t", '',
						str_replace("\r", '',
								str_replace("\n", ' ', strip_tags($td->nodeValue))))));
	}
	
}

?>