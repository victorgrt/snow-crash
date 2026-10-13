▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▓▓▌▐▓▓▌ 
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌ ▐▓▌ 
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌   ▐▓▌▐▓▌ ▐▓▌ 
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌ ▐▓▌ 
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▌

exploit: decrypt hashed password using John The Ripper

=======
We have no file in level02 and no permission for flag01. We must look elsewhere.

Let's look at a specific file: /etc/passwd (The /etc/passwd file is a plain-text database that stores local user account metadata on Unix-like operating systems) and we find:
flag01:42hDRfypTqqnw:3001:3001::/home/flag/flag01:/bin/bash

During level00 we saw an executable called john (John The Ripper) so let's try that. 
To do that let's '''echo '42hDRfypTqqnw' > password.txt'''
john --show password.txt
?:abcdefg
1 password hash cracked, 0 left

It is indeed the password of flag01.
