# Data Professional Survey Dashboard

An interactive **Power BI** dashboard that breaks down the results of a Data Professional Survey: who the respondents are, what they do, which programming languages they prefer, how much they earn, and how satisfied they are in their careers.

---

## Overview

The report (`the_course_project.pbix`) is a single-page dashboard built on one table, **Data Professional Survey**. It gives a quick, visual summary of the survey so the viewer can spot patterns in roles, salaries, satisfaction and the difficulty of entering the data field.

## Dashboard Preview

> Add a screenshot of your report here:
>
> `![Dashboard preview](dashboard_preview.png)`

## Visuals

The page (1920 x 1080) is titled **"Data Professional Survey Breakdown"** and contains these visuals:

| Visual | Type | What it shows |
|---|---|---|
| Total respondents | Card | Number of survey takers (count of `Unique ID`) |
| Average age of survey takers | Card | Average of `Q10 - Current Age` |
| Country of survey takers | Treemap | Number of respondents per country (`Q11`) |
| Favorite Programming | Column chart | Favorite programming language (`Q5`), split by job title |
| Average salary by job title | Bar chart | Average salary for each job title (`Q1`) |
| Happiness with salary | Gauge | Average satisfaction with salary (`Q6 - Salary`) |
| Happiness with work/life balance | Gauge | Average satisfaction with work/life balance (`Q6 - Work/Life Balance`) |
| Difficulty to break into data | Donut chart | Share of respondents by how hard it was to enter the field (`Q7`) |

All visuals are cross-filtering, so clicking a country, job title or answer updates the other charts.

## Data Model

A single table, **Data Professional Survey**, with these fields used in the report:

| Field | Description |
|---|---|
| `Unique ID` | Unique identifier for each respondent |
| `Q1 - Which Title Best Fits your Current Role?` | Job title |
| `Q5 - Favorite Programming Language` | Preferred programming language |
| `Q6 - How Happy are you in your Current Position with the following? (Salary)` | Satisfaction with salary |
| `Q6 - How Happy are you in your Current Position with the following? (Work/Life Balance)` | Satisfaction with work/life balance |
| `Q7 - How difficult was it for you to break into Data?` | Difficulty of entering the field |
| `Q10 - Current Age` | Respondent age |
| `Q11 - Which Country do you live in?` | Country of residence |
| `average salary` | Salary value used for the salary-by-title chart |

## Design

- Theme: **Bloom** (custom theme) on the Fluent 2 base theme
- Layout: bold centered title banner, KPI cards at the top, and charts arranged in a grid below

## Tools Used

- Microsoft Power BI Desktop
- Power Query (data import and cleaning)
- DAX / aggregations (average, count, min, max)

## How to Open

1. Install [Power BI Desktop](https://powerbi.microsoft.com/desktop/) (free, Windows).
2. Download `the_course_project.pbix`.
3. Open the file in Power BI Desktop. The data is stored inside the file, so no extra setup is needed.

## Key Questions the Dashboard Answers

- Where do the survey respondents live, and how old are they on average?
- Which job titles are most common, and which pay the most?
- Which programming languages do data professionals prefer in each role?
- How satisfied are people with their salary and work/life balance?
- How difficult is it to break into the data field?


*Part of my data analyst course projects.*
