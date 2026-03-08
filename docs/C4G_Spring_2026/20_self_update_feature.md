# Feature Addition: Launcher-Based Self Update for Desktop Application

## Summary

We are introducing a launcher-based self-update feature for the BLIS desktop application to simplify how updates are performed. Today, updates are heavily manual and technician-dependent. This feature will automate the majority of that work directly through the BLIS launcher, reducing update time, minimizing human error, and creating a more reliable and repeatable process.

---

## Current Implementation

Right now, updating BLIS requires a technician to:

- Bring the new version on a USB drive  
- Install the new version manually  
- Create a backup of the existing system  
- Manually migrate data and files  
- Verify that everything works properly  

---

## Proposed Solution

We will add a simple “Install Local Update (.zip)” button inside the BLIS-NG launcher.

Instead of manually installing and migrating files, the administrator will:

1. Insert the USB drive  
2. Select the update package in the launcher  
3. Let the launcher handle the rest  

The launcher will automatically prepare and stage the new version, stop currently running services, migrate the data, switch system to new version and restart the application. If the launcher itself needs updating, it will handle that as part of the process. This change turns a slow, technician-heavy workflow into a guided and mostly automated process. Instead of relying on manual steps and technician memory, the launcher becomes the single, consistent update mechanism.

---

Main Contributors:

Luqman Rashad  
Haki Atalov  
