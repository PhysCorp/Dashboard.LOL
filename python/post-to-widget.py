# Imports
import requests
import os.path

# Main variables
url = "http://127.0.0.1:8888/dashboard/actions/cli/post.php"
username = "dashboard_agent"
password = "thedashboardliveson"
internal_name = []

# get the list of html files in ../private/widgets
for item in os.listdir(os.path.join("..", "private", "widgets")):
    # if the file is an html file
    if item.endswith(".html"):
        # add the file name to the internal_name list
        internal_name.append(item.replace(".html", ""))

for item in internal_name:
    # Write to console
    print("Posting " + item + " to widget...")

    # Data variables
    prepend_data = ""
    data = ""
    append_data = ""

    # Alternatively, uncomment these two lines to retrieve data from file input.txt
    with open(os.path.join("..", "private", "widgets", str(item + ".html")), "r") as f:
        data = f.read()

    # Combine data sources
    full_data = str(prepend_data) + str(data) + str(append_data)

    # Perform the POST request
    request = requests.post(url, data={"username": username, "password": password, "internal_name": item, "data": full_data})

    # Print the html response
    print(request.text)