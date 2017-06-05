<?php
/**
 * Factory methods to get entries of the Albo of Scuola GB Vaccarini
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
require ('./AlboScuolaGBVaccariniCTRowParser.php');

class AlboScuolaGBVaccariniCTParserFactory implements AlboParserFactory {
	public $alboPageUri = 'https://web.spaggiari.eu/sdg/app/default/albo_pretorio.php?sede_codice=CTII0016';
	
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
		$tableElement=$page->getElementById("table-documenti");
		if ($tableElement==null)
			throw new Exception("Albo Table not found");
		return new TableParser($tableElement, new AlboScuolaGBVaccariniCTRowParser($this->alboPageUri));
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