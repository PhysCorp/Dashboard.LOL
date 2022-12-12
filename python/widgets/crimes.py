import requests
from bs4 import BeautifulSoup
from datetime import datetime, timedelta
from yattag import Doc
import dashboard
SLASH_CODE = f'%2F'

crime_table = None

offset = 0
results_found = False
while results_found == False:
    try:
        #Try finding table results for past 7 days, if nothing then IndexError
        end_date = datetime.now() - timedelta(days=7 * offset)
        start_date = end_date - timedelta(days=7 * (offset + 1))
        end_date_url = end_date.strftime('%Y/%#m/%#d').replace('/', SLASH_CODE)
        start_date_url = start_date.strftime('%Y/%#m/%#d').replace('/', SLASH_CODE)
        url = f'https://oupolice.com/clery/activity-log/?crimemonth={start_date_url}&crimemonth2={end_date_url}'
        print(f'[crimes] Getting activity for {start_date.strftime("%#m/%#d/%Y")} - {end_date.strftime("%#m/%#d/%Y")}')
        print(f'[crimes] Querying: {url}')
        page = requests.get(url)
        soup = BeautifulSoup(page.content, "html.parser")
        crime_table = soup.find_all('table', {'class': 'crimetable'})[0]
        results_found = True
    except IndexError as e:
        #Need to go back another week
        results_found = False
        offset += 1

heading = crime_table.find_all('tr')[0]
crime_rows = crime_table.find_all('tr')[1:]
most_recent_five = crime_rows[-5:]

print('[crimes] Writing HTML...')
doc, tag, text = Doc().tagtext()
with tag('p'):
    text('5 most recent activity entries reported by OUPD:')
with tag('table', klass='table table-striped table-hover'):
    with tag('tbody'):
        with tag('tr'):
            with tag('th'):
                text('Reported')
            with tag('th'):
                text('Nature')
            with tag('th'):
                text('Address')
            for row in most_recent_five:
                crime_info = row.find_all('td')
                reported = crime_info[2].text.strip()
                nature = crime_info[1].text.strip()
                address = crime_info[4].text.strip()
                with tag('tr'):
                    with tag('td'):
                        text(reported)
                    with tag('td'):
                        text(nature)
                    with tag('td'):
                        text(address)
html = doc.getvalue()
print('[crimes] Posting to widget...')
post = dashboard.post_to_widget('crimes', html)
print(post)