---
name: patch-management
description: Create, manage, and maintain patches for Drupal modules using unified diff format. Use when creating patches from code changes, re-rolling patches for new versions, downloading merge request patches, or cleaning up patch files.
---

# Patch Management

Create, manage, and maintain patches for Drupal modules using unified diff format.

## Prerequisites

- Git installed
- Access to module source code
- Drupal project with composer

## Instructions

### Creating Patches from Git

#### From uncommitted changes
```bash
cd web/modules/contrib/module_name
git diff > ../../../patches/module_name-fix-description.patch
```

#### From specific commits
```bash
git format-patch -1 abc1234 --stdout > patches/module-commit-fix.patch
```

#### From branch comparison
```bash
git diff main..feature-branch > patches/module-feature.patch
```

### Patch File Format

Unified diff format:
```diff
--- a/src/SomeClass.php
+++ b/src/SomeClass.php
@@ -10,7 +10,7 @@
   public function example() {
-    return $old_value;
+    return $new_value;
   }
```

### Downloading Merge Request Patches

From Drupal.org GitLab:
```bash
# Get MR diff (not recommended for production)
curl -o patches/module-issue.patch \
  "https://git.drupalcode.org/project/module/-/merge_requests/123.diff"
```

**Better approach**: Download and save locally with timestamp:
```bash
# Download with proper naming
curl -o patches/module--$(date +%Y-%m-%d)--issue-123.patch \
  "https://git.drupalcode.org/project/module/-/merge_requests/123.diff"
```

### Re-rolling Patches

When a patch no longer applies:

1. **Get the original issue context**
```bash
# Read the patch header for issue reference
head -20 patches/old-patch.patch
```

2. **Apply patch with conflicts**
```bash
cd web/modules/contrib/module_name
git apply --3way ../../../patches/old-patch.patch
```

3. **Resolve conflicts and create new patch**
```bash
# Fix conflicts manually
git add .
git diff HEAD > ../../../patches/module--$(date +%Y-%m-%d)--issue-reroll.patch
```

### Composer commands for patch cleanup

`vardot/varbase-patches` registers Composer-native commands (these replace the older Drush commands previously shipped in `varbase_core`):

```bash
# Rewrite MR URLs in root composer.json to local timestamped files under ./patches/
composer varbase-patches:cleanup:patches      # alias: composer var-ccup

# Same operation, applied to the JSON file referenced by extra.patches-file
composer varbase-patches:cleanup:patches-file # alias: composer var-ccupf
```

### Patch Storage Best Practices

1. **Never delete applied patches** - Keep for reference
2. **Use descriptive names** with date and issue number
3. **Store in `patches/` directory** next to composer.json
4. **Document patch purpose** in composer.json description

### Directory Structure

```
project/
├── composer.json
├── patches/
│   ├── drupal-core--2024-01-09--3049332-85.patch
│   ├── paragraphs--2024-02-04--3419073-3.patch
│   └── README.md  # Document patches
└── web/
```

## Examples

### Example 1: Create patch for PHP 8.4 fix

```bash
# Edit the file
vim web/modules/contrib/module/src/Service.php

# Create patch
cd web/modules/contrib/module
git diff src/Service.php > ../../../../patches/module--$(date +%Y-%m-%d)--php84-nullable.patch
```

### Example 2: Apply and test patch

```bash
# Test patch applies cleanly
cd web/modules/contrib/module
git apply --check ../../../../patches/module-fix.patch

# Apply patch
git apply ../../../../patches/module-fix.patch
```

### Example 3: Convert MR to local patch

```bash
# Download MR
curl -o patches/module--$(date +%Y-%m-%d)--3456789-mr-42.patch \
  "https://git.drupalcode.org/project/module/-/merge_requests/42.diff"

# Update composer.json to use local patch
# Change from MR URL to local file path
```

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Patch won't apply | Re-roll for current version |
| Whitespace errors | Use `git apply --whitespace=fix` |
| Wrong patch level | Try `-p1` or `-p2` option |
| Already applied | Remove or add to patches-ignore |
