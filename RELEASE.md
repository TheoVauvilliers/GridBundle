# Release process (fast-forward `main` from `develop`)

This project keeps a clean, linear history on `main`: **no merge commits**, **no rebase-and-merge** for releases.  
We **squash** feature PRs into `develop`, then **fast-forward** `main` to `develop`.

> **Requirements (branch protection)**
> - `main`: **Require linear history** ✅
> - `main`: **Restrict who can push** → only maintainers allowed ✅
> - `main`: (optional) disable "Require a pull request before merging", or add maintainers to the bypass list if
    available.
> - `develop`: protected (no deletion), CI required.

## Pre-flight checklist

- CI is **green** on `develop` (phpunit, phpstan, etc.).
- `develop` contains exactly what you want to release.
- You are allowed to push to `main`.

## Commands (maintainers)

```bash
git fetch origin
```

1. Verify that a fast-forward is possible (main ⊆ develop)

  ```bash
  git merge-base --is-ancestor origin/main origin/develop || {
  echo "Fast-forward not possible. Align develop or fix divergence first."; exit 1; }
  ```

2. Move local main to the exact remote state

  ```bash
  git switch main
  git reset --hard origin/main
  ```

3. Fast-forward strictly to develop

  ```bash
  git merge --ff-only origin/develop
  ```

4. Push (regular push, no force)

  ```bash
  git push origin main
  ```

## Troubleshooting

- "Fast-forward not possible" (step 1 fails)  
  `develop` and `main` diverged (e.g., a rebase/merge was done via PR). Fix one of:
    - Bring `develop` up to date with `main` (merge or rebase), re-run the checklist, then release.
    - Or postpone the release until `develop` is FF-able again.

- **Accidentally pushed something wrong to `main`**  
  Prefer a **revert** (keeps linear history):
    ```bash
    git revert <bad_commit_sha> --no-edit
    git push origin main
    ```

## Optional: tag the release

```bash
git tag -a vX.Y.Z -m "Release vX.Y.Z"
git push origin vX.Y.Z
```

## Rationale

- **1 PR = 1 commit** on `develop` (thanks to squash).
- **No "Merge branch ..."** on `main`.
- **No re-generated SHAs** on `main` (avoids "ahead/behind" noise).
