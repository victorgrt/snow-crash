# Level 09

**Exploit:** Reverse engineering a position-based byte encoding

Each token byte is increased by its position; subtracting the position recovers the original password.

## Walkthrough

The encoding adds each character's position to its value. For example:

```text
index:     0  1  2  3  4  5
./level09  a  b  c  d  e  f
          +0 +1 +2 +3 +4 +5
result:    a  c  e  g  i  k
```


The token contains non-printable bytes, so inspect it in hexadecimal:

```bash
xxd token
```

Output:

```text
0000000: 6634 6b6d 6d36 707c 3d82 7f70 826e 8382  f4kmm6p|=..p.n..
0000010: 4442 8344 757b 7f8c 890a                 DB.Du{....
```

The dump includes byte values that cannot be displayed as ordinary text. The `reverse.py` script converts each value and subtracts its position to recover the password for `flag09`.
