# Developer Guide: BLIS-NG Self-Update Feature

## How It Works

The self-update is a laucher based and user-initiated process. There is no auto-update or remote version check. The user manually selects a ZIP file containing a new release from their local storage (they can download the new release beforehand), and the app walks through a 10-stage pipeline to replace itself while preserving data.

## Code Layout

The update feature is spread across a small number of files.

**ViewModels/ServerControlViewModel.cs** handles the UI trigger. It opens the file picker, creates the update window, and kicks off the update.

**ViewModels/UpdateProgressViewModel.cs** is where all the real work happens. The `StartUpdate()` method contains the entire 10-stage pipeline, and the class also has helper methods for ZIP extraction, backups, executable replacement, and cleanup. If you need to add more stages, here is where that would be.

**Views/MainWindow.axaml** has the "More Options" menu with the "Update with ZIP File" button.

**Views/UpdateProgressWindow.axaml** is the progress window that shows stage text, a progress bar, and a status message. Any new UI changes should go here.

**Config/StateFile.cs** contains both the `StateFile` class (reads and writes `state.json`) and the `VersionFile` class (reads `version.json` from inside the update ZIP). If any version check is being implemented that is different than the current schema, here is where you would need to add that.

**Config/ConfigurationFile.cs** has `ResolveBaseDirectory()`, which parses the `--WorkingDirectory` command line argument. This is how the new process knows where to find everything after a restart.

**Server/MainServer.cs** provides the `Stop()` method used in Stage 4 to shut down Apache2 and MySQL before replacing files.

**App.axaml.cs** calls `StartupCleanup()` on launch to remove leftover artifacts from the previous update.

## High Level Architechture Diagram:

# BLIS-NG Self-Update Data Flow

```
User selects ZIP file via "More Options" → "Update with ZIP File"
                          │
                          ▼
              ┌───────────────────────┐
              │  1. Extract ZIP       │
              │     → staging/        │
              └───────────┬───────────┘
                          │
                          ▼
              ┌───────────────────────┐
              │  2. Validate package  │──── Missing files or same version? → Abort with error
              │     version.json      │
              │     executable        │
              │     server/           │
              └───────────┬───────────┘
                          │
                          ▼
              ┌───────────────────────┐
              │  3. Backup database   │
              │     → backups/        │
              └───────────┬───────────┘
                          │
                          ▼
              ┌───────────────────────┐
              │  4. Stop servers      │
              │     Apache2 + MySQL   │
              └───────────┬───────────┘
                          │
                          ▼
              ┌───────────────────────┐
              │  5. Backup server     │
              │     → backups/        │
              └───────────┬───────────┘
                          │
                          ▼
              ┌───────────────────────┐
              │  6. Install new       │
              │     server files      │
              └───────────┬───────────┘
                          │
                          ▼
              ┌───────────────────────┐
              │  7. Install new       │
              │     release files     │
              └───────────┬───────────┘
                          │
                          ▼
              ┌───────────────────────┐
              │  8. Update state.json │
              │     active_version    │
              │     previous_version  │
              └───────────┬───────────┘
                          │
                          ▼
              ┌───────────────────────┐
              │  9. Replace exe       │
              │     rename old → .old │
              │     copy new → .exe   │
              └───────────┬───────────┘
                          │
                          ▼
              ┌───────────────────────┐
              │ 10. Launch new exe    │
              │     exit old process  │
              └───────────┬───────────┘
                          │
                          ▼
              ┌───────────────────────┐
              │  New process starts   │
              │  Cleans up:           │
              │    - staging/         │
              │    - .exe.old         │
              └───────────────────────┘
```

## Understanding the Flow

When the user clicks "Update with ZIP File", `ServerControlViewModel` opens a native file picker filtered to `.zip` files. Once a file is selected, it creates an `UpdateProgressViewModel` and an `UpdateProgressWindow`, then calls `StartUpdate()`.

`StartUpdate()` is a single async method that runs all 10 stages in order. Each stage calls `UpdateStage(n, text)` to update the progress bar and label. The stages are intentionally sequential because later stages depend on earlier ones (you can't install the new server before stopping the old one).

The update can't delete its own staging directory or the old executable while they're still in use. So instead, Stage 9 renames the running exe to `.old` (Windows allows renaming a running executable), Stage 10 launches the new exe and exits, and on the next startup `StartupCleanup()` removes both artifacts. This bypass works, and has been tested on lab devices.

### Key helper methods in UpdateProgressViewModel

| Method | What it does |
|---|---|
| `UnpackZip()` | Extracts the ZIP to a staging directory, handles ZIPs with a single root folder |
| `CreateAutomatedDatabaseBackup()` | Copies the database directory into backups |
| `ReplaceExecutable()` | Three-step file swap: delete old, rename current, copy new |
| `LaunchNewExecutable()` | Starts the new process with the `--WorkingDirectory` argument |
| `StartupCleanup()` | Static method called on app startup to delete the `.old` exe and staging directory |
| `CopyDirectoryRecursive()` | Simple recursive directory copy |
| `FindFileRecursive()` | Searches for a file by name in a directory tree |

## Making Changes

### Adding a new stage

Increment the `TotalStages` constant (currently 10), then add your logic in `StartUpdate()` at the right point in the sequence. Call `UpdateStage(n, "Your description...")` at the start of your stage. The progress bar math is automatic.

### Changing validation rules

Validation happens in Stage 2 of `StartUpdate()`. Right now it checks for `version.json`, `BLIS-NG.exe`, and a `server/` directory, and also rejects updates where the version matches the current one. To require a new file, follow the pattern of `FindFileRecursive()` and add it to the validation block.

### Changing the executable replacement strategy

The current approach in `ReplaceExecutable()` is a three-step swap that relies on Windows allowing you to rename a running binary. If you need to support other platforms, this is the method to change.

### Modifying what gets backed up

Database backup lives in `CreateAutomatedDatabaseBackup()`. Server backup is done inline in Stage 5 of `StartUpdate()` using `Directory.Move()`.

### Changing the restart mechanism

`LaunchNewExecutable()` passes `--WorkingDirectory` as a URI to the new process. `ConfigurationFile.ResolveBaseDirectory()` picks it up on the other side. If you change the argument format, update both.

## Testing

### What you need

- A release ZIP from the BLIS project's build pipeline (or a local build output from local release script)
- The ZIP must contain `version.json`, `BLIS-NG.exe`, and a `server/` directory
- The version in the ZIP must be different from the currently running version

### How to test

1. Build or grab an update ZIP from the BLIS project release
2. Launch BLIS-NG
3. Click "More Options" in the main window
4. Click "Update with ZIP File"
5. Pick the ZIP in the file dialog
6. Watch the progress window walk through all 10 stages
7. It should finish with "Update Successful, Restarting..." in green
8. The app exits and relaunches on its own
9. Confirm the new version is running (if purely testing, introduce a UI change to launcher and another to the app and verify manually)

### What to check after a successful update

- The app starts cleanly with no errors
- `state.json` has the right `active_version` and `previous_version`
- `BLIS-NG.exe.old` and `staging/` are gone (they get cleaned up on relaunch)
- `backups/` has both a database backup and a server backup with timestamps
- `releases/{version}/` has the new release files
- Apache2 and MySQL start and reach healthy status
- Logs in `log/` show no errors from the update

### Error scenarios worth testing

- A ZIP missing `version.json` should show "Incompatible Update ZIP File"
- A ZIP with the same version as current should show "Update Version is Same as Current Version"
- A ZIP missing the `server/` directory should show "Incompatible Update ZIP File"
- A corrupt or invalid ZIP should show an error with the exception message

### Checking logs

Update activity goes to `{baseDir}/log/blis_ng_{date}.log`. Look for entries from `UpdateProgressViewModel` to trace the full update flow.
