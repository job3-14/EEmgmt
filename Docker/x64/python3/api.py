from flask import Flask, request
import requests, json

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
    return "200"
app.run(debug=False, host='0.0.0.0', port=5000)
