-- Migration: Add per-user salt column for modernized password hashing
-- Run this once against the blis_revamp database before deploying the PHP changes

ALTER TABLE user ADD COLUMN salt VARCHAR(64) NULL DEFAULT NULL;

-- Existing rows will have NULL salt, meaning they still use the legacy SHA-1/hardcoded salt method.
-- The salt column is populated the first time each user logs in successfully.
