# CLAUDE.md — Claude Code entry point for `vardot/varbase-patches`

Project-specific guidance for Claude Code (and any Anthropic-API agent reading this file) when working in this repository. For a vendor-neutral overview that applies to every AI tool, read [`AGENTS.md`](AGENTS.md) first.

## Sub-agent and skills shipped in this repo

Local to this repository (loaded automatically by Claude Code when invoked from the repo root):

- **Sub-agent:** [`.claude/agents/varbase-patches.md`](.claude/agents/varbase-patches.md) — full-coverage agent for installing, configuring, and troubleshooting `vardot/varbase-patches`.
- **Skill:** [`.claude/skills/composer-patches/SKILL.md`](.claude/skills/composer-patches/SKILL.md) — `cweagans/composer-patches` v1/v2 + this plugin's allowlist, wildcard ignore, and `patches-ignore` extensions.
- **Skill:** [`.claude/skills/patch-management/SKILL.md`](.claude/skills/patch-management/SKILL.md) — authoring, re-rolling, filename convention, and the Composer-native cleanup commands (`var-ccup` / `var-ccupf`).

When the task is about anything in this repo, prefer invoking the local sub-agent rather than answering from scratch. The agent file encodes the version matrix, plugin knobs, and the late-activation rule.

## How to read this codebase efficiently

1. Start with [`AGENTS.md`](AGENTS.md) — the "non-obvious constraints" section is the highest-signal context.
2. Then [`docs/README.md`](docs/README.md) for the branch-specific framing.
3. Code map: `src/Plugin/VarbasePatchesPlugin.php` (entry point + activation), `src/Resolver/` (allowlist + wildcard + `patches-ignore`), `src/Command/` (`var-ccup`, `var-ccupf`).
4. Curated patch list: `composer.json` → `extra.patches`.

## Hard rules

- **Do not skip pre-commit hooks** (`--no-verify` is off-limits unless the user explicitly asks).
- **Do not amend published commits.** Create a new commit.
- **Do not link to private Vardot repositories** from in-repo documentation. Only public artifacts: this repo, `docs.varbase.vardot.com`, `cweagans/composer-patches`, Drupal.org.
- **Do not set `extra.plugin-modifies-downloads` or `extra.plugin-modifies-install-path` on this plugin.** Late activation is required — see [`AGENTS.md`](AGENTS.md) section 1.
- **Do not drop `cweagans/composer-patches` v1 compatibility.** The require constraint is `~1.7.0 || ~2.0`; both code paths must keep working.

## Branching

Work happens on the per-version branches:

- `11.0.x` — Drupal 11 / Varbase 11.
- `10.1.x` — Drupal 11 / Varbase 10.1.
- `10.0.x` — Drupal 10 / Varbase 10.
- `9.2.x` — Drupal 10 / Varbase 9.2 (CKEditor 5).
- `9.1.x` — Drupal 10 / Varbase 9.1 (CKEditor 4).

`main` does not exist as a development branch. The default PR target is `10.0.x`. Plugin-behavior fixes should typically land on `11.0.x` first, then be backported.

## Commit / PR style

- Subject: `Issue #<NNN>: <imperative summary>` when there is a tracking issue.
- Body: explain the *why* (constraint, incident, motivation), not just the *what*. Long-form commit bodies are normal in this repo (see recent history).
- Reference the Drupal.org issue number in curated-patch commits.

## When you're unsure

Read [`AGENTS.md`](AGENTS.md) first, then the sub-agent. If the question is about plugin behavior that is not documented, run `git log -p src/Plugin/ src/Resolver/` to see how the maintainers solved similar problems before.
