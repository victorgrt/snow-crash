# Level00

**Exploit:** Caesar cipher

The stored string is shifted through the alphabet; reversing the shift reveals the password for `flag00`.

## Walkthrough

Find files owned by `flag00`:

```bash
find . / -user flag00
```

to see it clearly without stderr(here permission denied) from terminal to /dev/null:

```bash
find . / -user flag00 2>/dev/null
```

The search finds:

```text
/rofs/usr/sbin/john
/usr/sbin/john
```

The file contains the string `cdiiddwpgswtgt`. It does not look like a hash, so test whether it is a Caesar cipher.

In a Caesar cipher, each letter is shifted by a fixed number of positions. For example:

```text
Key: -2
Original: helloworld
Encoded:  fcjjmumpjb
```

The string decodes to `nottoohardhere`. A [Caesar cipher decoder](https://www.dcode.fr/caesar-cipher) can confirm the result.

Use the recovered password to switch to `flag00`, then run `getflag`.
