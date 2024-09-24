import base64
import zlib
import re

target_path = "323317721" # TestFile : EDFCABA39FE016EF22B01EF5F871733E
input_code = open(target_path, "r").read()
encoded_string = re.search(r"exec\(\(_\)\(b'([^']*)'\)\)", input_code).group(1)
decoded_string = base64.b64decode(encoded_string[::-1])
deocded = zlib.decompress(decoded_string)

cnt = 0
while True:
    cnt += 1
    encoded_string = re.search(r"exec\(\(_\)\(b'([^']*)'\)\)", deocded.decode('utf-8')).group(1)
    decoded_string = base64.b64decode(encoded_string[::-1])
    deocded = zlib.decompress(decoded_string)
    if deocded.find(b"import ") != -1:
        break
print("Total Count : %d" % cnt)
print(deocded)

f = open(target_path + ".dec.py", "wb")
f.write(deocded)
f.close()