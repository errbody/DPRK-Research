'''
Safety Manager JD (General Dynamics HR Division II).jse
8346D90508B5D41D151B7098C7A3E868
Automation Manager JD(LM HR II).scr
AA8936431F7BC0FABB0B9EFB6EA153F9
Job Description (LM HR Division II).pdf.scr
73D2899AADE924476E58ADDF26254C2E
'''

import base64
from Crypto.Cipher import ARC4

def decrypt_cmd(data):
    data = data.replace('-', '+').replace('?', '/')
    key = b"RGdcsedfd@#%dg9ser3$#$^@34sdfxl"
    decode_cmd = base64.b64decode(data)
    rc4 = ARC4.new(key)
    ret = rc4.decrypt(decode_cmd)
    
    cmd = ret[:4][0]
    if len(ret) > 4:
        arg = ret[4:].replace(b"\x00", b"")
    return cmd, arg

def decrypt_send_data(data):
    data = data.replace('-', '+')
    key = [0x6C, 0x78, 0x24, 0x22, 0x31, 0x26, 0x20, 0x23, 0x22, 0x07, 0x6B, 0x6C, 0x2E, 0x2C, 0x75, 0x3E, 0x2B, 0x3D, 0x63, 0x75, 0x71, 0x77, 0x0A, 0x15, 0x65, 0x63, 0x2B, 0x3D, 0x3C, 0x23, 0x30] 
    for i in range(len(key)):
        key[i] ^= 0x3E + i
    key = bytes(key)
    decode_cmd = base64.b64decode(data)
    rc4 = ARC4.new(key)
    ret = rc4.decrypt(decode_cmd).replace(b"\x00", b"")
    #ret = rc4.decrypt(decode_cmd)
    return ret

# Example
base64_send_data = "cHkboS/GEjgHDEz7P1JseR9uSi07xOohsHWuqygjZh8kfrYs4nMbSGgKGgllYFB1Iu-WheYTgB3SVP9GWMQOQy7GkGuPPNqGqtNg4pi5fh8-KKozxxYymLlsztsRE0lYrm8Ut5ni8VzlCO8X1Ruxz5N0R0LWpVlyOZW34OAbu4IX0QYwvX6ZRM2zPiYh6h4hWb9ngmdHrCsd141NquMM006jxdMgIMaDO6yh/Ek8HSiGmpQc0WXz2nvj0/wfBOxX9xdZxtnK/YZXKz8p0vfySBVIporr5ViiC4G3I0ZPHcPSHXC2RpkpjpmNd6QGyZcRuGihkIncps8J0DDQHZvzAXJEkyKb2kmmHZ6X-UVxPTxSTm3JoebG90U-Jl2p5kuPCa6aP4JcZ4ACifuFJD1t09D1MBnBheyIWyevFUKI/DZmZoONXflGBkdmlFvL7jrj/AAPS82ITFKF8QWYDAHbjzpZqtICtxNd4jQmmDMVg67JqGHxpIDn3BwN6waV7v4JRjagm1T9sh0hB9wDzXze0WRnc7hIqNgBaFONqsNxnRKV28iy9J1i0gPFjHqZpv6sQDoUZuvwtCGzFgbvEhGHnMpQM9Be0h7AgaKg9-Eu72qOOl-uP7c="
data = decrypt_send_data(base64_send_data)
print(data)

base64_cmd = "Ynl2oS/GHDgbDEv7IFJheUJuWy0/xOkh-XXgq2wjNR9wfuQs4nNNSCUK"
cmd, arg = decrypt_cmd(base64_cmd)
print("command : %s" % chr(cmd))
print("args : %s" % str(arg))