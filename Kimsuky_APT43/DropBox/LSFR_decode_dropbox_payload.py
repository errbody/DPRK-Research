def decode_binary(binary):
    poly = [0, 3, 29, 37, 73]  # polynomial
    poly_n = 4  # polynomial point num
    poly_ord = 73  # polynomial point num
    ran_state = bytearray(poly_ord + 1)
    length = len(binary)
    
    for i in range(poly_ord + 1):
        ran_state[i] = 1
        if i < length:
            ran_state[i] = (length % (i + 1)) & 1

    for i in range(length):
        for j in range(1, poly_n):
            ran_state[i % poly_ord] ^= ran_state[(i + poly[j]) % poly_ord]

        for j in range(8):
            binary[i] ^= ((ran_state[j] ^ (ran_state[(i * (j + 1)) % poly_ord] & ran_state[((i + j) * (j + 1)) % poly_ord])) << j)

    return binary

path = "sch.bin"

data = open(path, "rb").read()
out = decode_binary(list(data))
f = open(path + ".dec", "wb")
f.write(bytearray(out))
f.close()