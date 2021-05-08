#!/bin/sh
php /data/start.php start -d &
sleep 2
exec tail -f /data/runtime/logs/app.log
