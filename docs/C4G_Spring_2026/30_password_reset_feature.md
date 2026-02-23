# Feature Addition: Password Reset Utility for Desktop Launcher

## Summary

We are introducing a standalone **Password Reset Utility** integrated directly into the BLIS-NG desktop launcher. This feature is designed to empower lab staff to regain access to their local instances independently, reducing the burden on limited IT personnel and minimizing system downtime caused by lost credentials.

---

## Current Challenge

Currently, when lab staff lose access to their local BLIS instances, the recovery process is problematic because:

* **Technical Barriers:** Staff often lack the specialized training required to reset database credentials manually.
* **Resource Constraints:** Recovery often requires manual intervention from a small pool of available IT staff.
* **Operational Downtime:** Labs may remain locked out of their systems until a technician is available to perform the reset.

---

## Proposed Solution

We will implement a **"Reset DB Password"** button within the BLIS-NG launcher. This utility provides a secure, guided interface to update user credentials without requiring deep technical knowledge or direct backend manipulation by the end-user.

### High-Level Workflow

1. **Initiation:** While the system services are active, the user selects the password reset option within the launcher interface.
2. **User Input:** A secure dialog opens, prompting the user to provide the target account username and define a new password.
3. **Validation:** The launcher automatically validates the inputs to ensure they meet system requirements, such as password matching and minimum length.
4. **Automated Update:** The launcher securely communicates with the local database to apply the new credentials using its internal administrative permissions.
5. **Feedback:** The system provides immediate feedback to the user, confirming whether the reset was successful or if further action is required.

This change transforms an IT support ticket into a simple, self-service task for lab personnel, ensuring the launcher remains the central hub for system maintenance.

---

Main Contributors:

[Insert Name]
[Insert Name]