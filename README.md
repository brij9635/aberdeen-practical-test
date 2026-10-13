# WordPress Practical Test: Programs Module

A bespoke, production-ready WordPress Programs module featuring a custom post type, hierarchical taxonomy, modern React admin UI with repeater fields, custom frontend routing, Interactivity API dynamic filtering, and a secure server-side JSON Lines click tracking system. Built without third-party plugins.

---

## 📋 Table of Contents
1. [Overview](#overview)
2. [Architecture & Folder Structure](#architecture--folder-structure)
3. [Git Workflow](#git-workflow)
4. [Setup & Build Steps](#setup--build-steps)
5. [Tracking System & Log Storage](#tracking-system--log-storage)
6. [Decisions & Plan vs Actual](#decisions--plan-vs-actual)

---

## 3. Git Workflow
Per the compulsory requirements, the code moves upward through dedicated PRs:
```text
main ◄─── uat ◄─── dev ◄─── feature/*
```

Branches created:
- `main`: Production-ready baseline.
- `uat`: User acceptance testing staging branch.
- `dev`: Primary integration branch.
- `feature/cpt-setup`: Post type, taxonomy, and sample data.
- `feature/admin-ui`: React repeater metabox and media picker.
- `feature/frontend`: Templates, reusable card, and routing.
- `feature/tracking`: Click tracking, REST route, and JSONL logger.
