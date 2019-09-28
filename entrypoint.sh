#!/bin/sh

docker exec peep_sql_1 mysql -u peeper -p peep < /docker-entrypoint-initdb.d/peep.sql;
docker exec peep_php_1 php Classes/DataDownloader.php