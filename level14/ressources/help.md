# Level14

**Exploit:** GDB bypass of ptrace and UID checks / extracting the token by static analysis

In GDB, make the `ptrace` check succeed and set `getuid` to return `3014`, the UID expected by `getflag`.

## Static anylysis - token extracting using ft_des() in getflag

We don't see a specific elf file or other indices, lets go through getflag itself.


level14@SnowCrash:~$ gdb -q getflag
Reading symbols from /bin/getflag...(no debugging symbols found)...done.

or 

level14@SnowCrash:~$ which getflag
/bin/getflag

as it's a command and enrolled in PATH, 
lets get the file and decompile : 

```
scp -P 4242 level14@127.0.0.1:/bin/getflag .
```

Okay so we got the getflag main decompiled with many if and elses. 
Which branch would be concerned for level14, more precisely flag14?
to verify, lets
```
level14@SnowCrash:~$ id flag14
uid=3014(flag14) gid=3014(flag14) groups=3014(flag14),1001(flag)

```
so it is 3014. and in hexa ? 
(gdb) p/x 3014
$1 = 0xbc6

else {
if (_Var6 != 0xbc6) goto LAB_08048e06;
pcVar4 = (char *)ft_des("g <t61:|4_|!@IF.-62FH&G~DCK/Ekrvvdwz?v|");
fputs(pcVar4,__stream);
}

so a certain string need to be decoded by the function we already saw and which was internally used on level13
ft_des()

ft_des() function we re-write it in a way to be compiled, mostly unchanged just some variable types such as byte to unsigned char, changing ghidra defined variable to char*, adding (0) after a return, void main(void) to int main(void).. 

And we re use the UID checking main part of level13, without using the check specific conditions, so to directly decode the token from our specific target string for level14. 

We gcc, check if the adjusted c code decoder works correctly(check if its correct by comparing with other level that we already know it works), and it works perfectly.

## Runtime anylisis - GDB bypass 

The target account's UID is `3014`. Start `getflag` in GDB, bypass the `ptrace` check, then change the `getuid` result:


first disas main in gdb
0x08048989 <+67>:	call   0x8048540 <ptrace@plt>
0x0804898e <+72>:	test   %eax,%eax
0x08048990 <+74>:	jns    0x80489a8 <main+98> // if ptrace returns 0 then enters the other part of the main

0x08048afd <+439>:	call   0x80484b0 <getuid@plt> // so this program looks at users UID
0x08048b02 <+444>:	mov    %eax,0x18(%esp)
0x08048b06 <+448>:	mov    0x18(%esp),%eax

0x08048bab <+613>:	cmp    $0xbc5,%eax //3013
0x08048bb0 <+618>:	je     0x8048dc4 <main+1150>
0x08048bb6 <+624>:	cmp    $0xbc6,%eax //3014
0x08048bbb <+629>:	je     0x8048de5 <main+1183> // if 3014 jump here

0x08048de5 <+1183>:	mov    0x804b060,%eax
0x08048dea <+1188>:	mov    %eax,%ebx
0x08048dec <+1190>:	movl   $0x8049220,(%esp)
0x08048df3 <+1197>:	call   0x8048604 <ft_des> // decode the 0x8049220 string by ft_des
0x08048df8 <+1202>:	mov    %ebx,0x4(%esp)
0x08048dfc <+1206>:	mov    %eax,(%esp)
0x08048dff <+1209>:	call   0x8048530 <fputs@plt> // token giving phrase



```gdb
gdb -q getflag
catch syscall ptrace
run
info registers eax
continue
info registers eax
set $eax=0
p/d $eax
break getuid
continue
finish
p/d $eax
set $eax=3014
p/d $eax
continue

```
level14@SnowCrash:~$ gdb -q /bin/getflag
Reading symbols from /bin/getflag...(no debugging symbols found)...done.
(gdb) set disassembly-flavor intel
(gdb) catch syscall ptrace
Catchpoint 1 (syscall 'ptrace' [26])
(gdb) run
Starting program: /bin/getflag 

Catchpoint 1 (call to syscall ptrace), 0xb7fdd428 in __kernel_vsyscall ()
(gdb) info registers eax
eax            0xffffffda	-38
(gdb) continue
Continuing.

Catchpoint 1 (returned from syscall ptrace), 0xb7fdd428 in __kernel_vsyscall ()
(gdb) info registers eax
eax            0xffffffff	-1
(gdb) 
```
understanding : 

(gdb) catch syscall ptrace 
- stop the execution when the program call systemcall ptrace or return
- just before entering ptrace system call
run it
- eax that it shows as -38 is before ptrace return
continue it
- from Catchpoint 1 returned, its -1, ptrace fail

```
(gdb) set $eax=0
(gdb) p/d $eax
$1 = 0
```

- we set ptrace return to a success value 0, so that the program doesn't see as a failure

```
(gdb) break getuid
Breakpoint 2 at 0xb7ee4cc0
(gdb) continue
Continuing.
```

- set breakpoint at getuid

```
Breakpoint 2, 0xb7ee4cc0 in getuid () from /lib/i386-linux-gnu/libc.so.6
(gdb) finish

Run till exit from #0  0xb7ee4cc0 in getuid () from /lib/i386-linux-gnu/libc.so.6
```
- finish so that program executes till getuid returns
```
0x08048b02 in main ()
(gdb) p/d $eax
$2 = 2014
(gdb) set $eax=014
(gdb) set $eax=3014
(gdb) p/d $eax
$3 = 3014
(gdb) continue
Continuing.
Check flag.Here is your token : 7QiHafiNa3HVozsaXkawuYrTstxbpABHD8CPnHJ
[Inferior 1 (process 2146) exited normally]
(gdb) 
```
check the getuid() return value and change it to 3014 and it gives the token