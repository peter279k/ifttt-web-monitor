import os
import sys
import json
import datetime
import urllib.request


setting_path = './settings.txt'
if os.path.isfile(setting_path) is False:
    print(setting_path + ' is not found.')
    sys.exit(1)


with open(setting_path, 'r') as file_handler:
    settings = file_handler.readlines()
    if len(settings) != 2:
        print('settings lenght should be 2')
        sys.exit(1)
    monitored_url = settings[0][0:-1]
    maker_service_url = settings[1][0:-1]

    if monitored_url[0:4] != 'url=':
        print('url setting should begin with url=')
        sys.exit(1)
    if maker_service_url[0:24] != 'ifttt_maker_service_url=':
        print('IFTTT maker service url should begin with ifttt_maker_service_url=')
        sys.exit(1)

    response = urllib.request.urlopen(monitored_url[4:])
    if response.status == 200:
        print(monitored_url[4:] + ' website healthy is good!')
        sys.exit(0)

    request = urllib.request.Request(maker_service_url[24:])
    request.add_header('Content-Type', 'application/json; charset=utf-8')
    json_payload = {
        'date': datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
        'status': monitored_url[4:] + ' website is down!',
        'status_code': response.status,
    }
    jsondata = json.dumps(json_payload)
    json_data_bytes = jsondata.encode('utf-8') 
    request.add_header('Content-Length', len(json_data_bytes))
    response = urllib.request.urlopen(request, json_data_bytes)
    resp_text = response.readlines()

    if response.status == 200:
        print(resp_text[0].decode('utf-8'))
