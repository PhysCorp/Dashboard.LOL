import os

ignored_files = ["api.py", "reload-all-apps.py"]

for item in os.listdir(os.path.join("widgets")):
    # if the file is a python file and not in the ignored_files list
    if item.endswith(".py") and item not in ignored_files:
        os.system("python widgets/" + item)