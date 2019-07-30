#from flask import Flask, request, jsonify
from flask import Flask, request, json, requests
app = Flask(__name__)
@app.route('/sendMessage',methods=["POST"])
def sendMessage():
    postData=request.get_data()
    postData=json.loads(postData)
    print(postData["name"])
    return request.get_data()
app.run()
