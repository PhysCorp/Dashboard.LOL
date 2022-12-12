import requests
from bs4 import BeautifulSoup
from yattag import Doc
import dashboard

print('[wepa] Fetching wepa dashboard...')
url = 'https://cs.wepanow.com/000OAKLAND215.html'
page = requests.get(url)
soup = BeautifulSoup(page.content, "html.parser")

tables = soup.find_all('table', {'class': 'ps-table'})
sadit_table = tables[5]
table_body = sadit_table.find_all('tbody')[0]
status_rows = table_body.find_all('tr')[0::2]

printers = []
for row in status_rows:
    printer_info = row.find_all('td')
    color_status = printer_info[0].text.strip()
    printer_code = printer_info[1].text.strip()
    printer_name = printer_info[2].text.strip()
    status_message = printer_info[3].text.strip()
    printer_text = printer_info[4].text.strip()
    toner_percent_kcmy = (int(printer_info[5].text.strip()), int(printer_info[6].text.strip()), int(printer_info[7].text.strip()), int(printer_info[8].text.strip()))
    drum_percent_kcmy = (int(printer_info[9].text.strip()), int(printer_info[10].text.strip()), int(printer_info[11].text.strip()), int(printer_info[12].text.strip()))
    belt_percent = printer_info[13].text.strip()
    fuser_percent = printer_info[14].text.strip()

    if color_status == 'YEL':
        color_string = 'Yellow'
    elif color_status == 'RED':
        color_string = 'Red'
    else:
        color_string = 'Green'

    status = (printer_code, color_string, status_message)
    printers.append(status)

print('[wepa] Writing HTML...')
doc, tag, text = Doc().tagtext()
with tag('table', klass='table table-striped table-hover'):
    with tag('tbody'):
        with tag('tr'):
            with tag('th'):
                text('No.')
            with tag('th'):
                text('Status')
            with tag('th'):
                text('Message')
            for printer in printers:
                printer_code = printer[0]
                color_string = printer[1]
                status_message = printer[2]
                with tag('tr'):
                    with tag('td'):
                        text(printer_code)
                    if color_string == 'Yellow':
                        with tag('td', klass='p-3 mb-2 bg-warning text-dark'):
                            text(color_string)
                    elif color_string == 'Red':
                        with tag('td', klass='p-3 mb-2 bg-danger text-white'):
                            text(color_string)
                    else: #Green
                        with tag('td', klass='text-success'):
                            text(color_string)
                    with tag('td'):
                        text(status_message)

html = doc.getvalue()
print('[wepa] Posting to widget...')
post = dashboard.post_to_widget('wepa', html)
print(post)