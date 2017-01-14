# Cleanup TODO

**Plan:** Move all parts of Ovase to same repository. Use composer extensively.

## Tasks

- Merge and move proto-repo to get history into this repo
- Move appropriate parts of picopages into repo
- Keep deployment in mind. Use composer where available and apply own patches.
- Fix wiki:
    + Do we really need whole wiki codebase in our own repo?
    + To avoid - will have to find all changes made
    + This could be done on dev server after having done initial cleanup and moved proto to prod server.
- Find out how to most easily deploy wiki with parsoid and images
- Change URLs to match new scheme