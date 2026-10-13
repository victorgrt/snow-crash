▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▌ ▐▓▌▐▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌    ▐▓▌ ▐▓▌▐▓▌
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌    ▐▓▌ ▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌    ▐▓▌    ▐▓▌
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▌   ▐▓▌

exploit: binary gdb injection

=====
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

