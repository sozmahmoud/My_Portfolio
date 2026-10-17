from pathlib import Path
from PIL import Image, ImageDraw, ImageFont

root = Path(__file__).resolve().parent
projects = [
    ('LIORA', 'projects/LIORA', 'Full Stack Web Project', ['PHP', 'MySQL', 'JavaScript', 'HTML5', 'CSS3']),
    ('Airbnb Booking Analysis', 'projects/Airbnb Booking Analysis using Tableau', 'Tableau Dashboard', ['Tableau', 'Excel', 'Data Viz']),
    ('Amazon Product Price Tracker', 'projects/Amazon Product Price Tracker & Web Scraper', 'Python Web Scraper', ['Python', 'Requests', 'BeautifulSoup', 'Pandas']),
    ('World Layoffs SQL Analysis', 'projects/World Layoffs SQL Data Cleaning & Exploratory Analysis', 'SQL Data Cleaning', ['SQL', 'MySQL', 'Data Cleaning', 'EDA']),
    ('COVID-19 Data Analysis', 'projects/COVID-19 Global Data Analysis - Python, MySQL', 'Python + SQL', ['Python', 'Pandas', 'SQL Server', 'Matplotlib']),
    ('Crypto Market Intelligence', 'projects/Cryptocurrency Market Intelligence & Analytics', 'Python Analytics', ['Python', 'Pandas', 'API', 'Seaborn']),
    ('Customer Call List Cleaning', 'projects/Customer Call List Cleaning with Pandas', 'Pandas Data Cleaning', ['Python', 'Pandas', 'Data Cleaning']),
    ('CycleInsight Dashboard', 'projects/CycleInsight Bike Buyer Analysis & Dashboard', 'Excel Dashboard', ['Excel', 'Pivot Tables', 'Dashboarding']),
    ('Data Professional Survey Dashboard', 'projects/Data Professional Survey Dashboard', 'Power BI Dashboard', ['Power BI', 'DAX', 'Data Modeling']),
    ('World Population Explorer', 'projects/World Population Explorer A Pandas EDA of Global Demographics', 'Pandas EDA', ['Python', 'Pandas', 'Visualization', 'EDA']),
]

for name, folder, project_type, stack in projects:
    folder_path = root / folder
    folder_path.mkdir(parents=True, exist_ok=True)
    out_path = folder_path / 'preview.png'

    image = Image.new('RGB', (1600, 1000), '#F3EFE7')
    draw = ImageDraw.Draw(image)

    for y in range(0, 1000, 10):
        ratio = y / 1000
        color = tuple(int(243 - (243 - 145) * ratio) for _ in range(3))
        draw.rectangle([0, y, 1600, y + 10], fill=color)

    draw.rounded_rectangle([60, 60, 1540, 940], radius=32, fill=(255, 255, 255, 80), outline=(218, 206, 160, 180), width=2)
    draw.rounded_rectangle([120, 120, 1480, 220], radius=24, fill=(42, 86, 77))
    draw.rounded_rectangle([120, 250, 1480, 860], radius=28, fill=(255, 255, 255, 180), outline=(220, 220, 220), width=1)

    try:
        title_font = ImageFont.truetype('C:/Windows/Fonts/arial.ttf', 72)
        body_font = ImageFont.truetype('C:/Windows/Fonts/arial.ttf', 34)
        small_font = ImageFont.truetype('C:/Windows/Fonts/arial.ttf', 22)
    except Exception:
        title_font = ImageFont.load_default()
        body_font = ImageFont.load_default()
        small_font = ImageFont.load_default()

    draw.text((180, 150), name, fill='white', font=title_font)
    draw.text((180, 300), project_type, fill=(74, 111, 103), font=body_font)
    draw.text((180, 360), 'Portfolio project preview', fill=(88, 93, 110), font=small_font)

    tag_x = 180
    tag_y = 430
    for tag in stack:
        tag_w = 200 if len(tag) > 6 else 140
        draw.rounded_rectangle([tag_x, tag_y, tag_x + tag_w, tag_y + 52], radius=10, fill=(220, 234, 230), outline=(111, 164, 154), width=1)
        draw.text((tag_x + 18, tag_y + 12), tag, fill=(47, 122, 109), font=small_font)
        tag_x += tag_w + 16
        if tag_x > 1100:
            tag_x = 180
            tag_y += 70

    draw.rounded_rectangle([180, 650, 700, 820], radius=18, fill=(216, 180, 112))
    draw.rounded_rectangle([760, 650, 1280, 820], radius=18, fill=(40, 92, 79))
    draw.text((220, 690), 'Project', fill='white', font=small_font)
    draw.text((220, 730), 'Showcase', fill='white', font=body_font)
    draw.text((800, 690), 'GitHub', fill='white', font=small_font)
    draw.text((800, 730), 'Repository', fill='white', font=body_font)

    draw.rounded_rectangle([120, 850, 1480, 900], radius=16, fill=(248, 245, 238), outline=(213, 220, 209))
    draw.text((180, 870), 'Data Analytics • Portfolio • 2026', fill=(65, 74, 91), font=small_font)

    image.save(out_path)
    print(f'Created {out_path}')
