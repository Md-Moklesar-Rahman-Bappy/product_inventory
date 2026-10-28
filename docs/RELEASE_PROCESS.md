# Release Process

## Branch Model

- office: Permanent source/development branch. All feature branches created from here.
- main: Customer-facing release-download branch. Contains only product_inventory.zip and documentation.

## Building a Release

1. Ensure working tree is clean (git status).
2. Update version in .env.example (or create VERSION).
3. Run scripts/build-release.sh (or follow manual process below):
   - Create staging directory (elease-staging/product_inventory/)
   - Copy approved source files
   - Remove forbidden content (.env, .git/, SQL dumps, runtime logs, tests)
   - Replace tracked endor/ with production endor/ via composer install --no-dev --prefer-dist --optimize-autoloader
   - Build assets if needed (
pm run build)
   - Create ZIP with top-level product_inventory/ folder
   - Verify exclusions
   - Calculate SHA-256 (Get-FileHash or sha256sum)
4. Push office.
5. Create recovery tag on main before changing it (git tag backup-main-source-before-release-layout main).
6. Replace main contents with release package and documentation.
7. Commit main (git commit -m "Publish Product Inventory customer installation package vX.Y.Z").
8. Push main (git push origin main).

## Safety Rules

- Never delete office.
- Never force-push (--force) to main or office.
- Never commit .env, secrets, or production SQL dumps.
- Verify ZIP excludes .env, .git/, 
ode_modules/, and runtime caches.
- Document any remaining security advisories honestly.
