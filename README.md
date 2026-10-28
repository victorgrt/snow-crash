Team project of vgoret and yookyeoc

## VM setting for ssh connection

1. Open snow crash iso as 64 bits as the subject demands

2. Run the snow crash vm and enter the default password

3. ip addr to check the vm ip

4. Turn off the vm and manage network advanced setting as 
name : SSH
protocol : TCP
host IP : 127.0.0.1
host port : 4242
guest IP : 10.0.2.15 (which found inside vm)
guest port : 4242

5. If host key need to be deleted for the reconnection 
```
ssh-keygen -R '[127.0.0.1]:4242'
```

6. connect on local terminal via ssh 
```
ssh level00@127.0.0.1 -p 4242
```

## How to advance on the levels

```
su flag00 
(and enter the password found)
getflag (get the token and the user is changed to flag00)
su level01
(and enter the token you got as the password for user level01)
```

## tool
https://www.dcode.fr/caesar-cipher
John the Ripper
Wireshark
ghidra 
https://dogbolt.org