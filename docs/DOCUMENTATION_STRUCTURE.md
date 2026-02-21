# Documentation Structure Overview

This document explains how the various documentation files work together.

## File Organization & Responsibilities

### 1. **README.md** (Entry Point)
- **Purpose:** Quick overview and navigation
- **Audience:** Everyone (first impression)
- **Contains:** Project name, quick links, quick start, key technologies
- **Length:** ~45 lines

### 2. **CONTRIBUTING.md** (Action-Oriented Guide)
- **Purpose:** How to contribute code to the project
- **Audience:** Developers and Copilot writing code
- **Contains:**
  - Code style conventions (PHP, Frontend, Config)
  - **Security guidelines** (XSS, SQL injection, CSRF, input validation, file uploads, headers, error handling, env vars)
  - Routing quick reference (with link to deep dive)
  - Database migrations basics
  - Git workflow
  - Testing checklist
  - Documentation update reminders
- **Length:** ~182 lines
- **When to read:** Before writing code or committing changes

### 3. **docs/ARCHITECTURE.md** (Technical Reference)
- **Purpose:** Deep technical documentation of how the system works
- **Audience:** Developers, Copilot, architects understanding the system
- **Contains:**
  - Project structure diagram
  - Routing system (detailed with examples)
  - Frontend conventions (HTML structure is comprehensive, not limited)
  - Database setup (migrations only, connection details deferred)
  - Environment variables reference
  - Dev vs production comparison
  - Instructions for adding new patterns
- **Length:** ~247 lines
- **When to read:** When implementing features or understanding how something works

### 4. **docs/DOCUMENTATION_UPDATES.md** (Maintenance Checklist)
- **Purpose:** Reminder to keep documentation in sync with code
- **Audience:** Contributors (especially Copilot)
- **Contains:**
  - Checklist for routing changes
  - Checklist for frontend changes
  - Checklist for backend changes
  - Checklist for database changes
  - Checklist for deployment changes
  - Reference table of all docs
  - Key principle: "Documentation should always reflect the current code state"
- **Length:** ~90 lines
- **When to read:** When introducing a new pattern or changing existing behavior

### 5. **SETUP.md** (Deployment Guide)
- **Purpose:** How to deploy and set up the application
- **Audience:** DevOps engineers, deployment specialists
- **Contains:** All deployment and environment setup instructions
- **When to read:** When setting up infrastructure or deploying the app

## Document Relationships

```
┌─────────────────────────────────────────────────────────────┐
│                       README.md                             │
│              (Quick links & entry point)                   │
├──────────────┬──────────────────────┬──────────────┬────────┤
│              │                      │              │        │
▼              ▼                      ▼              ▼        ▼
SETUP.md    CONTRIBUTING.md      ARCHITECTURE.md  DOCS/    LICENSE
(Deploy)    (How to Code)        (How it Works)  (Other)
  │              │                    │
  │              │                    └─── DOCUMENTATION_UPDATES.md
  │              │                         (Keep docs in sync)
  │              └────────────────────────────────────┐
  │                                                   │
  └───────────────────────────────────────────────────┘
                        ↓
                  References &
                    Links to
                   each other
```

## Information Flow

### For a Developer Writing Code:
1. Read **README.md** → understand the project
2. Read **CONTRIBUTING.md** → learn how to contribute
3. Read **docs/ARCHITECTURE.md** → understand how the system works
4. Write code following the guidelines
5. Read **docs/DOCUMENTATION_UPDATES.md** → update docs if needed

### For DevOps Setting Up Infrastructure:
1. Read **README.md** → understand the project
2. Read **SETUP.md** → follow deployment instructions
3. Refer to **docs/ARCHITECTURE.md** → understand infrastructure (dev vs prod)

### For Code Reviewers:
1. Check **CONTRIBUTING.md** → verify security & style guidelines
2. Check **docs/ARCHITECTURE.md** → verify design patterns
3. Check **docs/DOCUMENTATION_UPDATES.md** → verify docs were updated if needed

### For Copilot (AI Assistant):
1. Read **README.md** → understand project scope
2. Read **CONTRIBUTING.md** → learn coding style and security guidelines
3. Read **docs/ARCHITECTURE.md** → understand system architecture and patterns
4. Read **docs/DOCUMENTATION_UPDATES.md** → remember to update docs
5. **ALWAYS check if docs match code before implementing**

## Key Principles

### 1. **No Duplication**
- **CONTRIBUTING.md** → "How to contribute" (actionable, quick reference)
- **docs/ARCHITECTURE.md** → "How the system works" (detailed reference)
- They link to each other, not duplicate

### 2. **Security First**
- Comprehensive security guidelines are in **CONTRIBUTING.md**
- Developers see them immediately before writing code
- Includes XSS, SQL injection, CSRF, input validation, file uploads, headers, error handling

### 3. **HTML Structure is NOT Limited**
- **docs/ARCHITECTURE.md** lists common semantic HTML elements
- BUT explicitly states "NOT limited to these"
- Encourages using any semantic HTML that makes sense

### 4. **Documentation Must Stay in Sync**
- **docs/DOCUMENTATION_UPDATES.md** is the reminder system
- Every code change should trigger a docs update
- This ensures Copilot and humans understand the code correctly

## Last Updated
February 20, 2026

