import requests
from api import SPOTIFY_OAUTH_TOKEN
from yattag import Doc

#Top Songs - USA
#https://open.spotify.com/playlist/37i9dQZEVXbLp5XoPON0wI

playlist_id = '37i9dQZEVXbLp5XoPON0wI'
songs_to_show = 5

url = f'https://api.spotify.com/v1/playlists/{playlist_id}/tracks?market=US&fields=items(track(name,artists(name),external_urls(spotify)))&limit={songs_to_show}'

headers = {
    'Authorization': f'Bearer {SPOTIFY_OAUTH_TOKEN}',
    'Content-Type': 'application/json'
}

response = requests.get(url, headers=headers)
print(response.status_code)
data = response.json()
print(data)

trending_tracks = []
for item in data['items']:
    track_name = item['track']['name']
    artists = []
    for artist in item['track']['artists']:
        artists.append(artist['name'])
    track_artist_string = ', '.join(artists)
    track_link = item['track']['external_urls']['spotify']
    track_tup = (track_name, track_artist_string, track_link)
    trending_tracks.append(track_tup)

doc, tag, text = Doc().tagtext()
with tag('p'):
    text('Top 5 Songs in the USA in the past week (via Spotify)')
with tag('table', klass='table table-striped table-hover'):
    with tag('tbody'):
        with tag('tr'):
            with tag('th'):
                text('No.')
            with tag('th'):
                text('Artist(s)')
            with tag('th'):
                text('Song Title')
            with tag('th'):
                text('')
            for i, track in enumerate(trending_tracks):
                num = i + 1
                track_name = track[0]
                track_artist_string = track[1]
                track_link = track[2]
                with tag('tr'):
                    with tag('td'):
                        text(num)
                    with tag('td'):
                        text(track_artist_string)
                    with tag('td'):
                        text(track_name)
                    with tag('td'):
                        with tag('a', klass='btn btn-primary', href=track_link, target='_blank'):
                            text('Link')
html = doc.getvalue()

request = requests.post('http://127.0.0.1/dashboard/actions/cli/post.php', data={"username": 'dashboard_agent', "password": 'thedashboardliveson', "internal_name": 'spotify', "data": html})
