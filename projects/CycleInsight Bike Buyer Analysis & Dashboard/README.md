# 🚲 CycleInsight: Bike Buyer Analysis & Dashboard

An end-to-end Excel analytics project that cleans a customer dataset, segments customers, and presents an interactive dashboard showing **who buys bikes and why**.

---

## 📌 Project Overview

A bike retailer wants to understand the profile of customers who purchase bikes. This project takes the raw customer data (1,000 unique customers), cleans it, builds pivot tables, and presents the results in an interactive dashboard with slicers.

**Goal:** Identify which customer characteristics (age, income, region, commute distance, cars owned, etc.) are linked to a higher likelihood of buying a bike.

---

## 📁 Workbook Structure

The file `Excel_Project_Dataset.xlsx` contains four sheets:

| Sheet | Purpose |
|---|---|
| `bike_buyers` | **Raw data**, kept untouched for reference (1,026 rows, 13 columns) |
| `working sheet` | **Cleaned data**: standardised labels, duplicates removed, new `Age Bracket` column |
| `pivot table` | **Analysis layer**: 4 pivot tables and 4 pivot charts (e.g. average income by gender, purchases by age bracket) |
| `dashboard` | **Presentation layer**: charts and slicers for interactive filtering |

---

## 🗂️ Data Dictionary

| Column | Description |
|---|---|
| `ID` | Unique customer identifier |
| `Marital Status` | Married / Single (raw data uses M / S) |
| `Gender` | Male / Female (raw data uses M / F) |
| `Income` | Annual income |
| `Children` | Number of children (0–5) |
| `Education` | Partial High School, High School, Partial College, Bachelors, Graduate Degree |
| `Occupation` | Clerical, Manual, Skilled Manual, Professional, Management |
| `Home Owner` | Yes / No |
| `Cars` | Number of cars owned (0–4) |
| `Commute Distance` | 0-1, 1-2, 2-5, 5-10, 10+ Miles |
| `Region` | Europe, North America, Pacific |
| `Age` | Customer age in years |
| `Age Bracket` | *(derived)* adolescent / middle age / old |
| `Purchased Bike` | Target variable: Yes / No |

---

## 🧹 Data Cleaning Steps

1. **Removed duplicates**: 26 duplicate records removed (1,026 → 1,000 customers).
2. **Standardised abbreviations**: `M`/`S` → Married/Single; `M`/`F` → Male/Female.
3. **Created `Age Bracket`** with an `IF` formula:
   - Age **> 55** → `old`
   - Age **32–55** → `middle age`
   - Age **< 31** → `adolescent`
4. **Verified** there are no missing values.

> ⚠️ **Known issues to fix** (see *Improvements* below): some Gender values contain the typo `FeMaleale`, the column header `Martial status` is misspelled, and the age-bracket formula leaves exact ages 31 and 55 without a clean category.

---

## 🔍 Key Findings

Overall purchase rate: **48.1%** (481 of 1,000 customers).

| Factor | Higher purchase rate | Lower purchase rate |
|---|---|---|
| **Age** | Middle age (32–55): **54.8%** | Old (>55): 31.6% · Adolescent: 34.8% |
| **Region** | Pacific: **58.9%** | North America: 43.3% |
| **Cars owned** | 0 cars: **61.1%** · 1 car: 56.9% | 2+ cars: ~36–39% |
| **Commute distance** | 2–5 miles: **58.6%** · 0–1 miles: 54.6% | 10+ miles: 29.7% |
| **Marital status** | Single: **54.1%** | Married: 42.9% |
| **Education** | Bachelors / Graduate: ~54–55% | Partial High School: 26.3% |
| **Gender** | Roughly equal (F 48.9% vs M 47.4%) | n/a |
| **Home ownership** | Roughly equal | n/a |

**Takeaways**

- The typical bike buyer is a **middle-aged, single, college-educated person with few or no cars and a short commute**.
- **Gender and home ownership** are not meaningful predictors.
- **Income** shows only a small difference (average ≈ $58.0k for buyers vs ≈ $54.9k for non-buyers).
- The **Pacific region** is the strongest market; **North America** has the most room for growth.

---

## 🛠️ Excel Skills & Features Used

- Data cleaning (Remove Duplicates, Find & Replace)
- Nested `IF` formulas
- PivotTables and PivotCharts
- Slicers for interactive filtering
- Dashboard design

---

## ▶️ How to Use

1. Open `Excel_Project_Dataset.xlsx` in Microsoft Excel (2016 or later recommended, because slicers are used).
2. Go to the **dashboard** sheet.
3. Click the slicers to filter by customer attributes and watch the charts update.
4. To refresh the analysis after editing data: **Data → Refresh All**.


