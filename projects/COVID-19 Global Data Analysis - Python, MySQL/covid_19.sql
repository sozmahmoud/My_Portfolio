---------------------------------------------------------------------
-- COVID-19 GLOBAL DATA ANALYSIS - CLEANED AND ORGANIZED VERSION
-- This script keeps the original logic and table names, but removes
-- duplicate blocks, improves readability, and standardizes the flow.
---------------------------------------------------------------------

IF DB_ID('CovidProject') IS NULL
BEGIN
    CREATE DATABASE CovidProject;
END
GO

USE CovidProject;
GO

---------------------------------------------------------------------
-- 1. CREATE TABLES
---------------------------------------------------------------------

IF OBJECT_ID('dbo.CovidDeaths', 'U') IS NOT NULL
    DROP TABLE dbo.CovidDeaths;

IF OBJECT_ID('dbo.CovidVaccinations', 'U') IS NOT NULL
    DROP TABLE dbo.CovidVaccinations;

CREATE TABLE CovidDeaths (
    iso_code     VARCHAR(20),
    continent    VARCHAR(50),
    location     VARCHAR(100),
    date         DATE,
    population   FLOAT,
    total_cases  FLOAT,
    new_cases    FLOAT,
    total_deaths FLOAT,
    new_deaths   FLOAT
);

CREATE TABLE CovidVaccinations (
    iso_code           VARCHAR(20),
    continent          VARCHAR(50),
    location           VARCHAR(100),
    date               DATE,
    total_vaccinations FLOAT,
    people_vaccinated  FLOAT,
    new_vaccinations   FLOAT
);

---------------------------------------------------------------------
-- 2. QUICK DATA QUALITY CHECKS
---------------------------------------------------------------------

SELECT COUNT(*) AS deaths_rows FROM dbo.CovidDeaths;
SELECT COUNT(*) AS vaccination_rows FROM dbo.CovidVaccinations;

SELECT COUNT(DISTINCT location) AS total_locations
FROM dbo.CovidDeaths
WHERE continent IS NOT NULL;

SELECT TOP 20 *
FROM dbo.CovidDeaths;

SELECT MIN(date) AS first_date, MAX(date) AS last_date
FROM dbo.CovidDeaths;

SELECT continent, COUNT(*) AS rows_count
FROM dbo.CovidDeaths
GROUP BY continent
ORDER BY rows_count DESC;

SELECT
    SUM(CASE WHEN total_cases IS NULL THEN 1 ELSE 0 END) AS null_total_cases,
    SUM(CASE WHEN total_deaths IS NULL THEN 1 ELSE 0 END) AS null_total_deaths,
    SUM(CASE WHEN new_cases IS NULL THEN 1 ELSE 0 END) AS null_new_cases,
    SUM(CASE WHEN population IS NULL THEN 1 ELSE 0 END) AS null_population
FROM dbo.CovidDeaths;

SELECT location, date, COUNT(*) AS duplicate_count
FROM dbo.CovidDeaths
GROUP BY location, date
HAVING COUNT(*) > 1;

---------------------------------------------------------------------
-- 3. DATA CLEANING
---------------------------------------------------------------------

-- Convert zero values to NULL to avoid false zero readings in calculations.
UPDATE dbo.CovidDeaths
SET total_cases  = NULLIF(total_cases, 0),
    new_cases    = NULLIF(new_cases, 0),
    total_deaths = NULLIF(total_deaths, 0),
    new_deaths   = NULLIF(new_deaths, 0);

UPDATE dbo.CovidVaccinations
SET total_vaccinations = NULLIF(total_vaccinations, 0),
    people_vaccinated  = NULLIF(people_vaccinated, 0),
    new_vaccinations   = NULLIF(new_vaccinations, 0);

-- Remove accidental duplicate country rows if the source contains them.
DELETE FROM dbo.CovidDeaths
WHERE location = 'England';

DELETE FROM dbo.CovidVaccinations
WHERE location = 'England';

---------------------------------------------------------------------
-- 4. QUALITY CHECKS AFTER CLEANING
---------------------------------------------------------------------

SELECT
    SUM(CASE WHEN total_cases IS NULL THEN 1 ELSE 0 END) AS null_total_cases,
    SUM(CASE WHEN total_deaths IS NULL THEN 1 ELSE 0 END) AS null_total_deaths,
    SUM(CASE WHEN new_cases IS NULL THEN 1 ELSE 0 END) AS null_new_cases
FROM dbo.CovidDeaths;

SELECT location, date, COUNT(*) AS duplicate_count
FROM dbo.CovidDeaths
GROUP BY location, date
HAVING COUNT(*) > 1;

---------------------------------------------------------------------
-- 5. BASIC ANALYSIS QUERIES
---------------------------------------------------------------------

-- 5.1 Death percentage: chance of dying after infection in the US
SELECT location, date, total_cases, total_deaths,
       (total_deaths / total_cases) * 100 AS DeathPercentage
FROM dbo.CovidDeaths
WHERE location LIKE '%United States%'
  AND total_cases IS NOT NULL
ORDER BY date;

-- 5.2 Percentage of population infected over time in the US
SELECT location, date, population, total_cases,
       (total_cases / population) * 100 AS PercentPopulationInfected
FROM dbo.CovidDeaths
WHERE location LIKE '%United States%'
  AND total_cases IS NOT NULL
ORDER BY date;

-- 5.3 Countries with highest infection rate
SELECT location, population,
       MAX(total_cases) AS HighestInfectionCount,
       MAX(total_cases / population) * 100 AS PercentPopulationInfected
FROM dbo.CovidDeaths
WHERE continent IS NOT NULL
GROUP BY location, population
ORDER BY PercentPopulationInfected DESC;

-- 5.4 Countries with highest death count
SELECT location, MAX(total_deaths) AS TotalDeathCount
FROM dbo.CovidDeaths
WHERE continent IS NOT NULL
GROUP BY location
ORDER BY TotalDeathCount DESC;

-- 5.5 Continents summary (excluding summary rows like World)
SELECT location, MAX(total_deaths) AS TotalDeathCount
FROM dbo.CovidDeaths
WHERE continent IS NULL
  AND location NOT IN ('World')
GROUP BY location
ORDER BY TotalDeathCount DESC;

-- 5.6 Global totals from latest country totals
SELECT SUM(max_cases) AS total_cases,
       SUM(max_deaths) AS total_deaths,
       SUM(max_deaths) / NULLIF(SUM(max_cases), 0) * 100 AS DeathPercentage
FROM (
    SELECT location,
           MAX(total_cases) AS max_cases,
           MAX(total_deaths) AS max_deaths
    FROM dbo.CovidDeaths
    WHERE continent IS NOT NULL
    GROUP BY location
) AS latest;

SELECT MAX(total_cases) AS world_cases, MAX(total_deaths) AS world_deaths
FROM dbo.CovidDeaths
WHERE location = 'World';

---------------------------------------------------------------------
-- 6. VACCINATION ANALYSIS
---------------------------------------------------------------------

SELECT TOP 20
    d.location,
    d.date,
    d.population,
    v.new_vaccinations,
    v.people_vaccinated
FROM dbo.CovidDeaths d
JOIN dbo.CovidVaccinations v
    ON d.location = v.location AND d.date = v.date
WHERE d.continent IS NOT NULL
  AND v.people_vaccinated IS NOT NULL
ORDER BY d.location, d.date;

SELECT d.continent,
       d.location,
       d.date,
       d.population,
       v.new_vaccinations,
       SUM(v.new_vaccinations) OVER (
           PARTITION BY d.location
           ORDER BY d.date
       ) AS RollingVaccinations
FROM dbo.CovidDeaths d
JOIN dbo.CovidVaccinations v
    ON d.location = v.location AND d.date = v.date
WHERE d.continent IS NOT NULL
ORDER BY d.location, d.date;

WITH PopvsVac AS (
    SELECT d.continent,
           d.location,
           d.date,
           d.population,
           v.new_vaccinations,
           SUM(v.new_vaccinations) OVER (
               PARTITION BY d.location
               ORDER BY d.date
           ) AS RollingVaccinations
    FROM dbo.CovidDeaths d
    JOIN dbo.CovidVaccinations v
        ON d.location = v.location AND d.date = v.date
    WHERE d.continent IS NOT NULL
)
SELECT location, date, population, RollingVaccinations,
       (RollingVaccinations / population) * 100 AS DosesPer100People
FROM PopvsVac
WHERE RollingVaccinations IS NOT NULL
ORDER BY location, date;

---------------------------------------------------------------------
-- 7. ADVANCED ANALYSIS
---------------------------------------------------------------------

-- 7.1 Year-by-year comparison
SELECT location,
       YEAR(date) AS Year,
       MAX(population) AS Population,
       SUM(new_cases) AS TotalCases,
       SUM(new_deaths) AS TotalDeaths
FROM dbo.CovidDeaths
WHERE continent IS NOT NULL
  AND YEAR(date) IN (2020, 2021, 2022)
GROUP BY location, YEAR(date)
ORDER BY location, Year;

-- 7.2 Country death rate ranking
WITH CountryDeaths AS (
    SELECT location,
           MAX(population) AS Population,
           SUM(new_deaths) AS TotalDeaths
    FROM dbo.CovidDeaths
    WHERE continent IS NOT NULL
      AND date >= '2020-01-01'
      AND date < '2023-01-01'
    GROUP BY location
)
SELECT RANK() OVER (
           ORDER BY (TotalDeaths * 1000000.0 / NULLIF(Population, 0)) DESC
       ) AS DeathRank,
       location,
       Population,
       TotalDeaths,
       CAST(TotalDeaths * 1000000.0 / NULLIF(Population, 0) AS DECIMAL(12, 2)) AS DeathsPerMillion
FROM CountryDeaths
WHERE Population IS NOT NULL
  AND Population > 0
  AND TotalDeaths IS NOT NULL
ORDER BY DeathRank;

-- 7.3 Largest case jump by country
WITH ValidCases AS (
    SELECT location, date, new_cases
    FROM dbo.CovidDeaths
    WHERE continent IS NOT NULL
      AND date >= '2020-01-01'
      AND date < '2023-01-01'
      AND new_cases IS NOT NULL
),
CaseChanges AS (
    SELECT location,
           date,
           new_cases,
           LAG(new_cases) OVER (PARTITION BY location ORDER BY date) AS PreviousCases
    FROM ValidCases
),
RankedChanges AS (
    SELECT location,
           date,
           PreviousCases,
           new_cases,
           new_cases - PreviousCases AS CaseIncrease,
           RANK() OVER (PARTITION BY location ORDER BY new_cases - PreviousCases DESC) AS PeakRank
    FROM CaseChanges
    WHERE PreviousCases IS NOT NULL
)
SELECT location,
       date AS PeakDate,
       PreviousCases,
       new_cases AS ReportedCases,
       CaseIncrease
FROM RankedChanges
WHERE PeakRank = 1
ORDER BY CaseIncrease DESC;

-- 7.4 Death rate categories: Low / Medium / High
WITH CountryDeathRates AS (
    SELECT location,
           MAX(population) AS Population,
           SUM(new_deaths) AS TotalDeaths
    FROM dbo.CovidDeaths
    WHERE continent IS NOT NULL
      AND date >= '2020-01-01'
      AND date < '2023-01-01'
    GROUP BY location
),
DeathRates AS (
    SELECT location,
           Population,
           TotalDeaths,
           TotalDeaths * 1000000.0 / NULLIF(Population, 0) AS DeathsPerMillion
    FROM CountryDeathRates
)
SELECT location,
       Population,
       TotalDeaths,
       CAST(DeathsPerMillion AS DECIMAL(12, 2)) AS DeathsPerMillion,
       CASE
           WHEN DeathsPerMillion < 500 THEN 'Low'
           WHEN DeathsPerMillion < 1000 THEN 'Medium'
           ELSE 'High'
       END AS DeathRateCategory
FROM DeathRates
WHERE Population > 0
  AND Population IS NOT NULL
  AND TotalDeaths IS NOT NULL
ORDER BY DeathsPerMillion DESC;

---------------------------------------------------------------------
-- 8. FINAL BASE VIEWS
---------------------------------------------------------------------

IF OBJECT_ID('dbo.CountryLatest', 'V') IS NOT NULL
    DROP VIEW dbo.CountryLatest;

IF OBJECT_ID('dbo.CountryVaccinated', 'V') IS NOT NULL
    DROP VIEW dbo.CountryVaccinated;

CREATE VIEW dbo.CountryLatest AS
WITH ranked AS (
    SELECT location,
           continent,
           population,
           date,
           total_cases,
           total_deaths,
           ROW_NUMBER() OVER (PARTITION BY location ORDER BY date DESC) AS rn
    FROM dbo.CovidDeaths
    WHERE continent IS NOT NULL
      AND total_cases IS NOT NULL
      AND total_deaths IS NOT NULL
)
SELECT location,
       continent,
       population,
       date AS last_date,
       total_cases,
       total_deaths
FROM ranked
WHERE rn = 1;
GO

CREATE VIEW dbo.CountryVaccinated AS
WITH r AS (
    SELECT location,
           date,
           people_vaccinated,
           ROW_NUMBER() OVER (PARTITION BY location ORDER BY date DESC) AS rn
    FROM dbo.CovidVaccinations
    WHERE continent IS NOT NULL
      AND people_vaccinated IS NOT NULL
)
SELECT location,
       date AS vax_last_date,
       people_vaccinated
FROM r
WHERE rn = 1;
GO

---------------------------------------------------------------------
-- 9. FINAL SUMMARY REPORTS
---------------------------------------------------------------------

IF OBJECT_ID('dbo.CountrySummary', 'V') IS NOT NULL
    DROP VIEW dbo.CountrySummary;

CREATE VIEW dbo.CountrySummary AS
SELECT l.location,
       l.continent,
       l.population,
       l.last_date,
       l.total_cases,
       l.total_deaths,
       l.total_deaths * 1000000.0 / NULLIF(l.population, 0) AS deaths_per_million,
       l.total_deaths * 100.0 / NULLIF(l.total_cases, 0) AS death_pct,
       v.vax_last_date,
       v.people_vaccinated,
       v.people_vaccinated * 100.0 / NULLIF(l.population, 0) AS pct_one_dose,
       CASE
           WHEN l.total_deaths * 1000000.0 / NULLIF(l.population, 0) < 500 THEN 'Low'
           WHEN l.total_deaths * 1000000.0 / NULLIF(l.population, 0) < 2000 THEN 'Medium'
           ELSE 'High'
       END AS death_group
FROM dbo.CountryLatest l
LEFT JOIN dbo.CountryVaccinated v
    ON l.location = v.location;
GO

SELECT TOP 10 *
FROM dbo.CountrySummary
ORDER BY deaths_per_million DESC;

SELECT continent,
       COUNT(*) AS countries,
       SUM(total_deaths) AS total_deaths,
       ROUND(SUM(total_deaths) * 1000000.0 / SUM(population), 0) AS deaths_per_million
FROM dbo.CountryLatest
GROUP BY continent
ORDER BY deaths_per_million DESC;

SELECT COUNT(*) AS countries,
       SUM(total_cases) AS sum_latest_cases,
       SUM(total_deaths) AS sum_latest_deaths,
       MIN(last_date) AS earliest_last_date,
       MAX(last_date) AS latest_last_date
FROM dbo.CountryLatest;

---------------------------------------------------------------------
-- END OF SCRIPT
---------------------------------------------------------------------
