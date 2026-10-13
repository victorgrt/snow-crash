▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▓▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌▐▓▌
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌   ▐▓▌▐▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌   ▐▓▌
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌   ▐▓▌

exploit: reverse algo

=======
index:     0  1  2  3  4  5
./level09  a  b  c  d  e  f
          +0 +1 +2 +3 +4 +5
result:    a  c  e  g  i  k


cat token
f4kmm6p|=�p�n��DB�Du{��
There is some weird shit here so let's do:
xxd token
0000000: 6634 6b6d 6d36 707c 3d82 7f70 826e 8382  f4kmm6p|=..p.n..
0000010: 4442 8344 757b 7f8c 890a                 DB.Du{....

We have litteraly every bytes (66 -> 102 ascii -> "f")
So let's hardcode this shit because of the weird chars inside a scrip that first convversxtto decimal + reverse the shift of position and prints the result (see reverse.py).
Not the best script or most re-usable but it does the taff.
We get the password of flag09.
