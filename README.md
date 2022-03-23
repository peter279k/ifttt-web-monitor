# ifttt-web-monitor

## Usage

- Ensure that PHP is installed and the PHP cURL extension already has been enabled.
- Or using the Python 3 progame and ensure python3 is available on targted machine.
- Clone the repository with the `git` command.
- Create the `settings.txt` file and its format can be referenced by `settings.txt.example` file.
- Set the Cronjob with the `crontab` command and run `monitor.php` program every 5 minutes.

## Cronjob setting

```Bash
*/5 * * * * cd /root/ifttt-web-monitor && export TZ=Asia/Taipei && php monitor.php
```

```Bash
*/5 * * * * cd /root/ifttt-web-monitor && export TZ=Asia/Taipei && python3 monitor.py
```
