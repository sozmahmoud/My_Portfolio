# Amazon Product Price Tracker & Web Scraper

A Jupyter Notebook project that scrapes an Amazon product page, extracts product details, tracks the price over time, saves a local price history, and can alert you when the product reaches your target price.

The project is built around `Amazon Product Price Tracker & Web Scraper.ipynb`.

## Amazon Price History

This project includes an Amazon price history feature that records product prices over time, stores them in a CSV file, and helps you analyze trends such as the highest, lowest, average, and latest prices.

## Amazon Price Tracker

This project includes an Amazon price tracker that checks a product's current price, compares it with your target price, and can notify you when the item drops to a price you want.

## Features

- Scrapes product title, price, rating, review count, and availability.
- Saves every successful scrape to `amazon_price_history.csv`.
- Stores downloaded HTML in `amazon_debug.html` for troubleshooting.
- Detects common Amazon bot-check or CAPTCHA pages.
- Compares the current price against a configurable target price.
- Prints price history statistics such as highest, lowest, average, latest price, and price change.
- Includes an optional continuous monitor that checks the product every set number of hours.
- Includes an optional Gmail email alert function.
- Includes simple Matplotlib examples for visualizing price history.

## Project Files

| File | Description |
| --- | --- |
| `Amazon Product Price Tracker & Web Scraper.ipynb` | Main notebook containing the scraper, tracker, analyzer, monitor, and email alert code. |
| `amazon price history.png` | Screenshot showing the Amazon price history output. |
| `amazon price tracker.png` | Screenshot showing the Amazon price tracker interface/output. |
| `amazon_price_history.csv` | Generated after running the scraper. Stores historical product data. |
| `amazon_debug.html` | Generated after running the scraper. Stores the downloaded Amazon HTML for debugging. |

## Screenshots

![amazon price history.png](<amazon price history.png>)

![amazon price tracker.png](<amazon price tracker.png>)

## Requirements

Install Python 3 and Jupyter Notebook or JupyterLab.

Required Python packages:

```bash
pip install requests beautifulsoup4 pandas matplotlib
```

The notebook also uses standard Python libraries:

- `re`
- `os`
- `time`
- `datetime`
- `pathlib`
- `email.message`
- `smtplib`

## How To Use

1. Open the notebook:

   ```bash
   jupyter notebook "Amazon Product Price Tracker & Web Scraper.ipynb"
   ```

2. Update the product URL:

   ```python
   PRODUCT_URL = "https://www.amazon.com/dp/B01B77W0JI"
   ```

3. Set your target price:

   ```python
   TARGET_PRICE = 15.00
   ```

4. Run the notebook cells from top to bottom.

5. Run the scraper:

   ```python
   product_data = run_scraper()
   ```

6. View the saved history:

   ```python
   history_df = load_history()
   display(history_df)
   ```

## Continuous Monitoring

The notebook includes a monitoring function:

```python
monitor_price(interval_hours=24)
```

This keeps the cell running and checks the product every 24 hours. Stop the Jupyter cell manually when you no longer want it to run.

You can change the interval:

```python
monitor_price(interval_hours=6)
```

## Email Alerts

The notebook includes a Gmail alert function:

```python
send_email_alert(
    product=product_data,
    sender_email="your_email@gmail.com",
    receiver_email="receiver_email@gmail.com",
    app_password="your_app_password"
)
```

For Gmail, use an app password instead of your normal account password. Do not commit or share real email passwords or app passwords.

## Output Data

Each saved record contains:

- `Title`
- `Price`
- `Rating`
- `Reviews`
- `Availability`
- `Collected_At`
- `Product_URL`

Example CSV output:

```csv
Title,Price,Rating,Reviews,Availability,Collected_At,Product_URL
Example Product,14.99,4.5,1200,In Stock,2026-10-09 12:30:00,https://www.amazon.com/dp/B01B77W0JI
```

## Important Notes

- Amazon pages change often, so CSS selectors may need updates over time.
- Amazon may return a CAPTCHA or bot-check page instead of the product page.
- Scrape responsibly and avoid sending frequent automated requests.
- Review Amazon's terms of service before using this project beyond learning or personal experimentation.
- Product prices can vary by location, account, shipping address, seller, and time.

## Possible Improvements

- Move configuration into a separate `.env` or config file.
- Add support for tracking multiple products.
- Use the real `amazon_price_history.csv` data in the chart cells instead of sample data.
- Add scheduled execution with Task Scheduler, cron, or a cloud function.
- Add more robust alert channels such as Telegram, Discord, Slack, or desktop notifications.
- Add automated tests for price parsing and selector fallback logic.

## Author

Created as a learning project for web scraping, data collection, price tracking, and basic notification automation with Python.
