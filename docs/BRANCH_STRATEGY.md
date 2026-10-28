# Branch Strategy

- office: Development source branch. Features branch from here. Contains full source, tests, tracked vendor (historical), documentation, and safe configuration examples. Must never contain secrets or production dumps.
- main: Customer release branch. Contains only product_inventory.zip and release documentation. The ZIP provides the installable runtime package.
- Tags (source-baseline-vX.Y.Z): Baseline tags for source releases.
- Recovery tags (ackup-main-source-before-release-layout): Created before changing main to release layout.

Never develop directly in main. Always regenerate product_inventory.zip from a clean staging build.
