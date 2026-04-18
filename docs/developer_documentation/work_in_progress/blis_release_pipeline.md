# BLIS Release Pipeline

## Overview

Releases are produced by the `Build Release` GitHub Actions workflow (`build-release.yml`), triggered manually via `workflow_dispatch`. It pulls from three repositories and produces two artifacts: a full standalone installation package and a lightweight update payload.

## Repositories

| Repository | Purpose |
|---|---|
| `C4G/BLIS` | Application source files (htdocs, db, vendor, local) |
| `C4G/BLISRuntime` | Server runtime binaries (Apache2, MySQL). Uses Git LFS. |
| `C4G/BLIS-NG` | Launcher source. Built during the workflow via `dotnet publish`. |

## Inputs

| Input | Required | Default | Description |
|---|---|---|---|
| `blis_branch` | Yes | `main` | Branch to build from in C4G/BLIS |
| `blisruntime_branch` | Yes | `main` | Branch to build from in C4G/BLISRuntime |
| `blisng_branch` | Yes | `main` | Branch to build from in C4G/BLIS-NG |
| `version` | Yes | -- | SemVer string (e.g. `4.1.0`, `4.1.0-beta.1`). No leading `v`. |
| `include_launcher` | No | `true` | Include `BLIS-NG.exe` in the update ZIP |
| `include_server_runtime` | No | `true` | Include `server/` binaries in the update ZIP |
| `push_tag` | No | `false` | Tag the BLIS repo with `v{version}` after a successful build |

The `version` input is validated against a strict SemVer pattern at build time. The workflow will exit with an error if the format is invalid or the field is empty.

## What the Workflow Does

1. Checks out all three repositories at the specified branches.
2. Builds `BLIS-NG.exe` using `dotnet publish -r win-x64 -c Release` targeting .NET 10.
3. Generates `version.json` and writes it into the BLIS repo directory.
4. Assembles the `BLIS-Standalone` directory structure and zips it.
5. Assembles the `BLIS-Update` directory and zips it.
6. Optionally tags the BLIS repo if `push_tag` is true.

## version.json

`version.json` is generated at build time and embedded into both artifacts. The launcher and update pipeline use it to identify and validate releases.

```json
{
  "version": "4.1.0",
  "build_timestamp": "20250415-183000",
  "git_sha": "a1b2c3d",
  "min_launcher_version": "1.0.0"
}
```

`min_launcher_version` is reserved for future compatibility enforcement. `VersionFile` in `Config/StateFile.cs` reads this file out of the update ZIP during Stage 2 validation.

## Artifacts

### BLIS-Standalone.zip

The full installation package. Contains everything needed to run BLIS on a fresh machine.

```
BLIS-Standalone/
├── BLIS-NG.exe
├── state.json
├── releases/
│   └── <version>/
│       ├── htdocs/
│       ├── db/
│       ├── vendor/
│       ├── local/
│       └── version.json
├── server/
├── dbdir/
├── local/
├── storage/
├── data/
│   └── backups/
├── log/
└── staging/
```

`state.json` is initialized with `active_version` set to the build version and `previous_version` set to `null`.

### blis-update.zip

The update payload. This is the ZIP a user selects when running "Update with ZIP File" in the launcher. It always contains the core app files:

- `htdocs/`
- `db/`
- `vendor/`
- `local/`
- `version.json`

It optionally includes `server/` (controlled by `include_server_runtime`) and `BLIS-NG.exe` (controlled by `include_launcher`). Omit these when the server runtime or launcher has not changed to keep the payload small.

The Stage 2 validation in `UpdateProgressViewModel` checks the contents of this ZIP for `version.json`, `BLIS-NG.exe`, and `server/` before proceeding with the update.

## Running the Workflow

1. Go to the `C4G/BLIS-NG` repository on GitHub.
2. Navigate to **Actions** and select **Build Release**.
3. Click **Run workflow**.
4. Fill in the branch inputs and version string.
5. Set `include_launcher` and `include_server_runtime` based on what changed in this release.
6. Set `push_tag` to `true` if this is a release that should be tagged in the BLIS repo.
7. Download `BLIS-Standalone.zip` and `blis-update.zip` from the workflow run artifacts once the build completes.