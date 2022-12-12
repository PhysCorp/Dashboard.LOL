import requests
from api import DASHBOARD_AGENT_USERNAME, DASHBOARD_AGENT_PASSWORD, POST_URL

def post_to_widget(name: str, data: str):
    request = requests.post(POST_URL, data={
        'username': DASHBOARD_AGENT_USERNAME,
        'password': DASHBOARD_AGENT_PASSWORD,
        'internal_name': name,
        'data': data
        })
    result = request.text
    return result