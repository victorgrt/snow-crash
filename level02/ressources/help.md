▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▓▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌   ▐▓▌
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌   ▐▓▌▐▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌

exploit: tcp stream following

=======
We have a .pcap file. 
Let's try to understand what it is:
file level02.pcap 
level02.pcap: tcpdump capture file (little-endian) - version 2.4 (Ethernet, capture length 16777216)

strings ./level02.pcap reveals that there is data inside:
```
wwwbugs login: @f&NV.
...
Password: Nf&Nat
....
Login incorrect
wwwbugs login: df&N
```

We don't have any tool or program to help us installed on the VM so let's copy the file out of the vm:
scp -P 4242 level02@127.0.0.1:level02.pcap .

Now we can use a tool like wireshark to analyse it (don't forget to add the +r permission!)

Let's follow the TCP stream so that it is more readable:
Analyze -> Follow -> TCP Stream
We can see the followin:
Password: 
ft_wandr...NDRel.L0L

This in itself doesn't work for flag02. Those dots look weird let's check what it actually is. Selecting the dot lets us check the actual data and we have "7f". Converted to decimal it gives us 127 and 127 in the ASCII table is the DEL char.
It means that each dot is actually a delete char.
It gives us the following:
ft_waNDReL0L
