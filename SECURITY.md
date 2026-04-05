# 🔐 Security Policy

## 📌 Supported Versions
We provide security updates for the following versions:

| Version | Supported |
|---------|-----------|
| 5.1.x   | ✅         |
| 5.0.x   | ❌         |
| 4.0.x   | ✅         |
| < 4.0   | ❌         |

We follow [Semantic Versioning](https://semver.org/). Only actively maintained branches receive security updates.

---

## 🛡️ Reporting a Vulnerability
If you discover a security vulnerability in this repository:

- **Do not** open a public issue.
- Please report it privately via email: [risingbappy1@gmail.com](mailto:risingbappy1@gmail.com)
- Include:
  - A clear description of the vulnerability
  - Steps to reproduce
  - Affected versions
  - Any proof-of-concept if available

---

## ⏱️ Response Timeline
- We will acknowledge receipt within **48 hours**.
- You can expect updates at least **weekly** until the issue is resolved.
- If accepted, we will work on a patch and release notes.
- If declined, we will explain why and provide guidance if possible.

---

## 📢 Disclosure Policy
- Please allow us time to patch before public disclosure.
- Once resolved, we will credit the reporter (if desired) in the [CHANGELOG.md](CHANGELOG.md) or release notes.

---

## 🔒 Security Best Practices
- Do not commit `.env` files or secrets.
- Validate all user input using Laravel Form Requests.
- Keep dependencies updated (`composer update`, `npm audit fix`).
<<<<<<< HEAD
- Run CodeQL and Dependabot scans regularly.
=======
- Run CodeQL and Dependabot scans regularly.
>>>>>>> af656de39e6e8cfafcf6327b35394bee04eabfe0
