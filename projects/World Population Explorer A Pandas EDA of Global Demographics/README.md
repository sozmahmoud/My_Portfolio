# 🌍 World Population Explorer: A Pandas EDA of Global Demographics

An exploratory data analysis (EDA) of world population data using **Python, Pandas, Seaborn and Matplotlib**. The notebook inspects the dataset, ranks countries by population, checks how the variables relate to each other, and compares population trends across continents.

---

## 📌 Project Overview

The goal of this project is to get to know a world population dataset and answer simple questions such as:

- What does the dataset contain, and is it clean?
- Which countries have the smallest and largest populations?
- How are the population columns (and other numeric variables) correlated?
- How do continents compare in average population, and how has this changed over time?

---

## 📁 Repository Structure

```
world-population-eda/
├── Pandas_Exploratory_Data.ipynb   # Main analysis notebook
├── world_population.csv            # Dataset (add your copy here)
└── README.md
```

> **Note:** The dataset file is not included in this repository. Place `world_population.csv` in the same folder as the notebook.

---

## 🗂️ Dataset

The notebook reads `world_population.csv`, a country-level dataset with one row per country or territory. It has columns for country details (such as continent), population counts for several years (the notebook refers to `2022 Population` and uses a block of year columns for the trend charts), and other numeric measures.

Before running the notebook, check that your CSV has a `Continent` column and a `2022 Population` column, since the code depends on both.

---

## 🔬 What the Notebook Does

| Step | Description |
|---|---|
| **1. Load data** | Reads the CSV with `pd.read_csv()` |
| **2. Format output** | Sets Pandas to show floats with 2 decimal places |
| **3. Inspect** | `df.info()`, `df.describe()`, `df.isnull().sum()`, `df.nunique()` to check structure, missing values and unique counts |
| **4. Rank countries** | Sorts by `2022 Population` to see the 10 smallest and 10 largest |
| **5. Correlation** | `df.corr()` and a Seaborn **heatmap** of the numeric columns |
| **6. Continent analysis** | `groupby("Continent").mean()` for average values per continent |
| **7. Oceania deep dive** | Filters Oceania and looks at its average values |
| **8. Population over time** | Averages the year columns per continent, sorts them, transposes the table and draws a **line chart** |
| **9. Outliers** | A **boxplot** of all numeric columns to spot outliers and scale differences |
| **10. Data types** | Checks `df.dtypes` and selects numeric columns for further analysis |

---

## 🛠️ Tools & Libraries

- **Python 3**
- **Pandas**: data loading, cleaning, grouping, sorting
- **Seaborn**: correlation heatmap
- **Matplotlib**: line charts and boxplot
- **Jupyter Notebook**

---

## ▶️ How to Run

1. **Clone the repository**
   ```bash
   git clone https://github.com/<your-username>/world-population-eda.git
   cd world-population-eda
   ```
2. **Install the requirements**
   ```bash
   pip install pandas seaborn matplotlib jupyter
   ```
3. **Fix the file path.** The notebook currently loads the CSV from a local Windows path. Change this line to a relative path:
   ```python
   df = pd.read_csv("world_population.csv")
   ```
4. **Launch the notebook**
   ```bash
   jupyter notebook Pandas_Exploratory_Data.ipynb
   ```

---

## 💡 Skills Demonstrated

- Data inspection and quality checks
- Sorting, filtering and grouping with Pandas
- Correlation analysis
- Data visualisation (heatmap, line chart, boxplot)
- Comparing groups (continents) over time

