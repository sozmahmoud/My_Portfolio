# Customer Call List Cleaning with Pandas

A hands-on data cleaning project that turns a messy customer contact spreadsheet into a clean, call-ready dataset using **Python** and **pandas**.

---

## Overview

The raw file (`Customer Call List.xlsx`) contains typical real-world data problems: duplicate rows, stray characters in names, phone numbers in inconsistent formats, missing values, combined address fields, and inconsistent Yes/No labels. This notebook (`Pandas__Data_Cleaning.ipynb`) walks through each problem step by step and fixes it.

## Dataset

| Column | Description |
|---|---|
| `CustomerID` | Unique customer identifier |
| `First_Name` / `Last_Name` | Customer name |
| `Phone_Number` | Contact number (inconsistent formats in raw data) |
| `Address` | Full address in one field |
| `Paying Customer` | Whether the customer is paying (Yes / No / Y / N) |
| `Do_Not_Contact` | Whether the customer should not be called |
| `Not_Useful_Column` | Irrelevant column, removed during cleaning |

## Cleaning Steps

1. **Load data** from Excel with `pd.read_excel()`.
2. **Remove duplicates** with `drop_duplicates()`.
3. **Drop irrelevant columns** (`Not_Useful_Column`).
4. **Clean last names** by stripping whitespace and unwanted characters (`/`, `...`, `_`) using `str.strip()`, `str.lstrip()`, `str.rstrip()` and `str.replace()`.
5. **Standardize phone numbers**
   - Convert to string and remove all non-digit characters with a regex.
   - Reformat 10-digit numbers as `XXX-XXX-XXXX`.
   - Replace `NaN` / `N/a` placeholders and remove rows with no phone number.
6. **Split the address** into `Street_address`, `State` and `Zip_code` with `str.split(',', expand=True)`, then drop the original `Address` column and temporary helper columns.
7. **Standardize Yes/No values** in `Paying Customer` and `Do_Not_Contact` to `Y` / `N`.
8. **Reset the index** for a tidy final DataFrame.

## Before and After

**Before** (examples from the raw data)

| Last_Name | Phone_Number | Address | Paying Customer |
|---|---|---|---|
| `/White` | `7066950392` | `298 Drugs Driveway` | `N` |
| `...Potter` | `7066950392` | `2394 Hogwarts Avenue` | `Y` |
| `Flenderson_` | `304-762-2467` | `214 HR Avenue` | `N` |
| `Nadir` | `123/643/9775` | `93 West Main Street` | `No` |
| `Snow` | `876\|678\|3469` | `123 Dragons Road` | `Y` |

**After**

| Last_Name | Phone_Number | Street_address | State | Paying Customer |
|---|---|---|---|---|
| `Flenderson` | `304-762-2467` | `214 HR Avenue` | NaN | `N` |
| `Nadir` | `123-643-9775` | `93 West Main Street` | NaN | `N` |
| `Snow` | `876-678-3469` | `123 Dragons Road` | NaN | `Y` |
| `Schrute` | `123-543-2345` | `980 Paper Avenue` | `Pennsylvania` | `Y` |

The final cleaned dataset has 13 customers with columns: `CustomerID`, `First_Name`, `Last_Name`, `Phone_Number`, `Paying Customer`, `Do_Not_Contact`, `Street_address`, `State`, `Zip_code`.

## Tools and Skills Demonstrated

- Python 3, pandas, Jupyter Notebook
- `read_excel`, `drop_duplicates`, `drop`, `replace`, `reset_index`
- String methods (`.str.strip`, `.str.replace`, `.str.split`) and regular expressions
- `apply()` with lambda functions
- Handling missing values and standardizing categorical data

## How to Run

1. Install the requirements:
   ```bash
   pip install pandas openpyxl jupyter
   ```
2. Place `Customer Call List.xlsx` in your working folder.
3. Update the file path in the second cell of the notebook, for example:
   ```python
   df = pd.read_excel("Customer Call List.xlsx")
   ```
4. Open the notebook and run all cells:
   ```bash
   jupyter notebook Pandas__Data_Cleaning.ipynb
   ```

## Possible Improvements

- Use `str.title()` or a regex-based pattern instead of several chained `lstrip`/`rstrip` calls for names.
- Use `df["Paying Customer"].replace({"Yes": "Y", "No": "N"})` in one step instead of `str.replace`, which can alter other text containing "No".
- Fill missing `Do_Not_Contact` values explicitly instead of leaving them as `NaN`.
- Save the final result with `df.to_excel("Customer Call List - Clean.xlsx", index=False)`.

---

*Part of my data analyst course practice projects.*
