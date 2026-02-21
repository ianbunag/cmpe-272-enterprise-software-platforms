# Documentation Update Checklist

This file serves as a reminder to keep documentation synchronized with code changes. When introducing new patterns, conventions, or structural changes, use this checklist to ensure consistency.

## When to Update Documentation

### 1. **Routing Changes**
- [ ] Updated `docs/ARCHITECTURE.md#routing-system` with the new pattern
- [ ] Added example in `/public/examples/routing/` if applicable
- [ ] Updated `nginx/default.conf` and documented the map structure
- [ ] Tested both `/path` and `/path/` variations

**Files to Update:**
- `docs/ARCHITECTURE.md`
- `nginx/default.conf`
- `/public/examples/routing/` (add examples)

---

### 2. **Frontend/HTML Conventions**
- [ ] Updated `docs/ARCHITECTURE.md#frontend-conventions` with new patterns
- [ ] Documented any new CSS framework usage or Pico.css extensions
- [ ] Added semantic HTML examples if applicable
- [ ] Updated XSS prevention guidelines if needed

**Files to Update:**
- `docs/ARCHITECTURE.md`
- `CONTRIBUTING.md` (if affects contribution guidelines)

---

### 3. **PHP/Backend Patterns**
- [ ] Updated `docs/ARCHITECTURE.md` with new code patterns
- [ ] Updated `CONTRIBUTING.md` with any new conventions
- [ ] Added example in `/public/examples/` if it's a new pattern
- [ ] Ensured error handling follows existing patterns

**Files to Update:**
- `docs/ARCHITECTURE.md`
- `CONTRIBUTING.md`
- `/public/examples/` (add examples)

---

### 4. **Database Changes**
- [ ] Created migration file in `migrations/` with proper naming
- [ ] Updated `docs/ARCHITECTURE.md#database-setup` if changing migration strategy
- [ ] Updated `SETUP.md` if affecting deployment process
- [ ] Tested migration in both development and production

**Files to Update:**
- `migrations/` (add migration)
- `docs/ARCHITECTURE.md`
- `SETUP.md`

---

### 5. **Deployment/Infrastructure Changes**
- [ ] Updated `SETUP.md` with new deployment steps
- [ ] Updated `docker-compose.yml` and/or `docker-compose-prod.yml`
- [ ] Updated `nginx/default.conf` if changing server config
- [ ] Updated GitHub Actions workflow (if applicable)

**Files to Update:**
- `SETUP.md`
- `docker-compose.yml` and/or `docker-compose-prod.yml`
- `nginx/default.conf`
- `.github/workflows/` (if applicable)

---

### 6. **Project Structure Changes**
- [ ] Updated `docs/ARCHITECTURE.md#project-structure`
- [ ] Updated `README.md` if changing top-level directories
- [ ] Created/updated appropriate documentation for new folders

**Files to Update:**
- `docs/ARCHITECTURE.md`
- `README.md` (if major structural change)

---

## Documentation Files Reference

| File | Purpose | Audience |
|------|---------|----------|
| `README.md` | Project overview & quick links | Everyone (first entry point) |
| `SETUP.md` | Deployment & environment setup | DevOps engineers, deployment specialists |
| `CONTRIBUTING.md` | Contribution guidelines & coding conventions | Developers contributing code |
| `docs/ARCHITECTURE.md` | Deep dive into project structure, routing, patterns | Developers, Copilot (for code understanding) |
| `docs/` | Additional documentation (optional) | Topic-specific documentation |

## Key Principle

**Documentation should always reflect the current code state.** If code and documentation diverge, Copilot (and future developers) will make incorrect assumptions about how the project works.

## For Copilot

When contributing code:
1. Check the relevant documentation file(s) listed above
2. Ensure code follows the documented patterns
3. If introducing a new pattern, **update documentation BEFORE merging**
4. Use this file as a checklist when implementing features

---

**Last Updated:** February 20, 2026

