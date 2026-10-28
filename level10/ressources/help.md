# Level10

**Exploit:** TOCTOU race condition (symlink race)

The program checks a file and opens it later; switching a symlink between those steps can make it open the protected `token` file.

## Walkthrough

Inspect the binary strings to identify the port it uses:

```bash
strings ./level10 token
```

Output:

```text
Connecting to %s:6969 .. 
```
The program connects to port `6969`, but no service is listening there. Start a listener with `nc`.

The permission check and file open happen at different times. `linker.sh` repeatedly switches a file between a regular file and a symlink to `token`, while `spammer.sh` repeatedly runs the vulnerable program. This creates a chance for the program to open `token` after checking a different file.

Use three SSH sessions. Start a listener in the first:

```bash
nc -lk 6969
```

Run the link-switching script in the second:

```bash
./linker.sh
```

Run the program repeatedly in the third:

```bash
./spammer.sh
```

When the race succeeds, the token contents appear in the listener session.
