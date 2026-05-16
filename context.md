# Role & Purpose
You are an expert Full-Stack Developer (PHP, Laravel, MySQL, Bootstrap 5). Your task is to build an "Organizational Inventory System", a web application designed to digitize inventory tracking and asset management for a single Faculty Student Organization. 

# Tech Stack
- **Backend:** PHP, Laravel (latest)
- **Frontend (Public/User):** Bootstrap 5, Blade Templating
- **Frontend (Admin/Staff):** SB Admin Template (Bootstrap 5)
- **Database:** MySQL
- **Authentication:** Laravel Breeze/UI + Laravel Socialite (for Google Auth)

# System Architecture & Scope
- The system manages inventory for one organization but serves many users.
- Exporting data (PDF/Excel) is NOT required.
- WhatsApp integration via API is NOT required (only display text/link of the Staff's WA number).

# User Roles & Flows

1. Guest (Unauthenticated)
   - Lands on a Public Home Page featuring a Hero Section.
   - Can browse the inventory catalog and see item availability.
   - Prompted to login/register if they want to borrow an item.

2. Regular User (Anggota/Peminjam)
   - **Auth:** Can register via Open Registration or Google Account (OAuth).
   - **Access:** Stays on the Public-facing site. 
   - **Actions:** Can request to borrow available items (no limit on quantity, no system-enforced time limit).
   - **Dashboard:** Can view their borrowing history, in-app notifications, and current request status.

3. Staff (Pengelola Barang)
   - **Auth:** Login required. Redirected directly to the SB Admin Dashboard upon login.
   - **Access:** Access to Staff Dashboard, plus a navigation link to view the Public Site.
   - **Actions:** 
     - Manage Inventory: Edit item availability manually, update condition, name, and description. Cannot create or delete items.
     - Manage Requests: Approve or Reject pending borrowing requests.
     - Manage Returns: Manually mark items as "Returned" once the physical item is verified offline.

4. Super Admin
   - **Access:** Access to Admin Dashboard (SB Admin), plus a navigation link to view the Public Site.
   - **Actions:** Has all Staff privileges PLUS the ability to Create new items, Delete items, and Manage User Roles (promote User to Staff/Admin).

# Core Logics & Workflows to Implement

## 1. Borrowing State Machine (Crucial)
The borrowing process strictly follows this flow:
- **Pending:** User requests an item. The request appears in the Staff/Admin dashboard. **Important:** The item's physical availability count in the database DOES NOT change at this stage.
- **Approved/Borrowed:** Staff approves the request in the dashboard. The item's availability count is now decreased/marked unavailable. The system provides the Staff's WhatsApp number to the User to discuss pickup and return times externally.
- **Rejected:** Staff rejects the request. Availability remains unchanged.
- **Returned:** User returns the item offline. Staff verifies it physically, then manually clicks "Mark as Returned" on the dashboard. The item's availability count increases/is restored.

## 2. In-App Notifications
- Use Laravel Database Notifications.
- Users receive a notification when their borrowing request status changes (e.g., "Your request for [Item Name] has been Approved! Please contact WA: 0812xxxxxx").
- Staff/Admins receive a notification when a new borrowing request is submitted by a user.