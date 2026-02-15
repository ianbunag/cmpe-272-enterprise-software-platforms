# Setup Guide: CMPE-272 Enterprise Software Platforms

This guide will walk you through setting up your hosting and web programming environment from scratch. Following these steps in order will result in a fully functional, publicly accessible application with automated CI/CD.

## Phase 1: Infrastructure (Manual GCP Setup)

### 1. GCP VM Setup
- Create a new VM instance in Google Cloud Platform:
  - Machine type: `e2-micro` (1 vCPU, 1GB RAM)
  - Region: `us-west1`
  - Image: **Container-Optimized OS (COS)**

### 2. Static External IP
- Navigate to **VPC Network > IP addresses**.
- Locate the ephemeral external IP assigned to your VM.
- Click **Promote to static** to reserve it. Note this IP; it will be your `VM_HOST`.

### 3. Firewall Rules
- Edit your VM instance.
- Check both **Allow HTTP traffic** and **Allow HTTPS traffic**.
- This assigns the `http-server` and `https-server` network tags.

### 4. Cloudflare DNS & SSL
- In your Cloudflare dashboard, add an **A record** pointing your domain to the `VM_HOST` IP.
- Enable the Cloudflare proxy (orange cloud **ON**).
- Set SSL/TLS mode to **Full (Strict)**.

### 5. GCP Budget Alert
- In the GCP Billing dashboard, create a budget alert for **$1.00** to monitor costs.

---

## Phase 2: Server Configuration (One-Time Setup)

SSH into your VM via the GCP Console or your local terminal to prepare the environment.

### 1. Create the App Directory
The application is deployed to a central directory for group access.
```bash
sudo mkdir -p /var/lib/app
sudo chown $USER:docker /var/lib/app
sudo chmod 2775 /var/lib/app
```
*Note: The `2` in `2775` is the setgid bit, ensuring new files inherit the `docker` group.*

### 2. Create the Production Environment File
```bash
cat > /var/lib/app/.env << EOF
DB_USER=your_db_user
DB_PASSWORD=your_secure_password
REPO_URL=https://github.com/your-username/your-repo
EOF
chmod 660 /var/lib/app/.env
```

### 3. Configure Deployment User
Ensure the user used for SSH deployment is in the `docker` group. Replace `VM_USERNAME` with your intended deployment username.
```bash
sudo usermod -aG docker VM_USERNAME
```
*IMPORTANT: You must restart your SSH session or log out/in for this to take effect.*

---

## Phase 3: CI/CD Integration (GitHub Setup)

### 1. Generate SSH Keys
On your local machine, generate a key pair for the GitHub Actions runner.
```bash
ssh-keygen -t ed25519 -f ./DEPLOY_KEY -C "VM_USERNAME"
```
1. **Public Key**: Add the content of `DEPLOY_KEY.pub` to **GCP Console > Compute Engine > Metadata > SSH Keys**.
2. **Private Key**: Copy the content of `DEPLOY_KEY` for the GitHub Secret below.

### 2. Add GitHub Secrets
In your repository, go to **Settings > Secrets and variables > Actions** and add:

| Secret | Value |
|--------|-------|
| `VM_HOST` | The Static IP from Phase 1 |
| `VM_USERNAME` | The username from Phase 2, Step 3 |
| `SSH_PRIVATE_KEY` | The private key from Phase 3, Step 1 |
| `DB_USER` | The same `DB_USER` used in Phase 2, Step 2 |
| `DB_PASSWORD` | The same `DB_PASSWORD` used in Phase 2, Step 2 |

---

## Phase 4: Deploying a Version

Pushing a Git tag triggers the build and deployment.

```bash
# Tag the current commit
git tag 1.0.0

# Push the tag to GitHub
git push origin 1.0.0
```

Once the GitHub Action completes, your site will be live at your domain.

---

## General Technical Details

### Local Development
To run the environment locally:
```bash
docker compose up -d
```

### Migrations (Phinx)
Migrations are run automatically on deployment. To run them manually inside the container:
```bash
docker compose exec php-fpm vendor/bin/phinx migrate
```

### Frontend
The landing page uses **Pico.css** via CDN for a classless, semantic, and responsive UI.

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
