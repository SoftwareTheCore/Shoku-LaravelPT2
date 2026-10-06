# AGENTS.md — Shoku

> **Read this first.** Review and apply these rules to the website. Only implement or fix an item if the related feature, functionality, or technology actually exists in the project. If it is not present or not applicable, **skip it completely**. Never create a feature just to satisfy a checklist. Preserve existing functionality and behavior.

---

# 0. Project Context

- **Product:** Shoku — restaurant reservation system. Roles include Customer (self-register) and staff/admin.
- **Stack:** Laravel, Blade templates, Bootstrap 5. Layout: `layouts/app.blade.php`. Shared styles: `app.css`.
- **Language of UI copy:** Bahasa Indonesia, sentence case, plain verbs.
- **Brand tokens (source of truth):**
  - Primary: `rgb(255, 82, 50)` → `--shoku-primary`
  - Secondary: `#ffffff` → `--shoku-secondary`
  - Hover/dark primary, ink, muted, line: see `:root` in `app.css`
- **Brand overrides the design checklist.** The brand colors above are fixed by the owner. A white background or an orange primary is NOT a violation of Section 2, because it is the specified brand, not a default.

---

# 1. How to Work (General Rules)

- Inspect the existing project structure and implementation before changing anything. Decide first whether the item applies.
- Prefer minimal, targeted fixes over large refactors.
- Do not modify unrelated functionality. Do not remove functionality unless it causes a confirmed security, performance, accessibility, or SEO issue.
- Do not introduce unnecessary dependencies (no new CSS framework, icon pack, animation library, or UI kit without being asked).
- Do not change the existing design unless the task or Section 2 specifically applies.
- For security issues, fix the actual vulnerability, not a superficial protection.
- Apply conditional checks only when the feature exists: payments, authentication, webhooks, AI, file uploads, admin, email, database.
- Before editing queries, indexes, or permissions, inspect the real database implementation.
- Never fabricate content: no invented business details, legal text, reviews, testimonials, statistics, awards, or client logos. If real content is missing, leave a clearly marked placeholder (`TODO:`) and tell the owner.
- Items that need a human or an external account (Search Console verification, uptime monitoring, backup restore test, load testing, legal review) must be reported as "manual", not faked in code.
- After changes, verify that existing functionality still works.

---

# 2. Design — What You Must NOT Do (Anti "AI Slop")

The goal is a design with a deliberate point of view for a restaurant reservation product, not a generic template. Every choice (color, type, layout) must be a choice made for Shoku, not the default you would produce for any site.

## 2.1 Process rules

- **DO NOT** start coding UI before writing a short plan: colors (4–6 named values), typefaces and their roles, layout idea, and alignment. Then check the plan: if any part is what you would produce for any similar site, change it.
- **DO NOT** spread boldness everywhere. Pick ONE memorable element per page and keep everything else quiet. Before finishing, remove one decorative element.
- **DO NOT** design with placeholder-looking content. Use real Shoku content (reservations, tables, schedules, menu, confirmation states).
- **DO NOT** hardcode colors or invent new colors. Use the CSS variables in `app.css`. Do not introduce a third brand color.

## 2.2 Forbidden default looks

Do not use these unless the owner explicitly asks:

- Warm cream background + high-contrast serif headline + terracotta/clay accent.
- Near-black background + a single acid-green or vermilion accent.
- Purple-and-black, rainbow coloring, neon colors, basic pastel palettes.
- Broadsheet/newspaper layout with hairline rules and zero radius everywhere.
- Harsh or decorative gradients, gradient washes behind sections, radial orbs/glows, dot-grid backgrounds.
- Liquid glass / glassmorphism, blurred translucent cards.
- Terminal-window or code-window mockups.

## 2.3 Forbidden layout & component patterns

- **DO NOT** chop content into a grid of identical rounded cards. No "3 feature cards in a row" by default.
- **DO NOT** use one border-radius and one soft grey shadow on everything. Radius and elevation must follow hierarchy; avoid generic `rgba(0,0,0,.1)` drop shadows on every card.
- **DO NOT** default to a hero with "big number + small label + stats row + gradient accent".
- **DO NOT** add a 3-tier pricing table unless the product really has 3 tiers.
- **DO NOT** add fake product demos, fake dashboards, or mock screenshots. Use real UI or nothing.
- **DO NOT** add decorative structure without meaning: numbered markers (01/02/03) unless the content is truly a sequence, dividers, outlines, or badges that encode no information.
- **DO NOT** center-align everything. Choose alignment deliberately; left-align body text and forms' long content.
- **DO NOT** let body text lines exceed ~80 characters.

## 2.4 Forbidden typography treatments

- **DO NOT** use default font stacks as the "design" (plain Arial, Roboto, Inter, system-ui everywhere). Choose typefaces deliberately: one family, or two that are clearly distinct.
- **DO NOT** accent a single word in a headline (one word in italic, bold, or a different color).
- **DO NOT** use tracked-out ALL-CAPS labels / eyebrow text above every heading.
- **DO NOT** add unnecessary labels above content.
- **DO NOT** use monospace for small data labels as decoration, spaced-em-dash labels ("WORD — fragment"), or middle-dot meta strings ("A · B · C").
- **DO NOT** replace true black with tinted near-black (`#0B0B0B`, `#111`) as a stylistic habit.

## 2.5 Forbidden icon, emoji & decoration habits

- **DO NOT** put an icon (Lucide or any set) on every card, heading, or list item.
- **DO NOT** use emojis as icons or bullets in the UI.
- **DO NOT** use checkmark bullet lists as filler.
- **DO NOT** use sparkle icons, animated arrows, or append "→" to every link/button.
- **DO NOT** add decorative SVG blobs, shapes, or stock-style illustrations that carry no information.

## 2.6 Forbidden motion

- **DO NOT** add fade-and-slide-up entrances to every section.
- **DO NOT** add hover transitions/lift/scale to every card.
- Motion is allowed only (a) as ONE deliberate page-load moment, or (b) as a response to a user action (open, expand, confirm).
- **ALWAYS** respect `prefers-reduced-motion`.

## 2.7 Forbidden copywriting

- **DO NOT** write "It's not X, it's Y" constructions, hype, or filler taglines.
- **DO NOT** use vague CTAs ("Submit", "Click here"). Say what happens: "Daftar", "Reservasi meja", "Simpan perubahan".
- **DO NOT** name things by how the system is built; name them by what the user understands.
- **DO NOT** write errors that apologize or stay vague. State what went wrong and how to fix it.
- **DO NOT** use different words for the same action across a flow.
- **DO NOT** invent reviews, ratings, numbers, or claims ("10.000+ pelanggan") that the owner has not provided.

## 2.8 Required states (their absence is also a defect)

- **DO** add loading states / skeleton loaders where data loads asynchronously.
- **DO** add useful empty states (an invitation to act, not decoration).
- **DO** add error states for failed requests.
- **DO** keep Terms of Service and Privacy Policy pages reachable if the site collects user data (content must be real or marked `TODO:` for legal review).

## 2.9 Quality floor (must always hold)

- Responsive down to mobile (~360px). No horizontal scroll.
- Visible keyboard focus on every interactive element.
- Text contrast meets WCAG AA. Note: white text on `rgb(255, 82, 50)` is ~3.3:1, so use it only for large or bold text (buttons, headings); for small text or links on white, use `--shoku-primary-dark`.
- Form labels tied to inputs; touch targets large enough.

---

# 3. SEO

Apply only where relevant to existing pages.

1. Build `sitemap.xml`
2. Add `robots.txt`
3. Remove accidental `noindex` tags (keep `noindex` on login, register, admin, and other private pages)
4. Add canonical tags
5. Add unique meta titles
6. Add meta descriptions
7. One H1 per page
8. Fix heading order
9. Add meaningful alt text
10. Add schema markup where it fits (e.g. `Restaurant`/`LocalBusiness` — only with real data)
11. Add internal links
12. Fix broken links
13. Compress images
14. Core Web Vitals
15. Fix mobile layout
16. Enforce HTTPS
17. Clean up URL slugs
18. Add an `og:image`
19. Verify Search Console — **manual** (owner)
20. Add `llms.txt` — only if the owner wants it

---

# 4. Security

(Merged from the former security, additional-security, and auth/API lists; duplicates removed.)

**Access control**
1. Protect admin routes; enforce access server-side (middleware/policies)
2. Prevent IDOR / BOLA: always check that the record belongs to the authenticated user
3. Remove default admin routes and default credentials
4. Row-level security — only if the database layer actually uses it

**Authentication & sessions**
5. Verify email (only if the app sends/verifies email)
6. Hash passwords
7. No auth tokens in local storage
8. Reset sessions on password change
9. Expire reset links; rate-limit password resets; fix any broken reset flow
10. Prevent user enumeration (same message for unknown email vs wrong password)
11. Lock accounts / throttle after repeated failed logins
12. Secure session settings and cookie flags (`Secure`, `HttpOnly`, `SameSite`)
13. JWT secrets strong and server-side (only if JWT is used)

**Input & output**
14. Parameterized queries only (no string-built SQL)
15. Validate all form inputs server-side
16. Block XSS (escape output; sanitize before storing where HTML is accepted)
17. CSRF protection on all state-changing requests
18. Validate uploads: whitelist types, check real MIME, limit size, random filenames, store outside web root (only if uploads exist)
19. Prevent path traversal and SSRF
20. Limit request size

**Secrets & config**
21. Secrets server-side only; no secrets in logs
22. Keep `.env` out of Git; ensure it is not web-accessible
23. Production debug off
24. Disable directory listing; hide exposed environments, logs, and source maps
25. Add HSTS and other security headers
26. Lock down CORS (no wildcard with credentials)

**Other**
27. Rate-limit requests
28. Verify webhook signatures (only if webhooks exist)
29. Payments: set prices server-side; never trust frontend amounts (only if payments exist)
30. Block prompt injection; cap AI usage (only if AI exists)
31. Restrict database user permissions
32. Log security events (login failures, permission denials)
33. Patch dependencies (`composer audit`, `npm audit`)
34. Run a security review/scan of the codebase

---

# 5. Performance & Reliability

1. Add rate limiting and API limits
2. Set spending caps (only for paid third-party/AI APIs)
3. Add error handling and error logging
4. Add loading states and empty states
5. Handle failed requests and API timeouts
6. Prevent duplicate submissions (e.g. double reservation click)
7. Prevent duplicate payments (only if payments exist)
8. Optimise DB queries (avoid N+1; use eager loading)
9. Add DB indexes where queries need them
10. Paginate large results
11. Compress files/assets
12. Limit upload size
13. Cache repeat requests where safe
14. Add uptime monitoring — **manual**
15. Test simultaneous users (e.g. two customers booking the same table) — **manual / test**
16. Test backup restore — **manual**

---

# 6. Privacy, Legal & Accessibility

Legal pages must contain real content or a visible `TODO:` for legal review. Never invent business details.

1. Privacy policy
2. Terms of service
3. Refund/cancellation policy (if reservations or payments can be cancelled/refunded)
4. Cookie policy and consent banner (only if non-essential cookies/trackers are used)
5. Check form consents
6. Collect no unnecessary data
7. Audit third-party SDKs and fonts
8. Remove dark patterns, hidden fees, fake reviews, unsupported claims
9. Accessibility: alt text, color contrast, keyboard navigation
10. Add real business details (address, contact, hours) — provided by the owner
11. Age consent for children's data (only if relevant)
12. Unsubscribe link in marketing emails (only if such emails exist)
13. License fonts/images properly
14. Provide a data deletion request path

---

# 7. Laravel Notes

Use the framework's own tools; do not add packages for what Laravel already does.

- CSRF: `@csrf` in every form; do not exclude routes from `VerifyCsrfToken` without reason.
- SQL: use Eloquent / query builder bindings, never concatenated raw SQL.
- Passwords: `Hash::make()`; validate with `Password` rules.
- Access: middleware + Policies/Gates, not hidden buttons.
- Output: use `{{ }}` (escaped); use `{!! !!}` only with sanitized content.
- Throttling: `throttle` middleware on login, register, and password reset.
- Config: `APP_DEBUG=false` and a real `APP_KEY` in production; `.env` never committed.
- Validation: Form Requests; keep error messages in Bahasa Indonesia and specific.
- Styles: put shared styles in `app.css` using the brand variables; no inline colors.

---

# 8. Token Saving — Skip What Is Not Needed

> **If an item is not necessary, DO NOT implement it in code. Skip it and save tokens.**

- If a checklist item is not applicable, already satisfied, or not required for the current task: **skip it silently**. Do not write code, do not add a placeholder, do not explain why.
- Work only on files related to the current task. Do not scan, open, or rewrite unrelated files.
- Do not read or rewrite a whole file when a small targeted edit is enough.
- Do not run the entire checklist on every task. Apply only the sections relevant to what was asked (e.g. a UI task → Section 2; a form task → Sections 2 and 4).
- Do not add extra features, pages, components, comments, or refactors "just in case".
- Do not re-do or "polish" work that already works unless asked.
- Do not repeat large code blocks in the reply. Reply in 1–3 sentences: what changed and which files.
- Do not write long explanations, summaries, or lists of items that were skipped.
- If unsure whether something is needed, choose the smaller change and ask the owner one short question instead of building extra.
