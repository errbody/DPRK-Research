from io import BytesIO
from base64 import b64decode
from Crypto.Cipher import AES
from Crypto.Protocol.KDF import PBKDF2

def aes_decrypt(bytes_content, password="pa55w0rd"):
    input_stream = BytesIO(bytes_content)
    output_stream = BytesIO()

    salt = input_stream.read(32)
    if len(salt) != 32:
        exit()

    pbkdf2 = PBKDF2(password, salt, dkLen=48, count=1000)
    aes_key = pbkdf2[:32]
    aes_iv = pbkdf2[32:]
    
    cipher = AES.new(aes_key, AES.MODE_CBC, aes_iv)
    decrypted_bytes = cipher.decrypt(input_stream.read())
    output_stream.write(decrypted_bytes)

    return output_stream.getvalue()

path = "./step1/info_ps.bin"

data = open(path, "rb").read()
decrypted_data = aes_decrypt(data)
f = open(path + ".dec", "wb")
f.write(decrypted_data)
f.close()
