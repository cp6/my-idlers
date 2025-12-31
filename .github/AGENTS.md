# AGENTS.md

Instructions for AI agents (Claude Code, GitHub Copilot, etc.) working in this repository.

## Quick Start

```bash
# Run tests
php artisan test
```

---

## Agent Entry Points

### Bug Fixes
1. Read `CLAUDE.md` for architecture overview
2. Check tests/ for existing test coverage
3. Run php artisan test before and after changes


### Feature Additions
1. Check existing patterns in app/
2. Follow the project's coding conventions
3. Add tests for new functionality
4. Update documentation as needed

### Documentation Updates
1. Update `README.md` for user-facing changes
2. Update `CLAUDE.md` for structural changes


---

## Do's and Don'ts

### Do
- Run tests before committing
- Follow existing naming conventions
- Use proper error handling
- Test with both dry-run and actual execution (where applicable)
- Keep commits focused and atomic

### Don't
- Modify CI workflow unless explicitly asked
- Add dependencies without documenting them
- Change default config values without justification
- Commit sensitive files (credentials, API keys, etc.)
- Use syntax incompatible with PHP 8.x

---

## Testing Requirements

Before any PR:
1. All tests must pass: `php artisan test`
2. No linting errors
3. CI must pass

---

## File Ownership

| Files | Modify Freely | Requires Review |
|-------|---------------|-----------------|
| `CLAUDE.md`, `AGENTS.md` | Yes | No |
| `README.md` | Yes | No |
| `.github/workflows/*` | No | Yes - CI/CD |

---

## Known Limitations

{{TODO: Document known limitations}}

---

## Commit Message Format

```
<type>: <short description>

Types: fix, feat, docs, test, chore, refactor
```

Examples:
- `fix: handle edge case in data processing`
- `feat: add new configuration option`
- `docs: update installation instructions`

