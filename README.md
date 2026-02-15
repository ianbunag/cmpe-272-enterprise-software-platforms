# Manual Prerequisites

## 1. GCP VM Setup
- Create a new VM instance in Google Cloud Platform:
  - Machine type: e2-micro (1 vCPU, 1GB RAM)
  - Region: us-west1
  - Image: Container Optimized OS (COS)

## 2. Static External IP
- Go to VPC Network > IP addresses.
- Find the ephemeral external IP assigned to your VM.
- Click "Promote to static" to reserve it as a static IP.

## 3. Firewall Rules
- Edit your VM instance.
- Check both "Allow HTTP traffic" and "Allow HTTPS traffic".
- This will assign the `http-server` and `https-server` network tags.

## 4. Cloudflare DNS & SSL
- In your Cloudflare dashboard, add an A record pointing your domain to the static external IP.
- Enable the Cloudflare proxy (orange cloud ON).
- Set SSL/TLS mode to "Full (Strict)".

## 5. GCP Budget Alert
- In the GCP Billing dashboard, create a budget alert for $1.00 to monitor costs.

---

# Container Environment (Docker Compose)

A `docker-compose.yml` is provided to run Nginx (Alpine), PHP 8.3-FPM (Alpine), and MariaDB (Alpine) with memory limits and persistent storage. See below for details.

## docker-compose.yml

```
version: '3.8'
services:
  nginx:
    image: nginx:alpine
    container_name: nginx
    restart: unless-stopped
    ports:
      - "80:80"
    volumes:
      - ./nginx/default.conf:/etc/nginx/conf.d/default.conf:ro
      - ./public:/var/www/html:ro
    depends_on:
      - php-fpm

  php-fpm:
    image: php:8.3-fpm-alpine
    container_name: php-fpm
    restart: unless-stopped
    volumes:
      - ./public:/var/www/html:ro
      - ./php/custom.ini:/usr/local/etc/php/conf.d/custom.ini:ro
    environment:
      - DB_HOST=mariadb
      - DB_NAME=${DB_NAME}
      - DB_USER=${DB_USER}
      - DB_PASSWORD=${DB_PASSWORD}

  mariadb:
    image: mariadb:10.11.7-alpine
    container_name: mariadb
    restart: unless-stopped
    environment:
      - MYSQL_ROOT_PASSWORD=${DB_PASSWORD}
      - MYSQL_DATABASE=${DB_NAME}
      - MYSQL_USER=${DB_USER}
      - MYSQL_PASSWORD=${DB_PASSWORD}
    command: --innodb-buffer-pool-size=128M
    volumes:
      - db_data:/var/lib/mysql
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
      interval: 10s
      timeout: 5s
      retries: 5

volumes:
  db_data:
```

- Nginx and PHP-FPM use official Alpine images for minimal resource usage.
- MariaDB is limited to 128MB buffer pool for 1GB RAM compatibility.
- Database data is persisted in a Docker volume (`db_data`).
- Environment variables are used for database credentials.

## Nginx Configuration

Create `nginx/default.conf`:

```
server {
    listen 80;
    server_name _;
    root /var/www/html;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass php-fpm:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## PHP Configuration

Create `php/custom.ini`:

```
upload_max_filesize=8M
post_max_size=8M
memory_limit=256M
```
