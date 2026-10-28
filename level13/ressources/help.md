# Level13

**Exploit:** GDB register spoofing to bypass a UID check

Changing `EAX` while the program runs makes its UID check see the expected user ID.

## basic inspection

ls and we have level13 file verify what we have with 

```
file level13
```
it is an ELF 

Just execute it by

./level13 

or

```gdb
gdb -q level13
(gdb) run
Starting program: /home/user/level13/level13 
UID 2013 started us but we we expect 4242
[Inferior 1 (process 2468) exited with code 01]
```
So the subject itself is shouting out to set UID as 4242, we gdb main disas and see where to do that


## Walkthrough

so lets gdb it 
```
gdb level13
disas main
```

we get this : 

  0x0804858c <+0>:	push   %ebp
  0x0804858d <+1>:	mov    %esp,%ebp
  0x0804858f <+3>:	and    $0xfffffff0,%esp
  0x08048592 <+6>:	sub    $0x10,%esp
  0x08048595 <+9>:	call   0x8048380 <getuid@plt>
  0x0804859a <+14>:	cmp    $0x1092,%eax
  0x0804859f <+19>:	je     0x80485cb <main+63>
  0x080485a1 <+21>:	call   0x8048380 <getuid@plt>
  0x080485a6 <+26>:	mov    $0x80486c8,%edx
  0x080485ab <+31>:	movl   $0x1092,0x8(%esp)
  0x080485b3 <+39>:	mov    %eax,0x4(%esp)
  0x080485b7 <+43>:	mov    %edx,(%esp)
  0x080485ba <+46>:	call   0x8048360 <printf@plt>
  0x080485bf <+51>:	movl   $0x1,(%esp)
  0x080485c6 <+58>:	call   0x80483a0 <exit@plt>
  0x080485cb <+63>:	movl   $0x80486ef,(%esp)
  0x080485d2 <+70>:	call   0x8048474 <ft_des>
  0x080485d7 <+75>:	mov    $0x8048709,%edx
  0x080485dc <+80>:	mov    %eax,0x4(%esp)
  0x080485e0 <+84>:	mov    %edx,(%esp)
  0x080485e3 <+87>:	call   0x8048360 <printf@plt>
  0x080485e8 <+92>:	leave  
  0x080485e9 <+93>:	ret    

or we can copy the file on local and inspect it on Ghidra (or https://dogbolt.org as you prefer)

to copy to local :
```
scp -P 4242 level13@127.0.0.1:level13 .
```

Decompiled main on Ghidra :

```
void main(void)

{
  __uid_t _Var1;
  undefined4 uVar2;
  
  _Var1 = getuid();
  if (_Var1 != 0x1092) {
    _Var1 = getuid();
    printf("UID %d started us but we we expect %d\n",_Var1,0x1092);
                    /* WARNING: Subroutine does not return */
    exit(1);
  }
  uVar2 = ft_des("boe]!ai0FB@.:|L6l@A?>qJ}I");
  printf("your token is %s\n",uVar2);
  return;
}
```

So we can see briefly by the phrase that UID is expected to a value 0x1092 and if its the case we will get the token printed on our terminal

Let's see more precisely 

getuid() gets the process UID and store it in eax

compare if the stored value in eax is 0x1092
tip - how we convert easily hexa to see what is this in decimal ? 
```
(gdb) p/d 0x1092
$1 = 4242
```

so if UID matches to 4242 call ft_des(), reading the code we can know that it would be a way to give us uVar2, which would be a decoded token from the string given to ft_des

```
  0x08048595 <+9>:	call   0x8048380 <getuid@plt>
  0x0804859a <+14>:	cmp    $0x1092,%eax
  0x0804859f <+19>:	je     0x80485cb <main+63>
```

So what can be treated here? How do we reach to call the ft_des?

let's look at getuid() 
<getuid@plt> @plt means Procedure Linkage Table which means, its called by a Dynamically linked library
During GDB, we can set the eax value so to verify what happens
so.. if we stop just after calling getuid() 
we can 
```
set $eax = 4242
```
and see if the result changes

## in summary

Start the program in GDB, stop inside `main`, and set `EAX` to the expected UID before continuing:

```gdb
gdb level13
  b*main+14
  r
  set $eax = 4242
  c
```

```gdb
gdb -q level13
break getuid
run
finish
set $eax=4242
continue
```
just to show more directly that after getuid we change the expected saved value.. same work