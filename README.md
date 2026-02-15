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

# Lightweight Migrations (Phinx)

Phinx is set up as a stand-alone migration tool via Composer. The configuration file (phinx.php) uses environment variables for database connection details. A starter migration is provided to create a `students` table.

## Install Phinx

Run:
```
composer install --dev
```

## Configuration

See `phinx.php` for environment-based DB settings.

## Starter Migration

See `migrations/20260215000100_create_students_table.php` for the students table migration.

## Running Migrations

To run migrations inside the PHP container:
```
docker compose exec php-fpm vendor/bin/phinx migrate
```
