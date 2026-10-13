▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▌ ▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌    ▐▓▌ ▐▓▌▐▓▌
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌    ▐▓▌ ▐▓▌▐▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌    ▐▓▌ ▐▓▌▐▓▌
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▌▐▓▓▓▓▌

exploit: open / access race

=======
We have a file and a token.

strings ./level09 token
Connecting to %s:6969 .. 
We know that the program is trying to connect to this port but the port is not active in ss -tlnp.

I guess we have to emulate it using nc for exemple.

There is a mismatch in when the file gets opened versus the permission check. We can create a race condition that would buypass the permission check and give us the content of token.

For that we have to create two scripts: linker.sh and spammer.sh
linker.sh is going to delete, create and symbolic link with token.
Meanwhile we are going to have spammer.sh spam the program with the link so that eventually a race happens and we get to receive the content of token.

For that we need three terminal connected via ssh:
On the first let's launch nc -lk 6969
Then launch linker then finally spammer. Eventually we are going to receive the content of token in the nc -lk 6969 session.
