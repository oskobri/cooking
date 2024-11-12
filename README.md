

# Services

## Laravel Pulse

### Supervisor install  
```bash
sudo apt install supervisor  
```

### Configuration File
```bash
sudo vi /etc/supervisor/conf.d/laravel-pulse.conf

[program:laravel-pulse]
command=/usr/bin/php /<project_path>/artisan pulse:check
autostart=true
autorestart=true
user=www-data
stderr_logfile=/var/log/laravel-pulse.err.log
stdout_logfile=/var/log/laravel-pulse.out.log
```

### Reload the configuration
```bash
sudo supervisorctl reread
sudo supervisorctl update
```

### Start the process
```bash
sudo supervisorctl start laravel-pulse
```

### Managing the Process
#### Check the process status
```bash
sudo supervisorctl status laravel-pulse
```

#### Restart the process
```bash
sudo supervisorctl restart laravel-pulse
```

#### Stop the process
```bash
sudo supervisorctl stop laravel-pulse
```

### Show logs
```bash
tail -f /var/log/laravel-pulse.out.log
```
