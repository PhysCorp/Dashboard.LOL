import os

cwd = os.path.dirname(os.path.realpath(__file__))

ignored_files = ["api.py", "reload-all-apps.py", "dashboard.py"]

for item in os.listdir(os.path.join(cwd, "widgets")):
    # if the file is a python file and not in the ignored_files list
    if item.endswith(".py") and item not in ignored_files:
        os.system("python3 \"" + os.path.join(cwd, "widgets", item) + "\"")