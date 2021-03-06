#!/bin/bash

#### Requisiti ####

# - scrape, Extract HTML elements using an XPath query or CSS3 selector
# https://github.com/jeroenjanssens/data-science-at-the-command-line/blob/master/tools/scrape
#
# - xml2json, Convert XML to JSON Xml2Json
# https://github.com/parmentf/xml2json
#
# - jq, Process JSON
# https://stedolan.github.io/jq/
#
# csvkit, csvkit is a suite of utilities for converting to and working with CSV
# http://csvkit.readthedocs.org/en/0.9.1/


# imposto una cartella di lavoro
cartella="/var/albopop/bondeno"

# imposto la cartella di output esposta sul web
output="/var/www/albopop/bondeno"

#### Download, clean e mere dei dati ####


curl -s -A "Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5" "http://sac2.halleysac.it/c038003/mc/mc_p_ricerca.php?multiente=c038003&pag=0"  | scrape -be  '//table[@id="table-albo-pretorio"]/tbody/tr' | xml2json | sed 's/\\n\\t   //g' | sed 's/    //g' | jq '[.html.body.tr[] | {pubDate:.td[4]["#text"],title:.td[2].a.span["#text"],id:.["@data-id"]}]' | in2csv -f json |csvformat -T | csvformat -D "|" -t > $cartella/01.csv
curl -s -A "Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5" "http://sac2.halleysac.it/c038003/mc/mc_p_ricerca.php?multiente=c038003&pag=1"  | scrape -be  '//table[@id="table-albo-pretorio"]/tbody/tr' | xml2json | sed 's/\\n\\t   //g' | sed 's/    //g' | jq '[.html.body.tr[] | {pubDate:.td[4]["#text"],title:.td[2].a.span["#text"],id:.["@data-id"]}]' | in2csv -f json |csvformat -T | csvformat -D "|" -t > $cartella/02.csv
curl -s -A "Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5" "http://sac2.halleysac.it/c038003/mc/mc_p_ricerca.php?multiente=c038003&pag=2"  | scrape -be  '//table[@id="table-albo-pretorio"]/tbody/tr' | xml2json | sed 's/\\n\\t   //g' | sed 's/    //g' | jq '[.html.body.tr[] | {pubDate:.td[4]["#text"],title:.td[2].a.span["#text"],id:.["@data-id"]}]' | in2csv -f json |csvformat -T | csvformat -D "|" -t > $cartella/03.csv


csvstack $cartella/01.csv $cartella/02.csv $cartella/03.csv -d "|" | csvformat -T | csvformat -D "|" -t > $cartella/input.csv

#### Costruisco il feed RSS ####

# variabili per la costruzione del feed RSS
nomeFeed="Albo Pretorio Comune di Bondeno"
descrizioneFeed="Il feed RSS dell'Albo Pretorio Comune di Bondeno"
PageSource="http://www.sito.it/feed_rss.xml"

intestazioneRSS="<rss version=\"2.0\"><channel><title>$nomeFeed</title><description>$descrizioneFeed</description><link>$PageSource</link>"

chiusuraRSS="</channel></rss>"
# variabili per la costruzione del feed RSS

#cancello file, in modo che l'output del feed sia riempito sempre a partire da file "vuoti"
rm $output/out.xml
rm $output/feed.xml

#rimuovo intestazione dal file csv
sed -e '1d' $cartella/input.csv > $cartella/input_nohead.csv

# ciclo per ogni riga del csv per creare il corpo del file RSS
INPUT="$cartella/input_nohead.csv"
OLDIFS=$IFS
IFS="|"
[ ! -f $INPUT ] && { echo "$INPUT file not found"; exit 99; }
while read pubDate title id
do

# riformatto la data in formato compatibile RSS, ovvero RFC 822, altrimenti il feed RSS non passa la validazione
OLD_IFS="$IFS"
IFS="/"
STR_ARRAY=( $pubDate )
IFS="$OLD_IFS"
anno=${STR_ARRAY[2]}
mese=${STR_ARRAY[1]}
giorno=${STR_ARRAY[0]}
dataok=$(LANG=en_EN date -Rd "$anno-$mese-$giorno")

URLINT="http://sac2.halleysac.it/c038003/mc/mc_p_dettaglio.php?id_pubbl="

# creo il corpo del feed RSS
echo "<item><title>$title</title><link>$URLINT$id</link><pubDate>$dataok</pubDate></item>" >> $output/out.xml

done < $INPUT
IFS=$OLDIFS

# creo il feed RSS, facendo il merge di intestazione, corpo e piede
echo $intestazioneRSS >> $output/feed.xml
cat $output/out.xml >> $output/feed.xml
echo $chiusuraRSS >> $output/feed.xml

cat $output/feed.xml > $output/feed_rss.xml
