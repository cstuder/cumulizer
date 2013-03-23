rm -f ../all.csv
head -n 1 `ls | sort -n | head -1` > ../all.csv
cat * | grep -v 'Datum;Zeit' >> ../all.csv
mv ../all.csv .
