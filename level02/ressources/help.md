# Level02

**Exploit:** Credential recovery from a PCAP capture**

Following the captured TCP stream reveals the password entered during a login attempt.

## Walkthrough

Identify the capture format:

```bash
file level02.pcap
```

Output:

```text
level02.pcap: tcpdump capture file (little-endian) - version 2.4 (Ethernet, capture length 16777216)
```

The file contains captured network traffic.

Search the capture for readable login text:

```bash
strings ./level02.pcap
```

Output:

```text
wwwbugs login: @f&NV.
...
Password: Nf&Nat
....
Login incorrect
wwwbugs login: df&N
```

Copy the capture out of the VM so it can be examined with Wireshark:

```bash
scp -P 4242 level02@127.0.0.1:level02.pcap .
```

In Wireshark, select **Analyze > Follow > TCP Stream** to view the session. The captured password appears as `ft_wandr...NDRel.L0L`.

The dots represent non-printable bytes. Inspecting one shows hexadecimal `7f`, the ASCII delete character (DEL). Applying those delete characters reconstructs the password `ft_waNDReL0L`.

Use the recovered password to switch to `flag02`, then run `getflag`.
