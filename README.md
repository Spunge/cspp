
## CSPP monthly holding importer

### Setup
First configure a database in `.env` and run the migrations `php bin/console doctrine:migrations:migrate`

### Import CSPP holdings
You can use the `php bin/console import:corporate-bond-securities --until 03-10-2017` command to import data from the ECB. This will import data from the start of the CSPP programme until the supplied `until` date, or until today when no date is supplied.

The data that is being imported now is the data from the [weekly holding reports](https://www.ecb.europa.eu/mopo/implement/app/html/index.en.html). Other possibly interesting data are found in the [daily liquidity conditions](https://www.ecb.europa.eu/stats/policy_and_exchange_rates/minimum_reserves/html/index.en.html) and the [history of cumulative purchases](https://www.ecb.europa.eu/mopo/pdf/CSPP_breakdown_history.csv)


