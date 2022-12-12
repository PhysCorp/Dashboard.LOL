import spotipy
from api import SPOTIFY_CLIENT_ID, SPOTIFY_CLIENT_SECRET
from spotipy.oauth2 import SpotifyClientCredentials
from yattag import Doc
import dashboard

playlist_id = '37i9dQZEVXbLp5XoPON0wI'
items_to_show = 5

print('[spotify] Connecting to Spotify...')
sp = spotipy.Spotify(auth_manager=SpotifyClientCredentials(client_id=SPOTIFY_CLIENT_ID, client_secret=SPOTIFY_CLIENT_SECRET))

print('[spotify] Fetching playlist...')
data = sp.playlist_items(playlist_id=playlist_id, fields='items(track(name,artists(name),external_urls(spotify),album(images)))', limit=items_to_show, market='US')

trending_tracks = []
for item in data['items']:
    track_name = item['track']['name']
    artists = []
    for artist in item['track']['artists']:
        artists.append(artist['name'])
    track_artist_string = ', '.join(artists)
    track_link = item['track']['external_urls']['spotify']
    track_album_art_link = item['track']['album']['images'][2]['url']
    track_tup = (track_name, track_artist_string, track_link, track_album_art_link)
    trending_tracks.append(track_tup)

print('[spotify] Writing HTML...')
doc, tag, text = Doc().tagtext()
with tag('p'):
    text('Top 5 Songs in the USA in the past week (via Spotify)')
with tag('table', klass='table table-striped table-hover'):
    with tag('tbody'):
        with tag('tr'):
            with tag('th'):
                text('No.')
            with tag('th'):
                text('')
            with tag('th'):
                text('Artist(s)')
            with tag('th'):
                text('Song Title')
            with tag('th'):
                text('')
            for i, track in enumerate(trending_tracks):
                num = i + 1
                track_name, track_artist_string, track_link, track_album_art_link = track
                with tag('tr'):
                    with tag('td'):
                        text(num)
                    with tag('td'):
                        doc.stag('img', src=track_album_art_link, width=52)
                    with tag('td'):
                        text(track_artist_string)
                    with tag('td'):
                        text(track_name)
                    with tag('td'):
                        with tag('a', klass='btn btn-primary', href=track_link, target='_blank'):
                            text('Link')
html = doc.getvalue()
print('[spotify] Posting to widget...')
post = dashboard.post_to_widget('spotify', html)
print(post)