from flask import Flask, request
import requests, json
import smtplib
from email.mime.text import MIMEText
from email.header import Header

app = Flask(__name__)
@app.route('/sendMessage',methods=["POST"])
def sendMessage():
    postData=request.get_data()
    postData=json.loads(postData)
    if postData["method"]=="slack":
        slack={}
        slack["text"]=postData["text"]
        if "address1" in postData:
            requests.post(postData["address1"], data=json.dumps(slack))
        if "address2" in postData:
            requests.post(postData["address2"], data=json.dumps(slack))
        if "address3" in postData:
            requests.post(postData["address3"], data=json.dumps(slack))
        if "address4" in postData:
            requests.post(postData["address4"], data=json.dumps(slack))
        if "address5" in postData:
            requests.post(postData["address5"], data=json.dumps(slack))

    if postData["method"]=="email":
        message = MIMEText(postData["text"])
        message['Subject'] = Header(postData["subject"], 'utf-8')
        message['From'] = postData["fromEmail"]
        addressList = []
        i = 0
        if "address1" in postData:
            addressList.append(postData["address1"])
        if "address2" in postData:
            addressList.append(postData["address2"])
        if "address3" in postData:
            addressList.append(postData["address3"])
        if "address4" in postData:
            addressList.append(postData["address4"])
        if "address5" in postData:
            addressList.append(postData["address5"])
        for address in addressList:
            message['To'] = address
            with smtplib.SMTP_SSL('smtp.gmail.com') as smtp:
                smtp.login(postData["userid"], postData["password"])
                smtp.send_message(message)
    return "200"
app.run(debug=False, host='0.0.0.0', port=5000)
