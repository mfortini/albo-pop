<?php
/**
 * Factory methods to get entries of the Albo of the University of Catania
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
 *
 * @author Cristiano Longo
 */
require ('../phpparsing/AlboParserFactory.php');
require ('../phpparsing/TableParser.php');
require ('./AlboParcoDellEtnaRowParser.php');

class AlboParcoDellEtnaParserFactory implements AlboParserFactory {
	public $alboPageUri = 'http://albopretorio.parcoetna.it/';
	
	/**
	 * The landing page of the Official Albo
	 */
	public function getAlboPretorioLandingPage() {
		return $this->alboPageUri;
	}
	
	/**
	 * Read all the entries in the albo web page.
	 *
	 * @return the AlboUnictParser instance obtained by parsing the specified page.
	 */
	public function createFromWebPage() {
		$page = new DOMDocument();
		$page->loadHTMLfile($this->alboPageUri);
		$tableElement=$page->getElementById("ctl00_ContentPlaceHolder1_VisualizzaDocumenti1_Rep");
		if ($tableElement==null)
			throw new Exception("Albo Table not found");
		return new TableParser($tableElement, new AlboParcoDellEtnaRowParser($this->alboPageUri));
	}
	
	/**
	 * Create a parser with the solely entry with the specified year and number, if
	 * exists, empty otherwise.
	 */
	public function createByYearAndNumber($year, $number) {
		die("Not implemented");
	}
}
?>