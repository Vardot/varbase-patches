# Drupal Git commit message format (commit types) — saved summary

Source: <https://www.drupal.org/node/3586390> (fetched 2026-07-02). The live page is the source of truth — re-read it before the first commit of a session. As of November 2025, Drupal Core commit messages comply with the Conventional Commits specification.

## Format

```
{commit type}: #{issue ID} One line summary of the change

By: user1
By: user2
```

- The MR title uses the same `{type}: #{id} Summary` string.
- Issue ID = the last part of the issue URL (drupal.org nid, or per-project GitLab iid after migration).

## Commit types — drupal.org projects (Drupal core list; no `chore`/`style`/`build`)

| Type | Meaning |
|------|---------|
| `fix` | A bug fix |
| `feat` | A new feature |
| `ci` | Changes to CI configuration files and scripts (e.g. `.gitlab-ci.yml`) |
| `docs` | Changes only to documentation |
| `perf` | A code change that improves performance |
| `refactor` | A code change that neither fixes a bug nor adds a feature |
| `test` | Adding missing tests or correcting existing tests |
| `task` | A code change that does not easily fit any other category |
| `revert` | Reverts a previous commit |

## Commit types — non-drupal.org repos (full Conventional Commits list)

For Vardot GitHub repos and other projects that follow plain [Conventional Commits](https://www.conventionalcommits.org/):

| Type | Meaning |
|------|---------|
| `feat` | A new feature |
| `fix` | A bug fix |
| `docs` | Documentation only changes |
| `style` | Changes that do not affect the meaning of the code (white-space, formatting, missing semi-colons, etc) |
| `refactor` | A code change that neither fixes a bug nor adds a feature |
| `perf` | A code change that improves performance |
| `test` | Adding missing tests or correcting existing tests |
| `build` | Changes that affect the build system or external dependencies (example scopes: gulp, broccoli, npm) |
| `ci` | Changes to our CI configuration files and scripts (example scopes: Travis, Circle, BrowserStack, SauceLabs) |
| `chore` | Other changes that don't modify src or test files |
| `revert` | Reverts a previous commit |

On drupal.org, the Drupal list wins: use `task` instead of `chore`/`build`/`style`.

## `By:` attribution lines

- Use **drupal.org usernames**, NOT GitLab usernames.
- **No `@username`** form.
- `By:` lines do not determine issue credit (credit is set on the issue).
- Maintainers may also use `Co-authored-by:`, `Reported-by:`, `Reviewed-by:` trailers.

## Vardot addition

Follow with the AI-disclosure line per the [AI policy](drupal-ai-policy.md) when AI assistance was significant:

```
AI-Generated: Yes (<what the AI did>; reviewed by <contributor>.)
```
