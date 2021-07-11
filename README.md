Application built using hexagonal architecture.

Every use-case of application can be found in `src/Application/Application.php` which is the Application facade.

Logic about calculating salary addon can be found in `Domain` folder.

---

To enable this project please use docker:

```
docker-compose up -d
```

To generate report try executing the command: 

```
$ php bin/console report-generator
+---------+-----------+------------------+--------------------------------+-----------------------------+-------------------------------+----------------------------------------+
| Imię    | Nazwisko  | Dział            | Podstawa Wynagrodzenia (kwota) | Dodatek do podstawy (kwota) | Typ dodatku (typ % lub stały) | Wynagrodzenie wraz z dodatkiem (kwota) |
+---------+-----------+------------------+--------------------------------+-----------------------------+-------------------------------+----------------------------------------+
| Adam    | Kowalski  | Human Resources  | $1,000.00                      | $1,000.00                   | fixed                         | $2,000.00                              |
| Ania    | Nowak     | Customer Service | $1,100.00                      | $110.00                     | percent                       | $1,210.00                              |
| Raymond | Ainsworth | Customer Service | $1,740.00                      | $174.00                     | percent                       | $1,914.00                              |
| Silvia  | Wade      | Customer Service | $1,920.00                      | $192.00                     | percent                       | $2,112.00                              |
| Adam    | Wade      | Customer Service | $1,940.00                      | $194.00                     | percent                       | $2,134.00                              |
+---------+-----------+------------------+--------------------------------+-----------------------------+-------------------------------+----------------------------------------+
```