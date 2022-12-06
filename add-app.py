import re
import requests

username = "mwcurtis"
password = "31013932"

# Ask user for internal name
internal_name = input("Internal name: ")

# Ask user for name
name = input("Full name: ")

# Ask user for description
description = input("Description: ")

# Ask user for rating
rating = input("Rating: ")

# Convert rating to double
rating = float(rating)

# # Strip all non-alphanumeric characters from description
# description = re.sub(r'\W+', '', description)

# # Convert all spaces in description to %20
# description = description.replace(" ", "%20")

# Use requests to visit http://127.0.0.1:8888/database/debug-add-widget.php with the following parameters:
# internal_name, display_name, description, rating

request = requests.get("http://127.0.0.1:8888/dashboard/debug-add-widget.php", params = {"internal_name": internal_name, "name": name, "description": description, "rating": rating}, data={"username": username, "password": password})

# Print the response
# print(request.text)