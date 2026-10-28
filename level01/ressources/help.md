# Level 01

**Exploit:** Offline password hash cracking

The password hash in `/etc/passwd` can be cracked offline to recover the login password for `flag01`.

## Walkthrough

There is no useful file in the level directory, so inspect `/etc/passwd`. On this system, it contains the following account entry:

```text
flag01:42hDRfypTqqnw:3001:3001::/home/flag/flag01:/bin/bash
```

The second field is a password hash. The `/usr/sbin/john` executable found in level 00 identifies John the Ripper as the intended tool. Install John outside the VM, save the hash to `password.txt`, and run:

```bash
john password.txt
john --show password.txt
```

Output:

```text
?:abcdefg
1 password hash cracked, 0 left
```

Use the recovered password to switch to `flag01`, then run `getflag`.
