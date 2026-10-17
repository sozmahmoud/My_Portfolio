# Cryptocurrency Market Intelligence & Analytics

A Jupyter Notebook project for collecting, cleaning, analyzing, and visualizing live cryptocurrency market data from the CoinMarketCap API.

The notebook fetches current market listings, prepares the data for analysis, calculates market summary metrics, highlights Bitcoin performance, and exports charts and CSV files that can be used for portfolio presentation or further analysis.

## Project Overview

This project demonstrates a full data analytics workflow:

- Connect to the CoinMarketCap API
- Collect the latest cryptocurrency market data
- Clean, rename, and convert market fields
- Analyze price, market capitalization, volume, and percentage changes
- Compare top cryptocurrencies by market capitalization
- Review best and worst short-term market performance
- Track Bitcoin price and volume over time
- Create visual reports with Matplotlib and Seaborn
- Export cleaned data and chart images

## Main Notebook

```text
Cryptocurrency Market Intelligence & Analytics.ipynb
```

The notebook includes:

- API request setup for CoinMarketCap latest listings
- Data collection for the top 15 cryptocurrencies
- Error handling for API, timeout, connection, and HTTP issues
- Data cleaning and selected-column preparation
- Market overview reporting
- Top market-cap ranking
- Bitcoin-focused summary analysis
- Correlation analysis across market variables
- Historical collection logic with timed intervals
- CSV export for latest and historical datasets
- Visualization generation for saved PNG charts

## Visualizations

The repository includes exported chart images:

- `top_10_market_cap.png` - top 10 cryptocurrencies by market capitalization
- `daily_performance.png` - 24-hour performance comparison
- `price_vs_market_cap.png` - price, market capitalization, volume, and 24-hour change
- `correlation_heatmap.png` - correlation between numeric market variables
- `BTC_overtime.png` - Bitcoin price over time
- `BTC_24H.png` - Bitcoin 24-hour trading volume over time
- `line_chart.png` - additional time-series market visualization

## Data Outputs

Running the notebook can generate these CSV files:

- `crypto_market_latest.csv` - latest cleaned market snapshot
- `crypto_market_history.csv` - historical market snapshots appended over time

These files are created only after running the relevant notebook cells.

## Requirements

Use Python 3 with Jupyter Notebook or JupyterLab.

Install the required packages:

```bash
pip install requests pandas matplotlib seaborn
```

Main Python libraries:

- `requests`
- `pandas`
- `matplotlib`
- `seaborn`

## API Key Setup

This project requires a CoinMarketCap API key.

For safer GitHub sharing, do not hard-code the API key in the notebook. Store it as an environment variable instead:

```powershell
$env:CMC_API_KEY = "your_api_key_here"
```

Then read it in Python:

```python
import os

API_KEY = os.getenv("CMC_API_KEY")
```

If the notebook currently contains a real API key, replace it before publishing the project.

## How to Run

1. Install the required Python packages.
2. Add your CoinMarketCap API key.
3. Open `Cryptocurrency Market Intelligence & Analytics.ipynb`.
4. Run the notebook cells from top to bottom.
5. Review the generated tables, charts, and CSV exports.

Some historical collection cells use `sleep()` and may take a long time to complete.

## Project Structure

```text
.
|-- Cryptocurrency Market Intelligence & Analytics.ipynb
|-- README.md
|-- top_10_market_cap.png
|-- daily_performance.png
|-- price_vs_market_cap.png
|-- correlation_heatmap.png
|-- BTC_overtime.png
|-- BTC_24H.png
`-- line_chart.png
```

## Notes

- Cryptocurrency prices and market metrics change every time fresh API data is collected.
- API failures may be caused by an invalid API key, network issues, or CoinMarketCap plan limits.
- Historical CSV output depends on running the collector cells over time.
- Exported PNG files let viewers preview the analysis without rerunning the notebook.

## Portfolio Summary

This project shows practical data analytics skills using real-world financial market data, including API integration, data cleaning, exploratory analysis, visualization, historical tracking, and export-ready reporting.
