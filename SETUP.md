# Setup Guide

This guide will walk you through setting up your hosting and web programming environment from scratch. Following these steps in order will result in a fully functional, publicly accessible application with automated CI/CD.

The application requires the following components:
- Google Cloud Platform (GCP) to host the application.
- Cloudflare for DNS management, SSL, and CDN.
- GitHub to host the source code and run CI/CD automation.

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
- This assigns the `http-server` network tag.

### 4. GCP Budget Alert
- In the GCP Billing dashboard, create a budget alert for **$1.00** to monitor costs.

### 5. Cloudflare DNS & SSL
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

### 6. Cloudflare CDN
This section sets up an R2 object storage bucket to host your application assets. These assets will be served via the `IMAGE_HOST` URL.

#### 6.1 Create a Cloud Storage Bucket
In the Cloudflare dashboard:

1. Navigate to **Storage & databases > Overview**.
2. Click **Create bucket** and configure:
   - **Name**: Choose any name.
   - **Location**: Automatic.
   - **Default Storage Class**: Standard
   - Click **Create bucket**.

#### 6.2 Make Bucket Publicly Readable
To serve images publicly, create a Custom Domain:

1. Go to your newly created bucket.
2. Click the **Settings** tab.
3. Under **Custom Domains**, click **Add**
   - Enter your domain (e.g., `cdn.yourdomain.com`).

#### 6.3 Upload Assets to the Bucket
Upload the contents of each directory from your local `assets/cdn/` folder.

#### 6.5 Secure the Bucket

##### 6.5.1 Ensure Hotlink Protection is Enabled
1. In the Cloudflare dashboard, navigate to **Domains > Security > Settings > Hotlink Protection**.
2. Ensure that it is toggled **ON**.

##### 6.5.2 Ensure DDOS Protection is Enabled
1. In the Cloudflare dashboard, navigate to **Domains > Security > Security Rules > Network-layer and SSL/TLS DDoS attack > DDoS Mitigation**.
2. Ensure that **SSL/TLS DDoS attack protection** is toggled **ON**.
3. Ensure that **Network-layer DDoS attack protection** is toggled **ON**.

##### 6.5.3 Cache assets
1. In the Cloudflare dashboard, navigate to **Domains > Caching > Cache Rules**.
2. Click **Create rule** and configure:
   - **Rule name**: Your chosen name.
   - **If incoming requests match…**:
     - Select `Custom filter expression`
   - **When incoming requests match…**:
     - Field: `Hostname`
     - Operator: `equals`
     - Value: `cdn.yourdomain.com`
   - **Cache eligibility**:
     - Select `Eligible for cache`
   - **Edge TTL**:
     - Select `Ignore cache-control header and use this TTL`
     - Set `Input time-to-live (TTL) (required)` to `14 days`
   - **Browser TTL**:
     - Select `Override origin and use this TTL`
     - Set `Input time-to-live (TTL) (required)` to `7 days`
   - Click **Save**.

---

## Phase 2: Server Configuration (One-Time Setup)

SSH into your VM via the GCP Console or your local terminal to prepare the environment.

### 1. Create the App Directory and Docker Compose Wrapper
The application files reside in `/var/lib/app/cmpe-272`. Since COS may prevent binary execution on writable partitions, we use a wrapper script that runs Docker Compose inside a container.

```bash
sudo mkdir -p /var/lib/app/cmpe-272
sudo chown $USER:docker /var/lib/app/cmpe-272
sudo chmod 2775 /var/lib/app/cmpe-272

# Create the wrapper script
cat > /var/lib/app/cmpe-272/docker-compose << 'EOF'
#!/bin/bash
# Wrapper to run docker-compose in a container
# Inherits all shell environment variables and the .env file

# 1. Load the .env file if it exists
ENV_FILE="/var/lib/app/cmpe-272/.env"
ENV_OPTS=""
if [ -f "$ENV_FILE" ]; then
  ENV_OPTS="--env-file $ENV_FILE"
fi

# 2. Inherit all current shell variables
# This generates a list of -e VAR1 -e VAR2 for every variable in the shell
INHERIT_VARS=$(env | cut -d= -f1 | sed 's/^/-e /' | tr '\n' ' ')

docker run --rm \
  -v /var/run/docker.sock:/var/run/docker.sock \
  -v /var/lib/app/cmpe-272:/var/lib/app/cmpe-272 \
  -v "$PWD":"$PWD" \
  -w "$PWD" \
  $ENV_OPTS \
  $INHERIT_VARS \
  docker/compose:alpine-1.29.2 "$@"
EOF

# Make it executable
chmod +x /var/lib/app/cmpe-272/docker-compose
```

### 2. Configure Deployment User
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

| Secret | Value                                                                                                   |
|--------|---------------------------------------------------------------------------------------------------------|
| `VM_HOST` | The Static IP from Phase 1                                                                              |
| `VM_USERNAME` | The username from Phase 2, Step 3                                                                       |
| `SSH_PRIVATE_KEY` | The private key from Phase 3, Step 1                                                                    |
| `DB_USER` | The same `DB_USER` used in Phase 2, Step 2                                                              |
| `DB_PASSWORD` | The same `DB_PASSWORD` used in Phase 2, Step 2                                                          |
| `IMAGE_HOST` | The CDN URL from Phase 1, Step 6 (e.g., `https://cdn.yourdomain.com`)                                   |
| `APP_SECRET` | A random string of at least 32 characters for token signing (use `openssl rand -base64 32` to generate) |
| `PARTNER_URLS` | Comma delimited partner URLs                                                                            |
| `HTTP_PORT` | HTTP port to serve application from                                                                     |

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

## Phase 5: Maintenance and Updates

### Recreating the application

1. SSH into the VM.
2. Run `cd /var/lib/app/cmpe-272`
3. Run `bash ./docker-compose down -v`
4. Redeploy by pushing a new tag.