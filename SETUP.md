# Setup Guide

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
- Check **Allow HTTP traffic**.
- This assigns the `http-server` and `https-server` network tags.

### 4. Cloudflare DNS & SSL
- In your Cloudflare dashboard, add an **A record** pointing your domain to the `VM_HOST` IP.
- Enable the Cloudflare proxy (orange cloud **ON**).
- Create a **Configuration Rule** to apply Flexible SSL only to this record:
    - Navigate to **Rules > Overview**.
    - Click **Create rule**.
    - **Rule name**: "Flexible SSL for yourdomain.com" (or your chosen name).
    - **If incoming requests match…**:
        - Select `Custom filter expression`
    - **When incoming requests match…**
        - Field: `Hostname`
        - Operator: `equals`
        - Value: `yourdomain.com`
    - **Then the settings are…**:
        - Search for **SSL** and set it to **Flexible**.
    - Click **Save**.

### 5. GCP Budget Alert
- In the GCP Billing dashboard, create a budget alert for **$1.00** to monitor costs.

---

## Phase 2: Server Configuration (One-Time Setup)

SSH into your VM via the GCP Console or your local terminal to prepare the environment.

### 1. Create the App Directory and Docker Compose Wrapper
The application files reside in `/var/lib/app`. Since COS may prevent binary execution on writable partitions, we use a wrapper script that runs Docker Compose inside a container.

```bash
sudo mkdir -p /var/lib/app
sudo chown $USER:docker /var/lib/app
sudo chmod 2775 /var/lib/app

# Create the wrapper script
cat > /var/lib/app/docker-compose << 'EOF'
#!/bin/bash
# Wrapper to run docker-compose in a container
# Inherits all shell environment variables and the .env file

# 1. Load the .env file if it exists
ENV_FILE="/var/lib/app/.env"
ENV_OPTS=""
if [ -f "$ENV_FILE" ]; then
  ENV_OPTS="--env-file $ENV_FILE"
fi

# 2. Inherit all current shell variables
# This generates a list of -e VAR1 -e VAR2 for every variable in the shell
INHERIT_VARS=$(env | cut -d= -f1 | sed 's/^/-e /' | tr '\n' ' ')

docker run --rm \
  -v /var/run/docker.sock:/var/run/docker.sock \
  -v /var/lib/app:/var/lib/app \
  -v "$PWD":"$PWD" \
  -w "$PWD" \
  $ENV_OPTS \
  $INHERIT_VARS \
  docker/compose:alpine-1.29.2 "$@"
EOF

# Make it executable
chmod +x /var/lib/app/docker-compose
```

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
