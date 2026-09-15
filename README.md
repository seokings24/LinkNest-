# LinkNest — GitHub Pages HTML + JavaScript

This is the GitHub Pages/static version. It needs only:

- `index.html`
- `404.html`
- `style.css`

## Features

- URL SLUG field
- Title
- Photo URL
- Live photo preview
- Create link
- Copy link
- Open link
- Delete link
- Browser-private link list using `localStorage`
- No Login/Register
- Responsive dashboard

## GitHub Pages setup

Upload the three files to the repository root.

Then go to:

**Repository → Settings → Pages → Deploy from a branch → main → /(root) → Save**

## Redirect behavior

The `/go/<slug>` path is handled by `404.html` and JavaScript. It redirects to the destination stored in that browser's local storage.

### Important limitation

GitHub Pages is static hosting. It cannot run PHP, Node.js, SQLite, or server-side HTTP redirects.

Therefore this version **cannot provide a real HTTP 301 status**. It provides a client-side redirect instead.

Also, because the data is intentionally browser-private:

- Browser A can see Browser A's created links.
- Browser B cannot see Browser A's link list.
- A link created in Browser A is not available to Browser B's redirect lookup.

A truly public `/go/slug` that works from every browser requires a server-side database/redirect service.
