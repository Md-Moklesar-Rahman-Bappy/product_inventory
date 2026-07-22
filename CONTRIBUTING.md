# Contributing to Product Inventory

Thank you for considering contributing to Product Inventory! This document outlines the guidelines for contributing to this project.

## Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL 8.x
- Node.js & NPM (for frontend assets, if modifying CSS/JS beyond CDN)
- Git

## Getting Started

### 1. Fork & Clone

```bash
# Fork the repository on GitHub, then:
git clone https://github.com/your-username/product_inventory.git
cd product_inventory

# Add the upstream remote
git remote add upstream https://github.com/original-owner/product_inventory.git
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Configure your `.env` with local database credentials and run the installer wizard.

### 4. Create a Branch

```bash
git checkout -b feature/your-feature-name
```

## Branch Naming Convention

Use the following prefixes:

| Prefix | Purpose |
|---|---|
| `feature/` | New features |
| `fix/` | Bug fixes |
| `hotfix/` | Critical production fixes |
| `refactor/` | Code refactoring |
| `docs/` | Documentation changes |
| `test/` | Adding or updating tests |

Examples:
- `feature/bulk-product-delete`
- `fix/warranty-date-calculation`
- `docs/update-installation-guide`

## Commit Message Convention

Follow the [Conventional Commits](https://www.conventionalcommits.org/) specification:

```
<type>(<scope>): <description>

[optional body]

[optional footer(s)]
```

### Types

| Type | Description |
|---|---|
| `feat` | New feature |
| `fix` | Bug fix |
| `docs` | Documentation only changes |
| `style` | Code style changes (formatting, no logic change) |
| `refactor` | Code refactoring without feature/fix changes |
| `test` | Adding or updating tests |
| `chore` | Build process, dependencies, tooling |

### Examples

```
feat(products): add barcode generation for products
fix(categories): prevent deletion of categories with active products
docs(readme): update installation steps
test(products): add import validation tests
```

## Code Style

This project follows **PSR-12** coding standards.

### Running the Linter

```bash
# Laravel Pint (recommended - configured in pint.json)
./vendor/bin/pint

# Check without fixing
./vendor/bin/pint --test
```

### Guidelines

- Use strict types where possible (`declare(strict_types=1)`)
- Use PHP 8.2+ features (readonly properties, enums, named arguments) when appropriate
- Keep controllers thin - move business logic to service classes or models
- Use Eloquent relationships instead of raw queries where feasible
- Use `$fillable` on all models instead of `$guarded`
- Use soft deletes for all deletable entities
- Prefix Blade variables with meaningful names
- Use Blade components for reusable UI elements

## Testing

### Writing Tests

- Write tests using **PestPHP** (preferred) or PHPUnit
- Place feature tests in `tests/Feature/`
- Place unit tests in `tests/Unit/`
- Each test file should focus on a single functionality

### Running Tests

```bash
# Run all tests
php artisan test

# Run a specific test file
php artisan test tests/Feature/ProductTest.php

# Run with Pest
./vendor/bin/pest
```

### Test Database

Tests use an in-memory SQLite database configured in `phpunit.xml`:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

No external database is required for testing.

### Test Naming

- Use descriptive test names that explain the expected behavior
- Pest syntax: `it('should redirect unauthenticated users to login')`
- PHPUnit syntax: `public function test_unauthenticated_users_are_redirected()`

## Pull Request Process

### 1. Update Your Fork

```bash
git fetch upstream
git rebase upstream/main
```

### 2. Make Your Changes

- Write clean, documented code
- Add tests for new features or bug fixes
- Ensure all tests pass: `php artisan test`
- Run the linter: `./vendor/bin/pint`
- Update documentation if your change affects public-facing behavior

### 3. Commit Your Changes

```bash
git add .
git commit -m "feat(scope): clear description of changes"
```

### 4. Push & Create PR

```bash
git push origin feature/your-feature-name
```

Then create a Pull Request on GitHub with:

- **Title** following the commit message convention
- **Description** of what changed and why
- **Screenshots** if UI changes are involved
- Reference any related issues: `Closes #42`

### 5. Code Review

- All PRs require review before merging
- Address review feedback promptly
- Keep the PR focused - one feature or fix per PR

## Pull Request Checklist

Before submitting your PR, ensure:

- [ ] Code follows PSR-12 standards (`./vendor/bin/pint --test` passes)
- [ ] All existing tests pass (`php artisan test`)
- [ ] New tests are added for new features or bug fixes
- [ ] No sensitive data or credentials are committed
- [ ] Database changes are covered by migrations
- [ ] Documentation is updated if needed
- [ ] Branch is up to date with `main`
- [ ] Commit messages follow the convention
- [ ] PR description clearly explains the changes
- [ ] No merge conflicts exist

## Reporting Bugs

1. Check existing issues to avoid duplicates
2. Open a new issue with the Bug Report template
3. Include:
   - Laravel version (`php artisan --version`)
   - PHP version (`php --version`)
   - Steps to reproduce
   - Expected vs actual behavior
   - Relevant logs from `storage/logs/laravel.log`

## Feature Requests

1. Open an issue with the Feature Request template
2. Describe the problem your feature would solve
3. Suggest how it could be implemented
4. Note any alternatives you considered

## Code of Conduct

This project adheres to the [Contributor Covenant v2.1](CODE_OF_CONDUCT.md). By participating, you agree to uphold its standards.

## Questions?

If you have questions about contributing, feel free to open a discussion or reach out via email.
