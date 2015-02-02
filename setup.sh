#!/bin/sh
HTTPD_GRP=apache
#chown :${HTTPD_GRP} app/cache -R
#chown :${HTTPD_GRP} app/logs -R
#chmod g+w app/logs -R
#chmod g+w app/cache -R


app/console generate:doctrine:entities HospiceSiteBundle
app/console doctrine:schema:drop --force --full-database
app/console doctrine:schema:create

app/console fos:user:create admin admin@dev.null admin

app/console doctrine:query:sql "INSERT into event_category(\"name\") values(\"GENERAL_EVENT\")"
app/console doctrine:query:sql "INSERT into event_category(\"name\") values(\"PATIENT_VISITING\")"
app/console doctrine:query:sql "INSERT into event_category(\"name\") values(\"DAY_OFF\")"

app/console doctrine:query:sql "INSERT into frequency(\"name\") values(\"PER_DAY\")"
app/console doctrine:query:sql "INSERT into frequency(\"name\") values(\"PER_WEEK\")"
app/console doctrine:query:sql "INSERT into frequency(\"name\") values(\"PER_MONTH\")"
app/console doctrine:query:sql "INSERT into frequency(\"name\") values(\"PER_YEAR\")"
app/console doctrine:query:sql "INSERT into frequency(\"name\") values(\"ON_WEEKDAYS\")"

#select id from frequency where name like \"PER_WEEK\"
app/console doctrine:query:sql "INSERT into interval_option(\"value\", \"name\", \"frequency_id\") values(\"1\", \"ON_MONDAY\", (select id from frequency where name like \"PER_WEEK\"))"
app/console doctrine:query:sql "INSERT into interval_option(\"value\", \"name\", \"frequency_id\") values(\"2\", \"ON_TUSEDAY\", (select id from frequency where name like \"PER_WEEK\"))"
app/console doctrine:query:sql "INSERT into interval_option(\"value\", \"name\", \"frequency_id\") values(\"4\", \"ON_WEDNESDAY\", (select id from frequency where name like \"PER_WEEK\"))"
app/console doctrine:query:sql "INSERT into interval_option(\"value\", \"name\", \"frequency_id\") values(\"8\", \"ON_THURSDAY\", (select id from frequency where name like \"PER_WEEK\"))"
app/console doctrine:query:sql "INSERT into interval_option(\"value\", \"name\", \"frequency_id\") values(\"16\", \"ON_FRIDAY\", (select id from frequency where name like \"PER_WEEK\"))"
app/console doctrine:query:sql "INSERT into interval_option(\"value\", \"name\", \"frequency_id\") values(\"32\", \"ON_SATURDAY\", (select id from frequency where name like \"PER_WEEK\"))"
app/console doctrine:query:sql "INSERT into interval_option(\"value\", \"name\", \"frequency_id\") values(\"64\", \"ON_SUNDAY\", (select id from frequency where name like \"PER_WEEK\"))"






