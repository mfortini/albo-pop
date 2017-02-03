<?php
/**
 * Convert AlboParcoDellEtnaItem instances to RSSItem ones 
 * @author Cristiano Longo
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
require ('../phpalbogenerator/AlboToRSSItemConverter.php');
require ('../RSS/RSSFeedItem.php');
class AlboParcoDellEtnaItemConverter implements AlboToRSSItemConverter {
	/** 
	 *
	 * @param AlboUnitoEntry $alboTorinoItem        	
	 */
	function getRSSItem($entry) {
		$rssItem = new RSSFeedItem ();
		$dateAsStr=$entry->date->format('d/m/Y');
		$rssItem->title=$entry->title;
		$rssItem->description="Avviso $entry->numero del $dateAsStr : $entry->title";
		$rssItem->pubDate=$entry->date;
		$rssItem->link=$entry->link;
		$rssItem->guid=$entry->link;
		return $rssItem;
	}
}
?>