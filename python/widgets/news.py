import requests
from api import NEWS_TOKEN
from yattag import Doc

url = f'https://newsapi.org/v2/top-headlines?country=us&apiKey={NEWS_TOKEN}'

response = requests.get(url)
data = response.json()

trending_articles = data['articles'][0:5]

doc, tag, text = Doc().tagtext()
with tag('p'):
    text('Trending news articles in the US')
with tag('table', klass='table table-striped table-hover'):
    with tag('tbody'):
        with tag('tr'):
            with tag('th'):
                text('Article Title')
            with tag('th'):
                text('')
        for article in trending_articles:
            article_title = article['title']
            with tag('tr'):
                with tag('td'):
                    text(article_title)
                with tag('td'):
                    with tag('a', klass='btn btn-primary', href=article['url'], target='_blank'):
                            text('Link')

html = doc.getvalue()
request = requests.post('http://127.0.0.1/dashboard/actions/cli/post.php', data={"username": 'dashboard_agent', "password": 'thedashboardliveson', "internal_name": 'news', "data": html})