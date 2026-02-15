# CMPE-272 Enterprise Software Platforms

## Manual Prerequisites

### 1. GCP VM Setup
- Create a new VM instance in Google Cloud Platform:
  - Machine type: e2-micro (1 vCPU, 1GB RAM)
  - Region: us-west1
  - Image: Container Optimized OS (COS)

### 2. Static External IP
- Go to VPC Network > IP addresses.
- Find the ephemeral external IP assigned to your VM.
- Click "Promote to static" to reserve it as a static IP.

### 3. Firewall Rules
- Edit your VM instance.
- Check both "Allow HTTP traffic" and "Allow HTTPS traffic".
- This will assign the `http-server` and `https-server` network tags.

### 4. Cloudflare DNS & SSL
- In your Cloudflare dashboard, add an A record pointing your domain to the static external IP.
- Enable the Cloudflare proxy (orange cloud ON).
- Set SSL/TLS mode to "Full (Strict)".

### 5. GCP Budget Alert
- In the GCP Billing dashboard, create a budget alert for $1.00 to monitor costs.

---

## Lightweight Migrations (Phinx)

Phinx is set up as a stand-alone migration tool via Composer. The configuration file (`phinx.php`) uses environment variables for database connection details.

### Install Phinx

Phinx is a production dependency (required for running migrations on deploy). Run:
```
composer install
```

### Configuration

See `phinx.php` for environment-based DB settings.

### Running Migrations

To run migrations inside the PHP container:
```
docker compose exec php-fpm vendor/bin/phinx migrate
```

---

## Frontend

The landing page uses **Pico.css**, a classless CSS framework loaded from CDN:

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
```

**Why Pico.css:**
- No custom CSS files to maintain
- Semantic HTML is automatically styled
- Responsive out of the box
- Supports light/dark themes via `data-theme` attribute

**Usage:**
- Use semantic HTML elements (`<article>`, `<header>`, `<footer>`, `<table>`, `<mark>`)
- No class names needed for basic styling
- See `public/index.php` for example

---

## CI/CD Pipeline

The project uses GitHub Actions for automated builds and deployments. The workflow triggers on Git tags.

### How It Works

1. **Trigger**: Push any tag (e.g., `1.0.0`). The workflow is configured to only execute the build and deploy jobs when a tag is pushed.
2. **Build**: Creates production Docker images with code baked in
3. **Push**: Uploads images to GitHub Container Registry (GHCR)
4. **Deploy**: SSHs into GCP VM, pulls images, restarts services
5. **Migrate**: Automatically runs Phinx migrations

### Required GitHub Secrets

Add these secrets in your repository settings (Settings > Secrets and variables > Actions):

| Secret | Description |
|--------|-------------|
| `VM_HOST` | GCP VM static external IP address |
| `VM_USERNAME` | SSH username (usually your GCP username) |
| `SSH_PRIVATE_KEY` | Private SSH key for VM access |
| `DB_USER` | Database username |
| `DB_PASSWORD` | Database password |

> Note: `GITHUB_TOKEN` is automatically provided by GitHub Actions.

### Quick Guide: Obtaining Credentials

#### 1. How to get `VM_USERNAME`
The username is typically your GCP account name (before the `@gmail.com`). However, **you can use any username you want** as long as it matches the prefix you use when adding the SSH key to GCP metadata.

To verify your current username:
- SSH into the VM via the GCP Console.
- Running the command: `whoami`

#### 2. How to get `SSH_PRIVATE_KEY`
You need to generate an SSH key pair and add the public key to GCP.

**On your local machine:**
1. Generate a key pair:
   ```bash
   ssh-keygen -t ed25519 -f ./github-actions-deploy-key -C "github-actions-deploy"
   ```
> The `-C` (comment) parameter is the username that will be associated with the public key.
2. Get the **Public Key** content:
   ```bash
   cat ./github-actions-deploy-key.pub
   ```
3. Get the **Private Key** content (this is your `SSH_PRIVATE_KEY` secret):
   ```bash
   cat ./github-actions-deploy-key
   ```

**In GCP Console:**
1. Navigate to **Compute Engine > Metadata**.
2. Click on the **SSH Keys** tab.
3. Click **Add SSH Key** and paste the content of your **Public Key** (`github-actions-deploy-key.pub`).
4. Ensure the `VM_USERNAME` secret in GitHub matches exactly what you put here.

### Triggering a Release

```bash
# Create and push a tag
git tag 1.0.0
git push origin 1.0.0

# Or create and push in one command
git tag 1.0.0 && git push --tags
```

### Local Development vs Production

| Environment | Command | Behavior |
|-------------|---------|----------|
| Development | `docker compose up -d` | Code mounted via volumes, live reload |
| Production | `docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d` | Code baked into images |

### Environment Variables

| Variable | Default | Description |
|----------|---------|-------------|
| `BUILD_TARGET` | `development` | Dockerfile target (`development` or `production`) |
| `IMAGE_REGISTRY` | `local` | Container registry (e.g., `ghcr.io/username/repo`) |
| `IMAGE_TAG` | `latest` | Image tag (e.g., `v1.0.0`) |

---

## GCP VM Initial Setup

After creating the VM, SSH in and run:

```bash
# Create app directory
mkdir -p ~/app
cd ~/app

# Create docker-compose files (copy from repo or clone)
# Create .env file with production values
cat > .env << EOF
DB_USER=your_db_user
DB_PASSWORD=your_secure_password
REPO_URL=https://github.com/ianbunag/cmpe-272-enterprise-software-platforms
EOF
```
