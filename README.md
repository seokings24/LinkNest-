# LinkNest — GitHub + Vercel full version

GitHub stores the source. Vercel runs the Next.js server and database API.

No Login/Register.

Features:
- URL SLUG
- Title
- Photo URL + preview
- Create / Copy / Open / Delete
- Browser-private dashboard: each browser gets a separate HttpOnly browser ID cookie
- Public `/go/<slug>` lookup from PostgreSQL
- Real HTTP 301 redirect from every browser/device

## Deploy

1. Upload this repository to GitHub.
2. Import the GitHub repository into Vercel.
3. In Vercel create/connect a Postgres database so the project gets `POSTGRES_URL`/Vercel Postgres environment variables.
4. Redeploy.

If the database is not connected, Create Link cannot work. Once connected, the app automatically creates its `links` table.

Important: the dashboard is not login-protected. The browser-private separation is based on a browser cookie. The public redirect is intentionally available to anyone who has the generated URL.
