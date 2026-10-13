▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▓▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌▐▓▌
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌   ▐▓▌▐▓▌▐▓▌▐▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌▐▓▌
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌

exploit: cezar cypher

=======
Using the following command ```find . / -user flag00''' we can find all files where flag00 has access. 
We find the following:
/rofs/usr/sbin/john
/usr/sbin/john

And when inspecting the content we get '''cdiiddwpgswtgt'''

It doesn't look like a hash and because we are in early levels we can guess that it is probably something like a simple cezar cypher.
Reminder of what cezar cypher is:
Key: +2
Original: helloworld
Hashed:   fcjjmumpjb

It is easily reverseable but let's use the following website:
https://www.dcode.fr/caesar-cipher

We get the following: '''nottoohardhere'''
It works to su flag00 and we can get the flag.
