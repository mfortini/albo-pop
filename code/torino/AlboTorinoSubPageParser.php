<?php 
/**
 * The notice board of the municipality of Turin si divided into sub-pages,
 * one per notice type. This parser retrieve the information from such a sub-page.
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
require('AlboTorinoEntry.php');

class AlboTorinoSubPageParser implements Iterator{

	private $category;
	private $rows;
	private $index;
	
	/**
	 * Parse the entries of the Albo from the rows of the table in the Albo Pretorio page.
	 *
	 * @param $url string url to retrieve the subpage
	 * @param $category category of the retrieved notices
	 */
	public function __construct($url, $category) {
		$page = new DOMDocument();
		$page->loadHTMLfile($url);
		$tables=$page->getElementsByTagName("table");
		if ($tables->length<1)
			throw new Exception("No table element found");
		if ($tables->length>1)
			throw new Exception("Multiple table elements found");
		$this->rows=$tables->item(0)->getElementsByTagName('tr');
		$this->index=1;
		$count=$this->rows->length;
	}

	//Iterator functions,  see http://php.net/manual/en/class.iterator.php
	
	public function current(){
		return $this->parseRow($this->rows->item($this->index));
	}
	
	
	public function key (){
		return $this->index-1;
	}
	
	public function next(){
		++$this->index;
	}
	
	public function rewind(){
		$this->index=1;
	}
	
	public function valid(){
		return $this->rows->length>1 && $this->index<$this->rows->length;
	}
	
	/**
	 * Parse a table row
	 * 
	 * @param unknown $row
	 */
	private function parseRow($row){
		$entry=new AlboTorinoEntry();
		$tds=$row->getElementsByTagName('td');
		$this->parseCodiceMeccanograficoCell($tds->item(0), $entry);
		$this->parseOggettoCell($tds->item(1), $entry);
		return $entry;
	}
	
	/**
	 * Get the firts child of an element which is an element itself
	 * 
	 * @param DOMElement $el
	 */
	private function getFirstChildElement($el){
		foreach($el->childNodes as $c)
			if ($c->nodeType==XML_ELEMENT_NODE)
				return $c;
		throw new Exception("No child element found.");
	}
	
	/**
	 * Parse the cell codice meccanografico
	 * 
	 * @param DOMElement $cell the table row cell
	 * #param AlboTorinoEntry $entry the entry which will receive the parsed content
	 */
	private function parseCodiceMeccanograficoCell($cell, $entry){
		//we assume that the solely child of the cell is an anchor node
		$aElements=$cell->getElementsByTagName('a');
		if ($aElements->length<1){
			$entry->parseErrors.="Link not found.";
			return;
		}
		if ($aElements->length>1){
			$entry->parseErrors.="Multiple links";
			return;
		}
		$aElement=$aElements->item(0);		
		$entry->link=$aElement->getAttribute('href');
		
		//and that it has a single child as well which contains the code as child text node
		$codice_meccanografico=$aElement->textContent;
		$codice_meccanografico_pieces=explode('-',$codice_meccanografico);
		$entry->year=trim($codice_meccanografico_pieces[0]);
		$entry->number=trim($codice_meccanografico_pieces[1]);
	} 
	
	/**
	 * Parse the cell oggetto
	 *
	 * @param DOMElement $cell the table row cell
	 * #param AlboTorinoEntry $entry the entry which will receive the parsed content
	 */
	private function parseOggettoCell($cell, $entry){
		for($i=0; $i<$cell->childNodes->length; $i++){
			$n=$cell->childNodes->item($i);
			if ($n->nodeType==XML_ELEMENT_NODE && !strcmp('span',$n->tagName))
				$entry->subject=$n->textContent;
			else if ($n->nodeType==XML_TEXT_NODE && 
					strpos($n->textContent,'In pubblicazione dal')){
				$dateStr=preg_replace('/.*In pubblicazione dal /','',$n->textContent);
				$startDateStr=substr($dateStr,0,10);
				$entry->startDate=DateTimeImmutable::createFromFormat('d/m/Y',$startDateStr);
				$entry->startDate->setTime(0,0);
				$endDateStr=substr($dateStr,14,10);
				$entry->endDate=DateTimeImmutable::createFromFormat('d/m/Y', $endDateStr);
				$entry->endDate->setTime(0,0);
			}
		}
		if ($entry->subject==null)
			$entry->parseErrors.="No subject specified.";		
		if ($entry->startDate==null)
			$entry->parseErrors.="No start date specified.";		
		if ($entry->endDate==null)
			$entry->parseErrors.="No end date specified.";		
	}	
}



//$a=new AlboTorinoSubPageParser("http://www.comune.torino.it/albopretorio/albogiunta.shtml", "tipe");
$a=new AlboTorinoSubPageParser("http://www.comune.torino.it/albopretorio/albodetermine.shtml", "tipe");
$i=0;
foreach($a as $e){
	echo "$i year ".($e->year)." number ".($e->number)."\n"; 
	echo "link ".($e->link)." \n";
	echo "subject ".$e->subject." \n";
	echo "start ".$e->startDate->format('d/m/Y')." end ".$e->endDate->format('d/m/Y')."\n";
	echo "errors ".$e->parseErrors."\n -------------------- \n";
	$i++;
}