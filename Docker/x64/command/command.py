import os
import subprocess
import time
path = "./signalfile.py"

while True:
    if os.path.exists(path):
        import signalfile
        if signalfile.command == "Shutdown":
            subprocess.check_output(["shutdown","-h","now"])
        elif signalfile.command == "Reboot":
            subprocess.check_output(["reboot"])
        else:
            os.remove(path)
    time.sleep(1)
