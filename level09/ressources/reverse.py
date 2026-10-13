#!/usr/bin/env python

hex_string = "66 34 6b 6d 6d 36 70 7c 3d 82 7f 70 82 6e 83 82 44 42 83 44 75 7b 7f 8c 89"
hex_bytes = hex_string.split(" ")
position = 0

for byte in hex_bytes:
    # convert to decimal + reverse the shift by sub the position
    decimal = int(byte, 16) - position
    position += 1
    
# convert to ascii
    converted_character = chr(decimal)
    print(converted_character, end="")
print("\n")
