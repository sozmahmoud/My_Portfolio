# World Layoffs SQL Data Cleaning & Exploratory Analysis

This project demonstrates how to clean a messy layoffs dataset in MySQL and then perform exploratory analysis to uncover trends in company layoffs over time. The workflow follows a realistic data-cleaning process: create a staging copy, remove duplicates, standardize values, fix missing data, convert date strings, and then run summary queries.

## Project Goal

The business objective is to answer questions such as:

- Which years had the largest layoff totals?
- Which funding stages were hit hardest?
- Which companies had the biggest job cuts?
- How do layoffs trend over time by month and year?
- Which industries and regions are most affected?

## Tools Used

- MySQL 8.0+
- MySQL Workbench or any SQL client
- SQL queries using joins, CTEs, window functions, and date functions

## Dataset

The dataset contains layoff records for companies across different countries, industries, and funding stages.

Columns in the raw and cleaned tables:

- company
- location
- industry
- total_laid_off
- percentage_laid_off
- date
- stage
- country
- funds_raised_millions

## Repository Files

This workspace contains the following files:

- layoffs.csv — the original raw dataset exported as CSV
- layoffs.sql — creates the working tables and basic staging setup
- layoffs_staging.sql — identifies duplicates and creates the first staging copy
- layoffs_staging2.sql — performs cleaning, standardization, and exploratory analysis
- layoffs_staging2.csv — cleaned/exported output after the SQL transformation
- README.md — project summary and usage guide

## Database Setup

Create the database and import the raw CSV into a table named layoffs.

```sql
CREATE DATABASE world_layoffs;
USE world_layoffs;
```

Then import the CSV using MySQL Workbench or another SQL client into a table called layoffs.

## Data Cleaning Process

The SQL workflow includes the following cleaning steps:

1. Create a staging copy of the raw layoffs table.
2. Detect duplicate records using ROW_NUMBER() window functions.
3. Remove duplicate rows based on all relevant business columns.
4. Trim whitespace from company and country names.
5. Standardize inconsistent industry values such as:
   - Crypto
   - Crypto Currency
   - CryptoCurrency
6. Clean country names with trailing punctuation.
7. Convert text dates to proper SQL DATE values using STR_TO_DATE().
8. Replace blank industry values with NULL.
9. Fill missing industrial categories by matching company names.
10. Remove records where both total_laid_off and percentage_laid_off are null.

## Exploratory Analysis Performed

After cleaning, the project analyzes:

- total layoffs by year
- total layoffs by funding stage
- total layoffs by month
- rolling totals over time
- top companies by yearly layoffs
- high-impact layoff events using ranking functions

Examples of SQL concepts used:

- SELECT, GROUP BY, ORDER BY
- JOIN and self-join logic
- CTEs
- ROW_NUMBER() and DENSE_RANK()
- SUM() OVER() for rolling totals
- TRIM(), SUBSTRING(), STR_TO_DATE(), YEAR(), and MONTH()
- ALTER TABLE for column type conversion

## Workflow Summary

The project follows this pattern:

1. Raw data imported into layoffs
2. Staging table created from raw data
3. Duplicate records identified and removed
4. Data standardized and cleaned
5. Cleaned table exported as CSV
6. Analysis queries run to draw business insights

## Output

The final cleaned output is stored in:

- layoffs_staging2.csv

This dataset is the cleaned version used for analysis and can be reused in Python, Excel, or BI tools.

## Key Takeaways

This project highlights the importance of data cleaning before analysis. Raw operational datasets often contain duplicates, inconsistent labels, missing values, and formatting issues. Without standardization, any trend analysis can become misleading.

The main lessons are:

- Data quality issues can significantly distort business insights.
- Company and industry standardization is necessary for reliable grouping.
- Date conversion is essential for time-based analysis.
- Ranking and rolling-window functions help surface major events and trends.

## Notes

This repository is a practical example of SQL-based data-cleaning and exploratory analysis. It is useful for learning how to transform raw, messy business data into a trusted dataset suitable for analytical reporting.

## Repository Summary

```text
World Layoffs SQL Data Cleaning & Exploratory Analysis/
├── README.md
├── layoffs.csv
├── layoffs.sql
├── layoffs_staging.sql
├── layoffs_staging2.sql
├── layoffs_staging2.csv
└── world_layoffs database in MySQL
```

This project is intended as a hands-on example of SQL cleaning, staging, and exploratory analysis in a real-world data scenario.
