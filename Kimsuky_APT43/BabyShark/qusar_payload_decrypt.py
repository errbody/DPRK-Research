import base64

def reorder_pieces_in_reverse(str, count):
    result_str = ""
    temp_str = ""
    result_str = str[:len(str) - (count - 1) * (int((len(str) / count)))]
    for i in range(count):
        start_idx = len(result_str)
        end_idx = int((len(str) / count)) + start_idx
        temp_str = str[start_idx:end_idx]
        result_str = temp_str + result_str
    return result_str

data = open("verify.DIC", "r").read()
decrypted = reorder_pieces_in_reverse(data, 10)
decode = base64.b64decode(decrypted)[::-1]

f = open("verify.DIC.dec", "wb")
f.write(decode)
f.close()