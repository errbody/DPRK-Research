from Cryptodome.Cipher import AES
import hashlib

#aes_key = "rr 05-20 13-39-10.txt"
aes_key = "wirsvc" # Service Name OR Upload FileName

path = "filename.txt"
    

data = open(path, "rb").read()
initial_counter = data[:16]
data = data[16:]

phrase = aes_key.encode("utf16")[2:]
key = hashlib.sha256(phrase).digest()

cipher = AES.new(key=key,initial_value=initial_counter,mode=AES.MODE_CTR,nonce=b'')
plain = cipher.decrypt(data)
print(plain)
print("\ndecrypted -> ")
try:
    f = open(path + ".dec", "wb")
    f.write(plain)
    f.close()
except:
    pass