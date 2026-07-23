# Installation Guide

## Product Inventory Dashboard

### Super Admin Account

During installation, the setup wizard will prompt you to create your own super admin account. You choose the name, email, mobile, and password — no default or hardcoded credentials are used.

| Field    | Source                                  |
|----------|-----------------------------------------|
| Name     | Entered during installation             |
| Email    | Entered during installation             |
| Mobile   | Entered during installation             |
| Password | Entered during installation             |
| Role     | Super Admin (permission=0)              |

### How the Super Admin Account is Created

The superadmin is created exclusively through the **Installation Wizard**:

1. **Installation Wizard** — When you run the web-based installer (`/install`), Step 4 prompts you to enter the admin name, email, mobile, and password. The account is created with `permission=0` (Super Admin) and `utype=SA`.

There are **no hardcoded credentials**, **no hidden accounts**, and **no backdoor access**.

### Security Features

- **No Backdoors** — No hidden authentication bypasses, no secret routes, no hardcoded tokens or credentials.
- **Visible Account** — The superadmin account is fully visible in the Users management page.
- **Normal CRUD** — The superadmin can be edited, disabled, and deleted by authorized administrators through the standard user management interface.
- **Role Hierarchy**:
  - Super Admin (`permission=0`): Full access, can manage all users
  - Admin (`permission=1`): Can manage categories, brands, products
  - User (`permission=2`): Read-only dashboard access

### First Login Flow

1. Navigate to the application URL
2. Login with the credentials you created during installation
3. Access the dashboard and begin configuring your inventory system

### Production Recommendations

After first login:
1. **Configure SMTP** for email notifications
2. **Review user roles** and create additional admin accounts as needed
3. **Disable registration** if not needed (the registration route is public by default)
