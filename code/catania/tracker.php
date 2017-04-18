<?php
/**
 * Print all the entries (just the reference numbers) in the Municipality of Catania
 * notice board, aside a timestamp. We will use it to track the permamence of notices on
 * albo. The file has the following format:
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
 
require("AlboComuneCTParser.php");
$parser = AlboComuneCTParser::createByYear();
$currentTime=time();
foreach($parser as $r)
	echo "$currentTime\t$r->numero\t$r->anno\n";
?> 
