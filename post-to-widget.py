# Imports
import requests
import os.path

# Main variables
url = "http://127.0.0.1:8888/dashboard/post.php"
username = "dashboard_agent"
password = "thedashboardliveson"
internal_name = ["stevewilson", "calculator", "dadjoke"]

for item in internal_name:
    # Write to console
    print("Posting " + item + " to widget...")

    # Data variables
    prepend_data = ""
    data = ""
    append_data = ""

    # Alternatively, uncomment these two lines to retrieve data from file input.txt
    with open(os.path.join("key", "widgets", str(item + ".php")), "r") as f:
        data = f.read()

    # Combine data sources
    full_data = str(prepend_data) + str(data) + str(append_data)

    # Perform the POST request
    request = requests.post(url, data={"username": username, "password": password, "internal_name": item, "data": full_data})

    # Print the html response
    print(request.text)
    