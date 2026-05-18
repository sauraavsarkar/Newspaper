# Today Morning News — Next Implementation Plan
> Phase 2 Roadmap · Picking up after the Editorial Command Center

---

## What We Have So Far ✅

- Professional Article Versioning System (Git-like)
- Command Center Editorial Dashboard UI (Glassmorphism)
- Flawless Dark Mode & Theme Persistence
- CKEditor with theme-aware styling
- Article Registry with real-time metrics
- Comprehensive README documentation

---

## Phase 2 Overview

This phase transforms the CMS from an editorial tool into a
**full living newspaper platform** — with a public-facing site,
reader engagement, real-time features, and analytics intelligence.

Split into 5 sprints. Each sprint is independently shippable.

---

## Sprint 1 — Public Site & Reader Experience
> Goal: The newspaper is readable by the world

### 1.1 Public Homepage
- Hero section — latest breaking news, full-width featured article
- Trending Now sidebar — top 5 articles by view count last 6 hours
- Category blocks — Politics, Sports, Tech, Entertainment rows
- Morning Digest section — auto-curated based on time of day
- Breaking news banner at top — live, dismissible

### 1.2 Article Detail Page
- Full article body rendered from CKEditor HTML
- Reading progress bar fixed at top as user scrolls
- Estimated read time badge — "5 min read" from word count
- Author byline card at bottom — journalist photo, bio, article count
- Related articles section — same category, same tags
- Article series navigation — if part of a series show Part 1/2/3
- Social share buttons — copy link, Twitter, WhatsApp

### 1.3 Category & Tag Pages
- `/category/politics` — paginated article grid for that category
- `/tag/election-2026` — articles by tag
- Each page has its own SEO meta title and description
- Sort by: Latest / Most Viewed / Most Commented

### 1.4 Search Page
- Full-text search across title, body, tags
- Search suggestions dropdown as user types (Alpine.js)
- Filter by: category, author, date range, read time
- Highlight matched keyword inside article snippet
- Recent searches saved per logged-in user
- "Did you mean" suggestion for typos

### 1.5 Journalist Public Profile Page
- `/journalist/{username}` — public profile URL
- Photo, bio, beat, location, social links
- Published article count and total views
- Article grid — all their published work
- Follow button — registered readers can follow and get notified

---

## Sprint 2 — Reader Dashboard & Personalization
> Goal: Registered readers have their own personal newspaper

### 2.1 Reader Registration & Onboarding
- Register form — name, email, password
- Email verification required before dashboard access
- Onboarding step after verify — pick 3+ categories of interest
- This seeds their personalized feed immediately

### 2.2 Reader Dashboard — Morning Digest
- Personalized greeting — "Good morning, Rahul · Tuesday, May 20"
- Breaking news ticker at top if active
- Today's Digest section — articles from followed categories
- Continue Reading — articles they opened but scroll depth < 50%
- Trending Right Now — live updating every 60 seconds
- Saved Articles quick access — last 3 bookmarks
- Reading Streak counter — "🔥 7 day streak"
- Followed Categories quick links

### 2.3 Reading History & Bookmarks
- Every article visit logged silently (article ID + scroll depth + time)
- `/reader/history` — full reading history paginated
- Bookmark button on every article — heart or bookmark icon
- `/reader/saved` — saved articles grid with remove option
- "You read this 3 days ago" label on revisited article cards

### 2.4 Reader Profile Edit Page
- Edit: name, avatar, bio, location, website, socials
- Change email — triggers re-verification
- Change password
- Notification preferences — toggle each type on/off
- Followed categories management
- Delete account option (soft delete)

### 2.5 Subscription System
- Free tier — all public articles, with ads
- Premium tier — all articles including premium-flagged, ad-free
- `/subscribe` page — plan comparison, monthly vs yearly
- Subscription stored in `subscriptions` table
- Premium article gate — non-subscribers see first 3 paragraphs
  then a blur overlay with "Subscribe to continue reading"
- Subscription expiry warning — notification 3 days before

---

## Sprint 3 — Engagement System
> Goal: Readers interact, react, comment, debate

### 3.1 Reaction System on Articles
- Reaction bar below every article — 👍 ❤️ 😮 😢 😡 🔥
- Registered users — full reactions, can change anytime
- Guest users — one reaction per article, tracked by IP + fingerprint
- Guest tooltip on hover — "Register to change your reaction anytime"
- Grouped display — "Ali, Sara and 45 others reacted"
- Reactions stored in `reactions` table with morphable relation
  so same system works for articles AND comments

### 3.2 Comment System
- Registered users only — no guest comments
- Post comment on article
- Edit own comment — within 15 minute window, shows "edited" label
- Delete own comment
- Report comment — sends to moderator queue
- Comment count shown on article card and detail page
- Comments sorted by: Newest / Oldest / Most Liked

### 3.3 Nested Replies — One Level Deep
- Reply button under each comment
- Clicking opens inline reply input — no page reload (Livewire)
- Reply shows nested under parent with indent
- Auto-tags parent commenter — @John
- Reply cannot have its own replies — one level only
- Collapse/expand thread toggle

### 3.4 Comment Reactions
- 👍 Like and ❤️ Love only on comments — keep it simple
- Registered users only
- Count shown next to each comment

### 3.5 Poll System Inside Articles
- Editor/journalist can embed a poll in article body via CKEditor
- Poll options — 2 to 5 choices
- Guest vote — one time, IP tracked
- Registered vote — can change vote
- Results shown as live progress bars after voting
- Poll results included in article analytics

---

## Sprint 4 — Notifications & Activity Intelligence
> Goal: The platform feels alive and keeps users coming back

### 4.1 Notification Bell — Facebook Style
- Bell icon in navbar for all logged-in users
- Red badge with unread count
- Dropdown panel — latest 10 notifications
- Mark all as read button
- Auto-mark as read when user visits the related page
- Full notifications page — `/notifications` paginated

### 4.2 Notification Triggers by Role

**Journalist receives:**
- Article approved ✅ — with editor name
- Article rejected ❌ — tap to see rejection note
- Article published 🌐
- Revision requested by editor
- New comment on their article
- Reply to their comment
- Article is trending 🔥 — on crossing view threshold
- Reactions grouped — "John and 12 others reacted"

**Editor receives:**
- New article submitted for review
- Journalist revised and resubmitted
- Breaking news toggled by admin

**Moderator receives:**
- New comment abuse report filed
- Comment auto-flagged as spam

**Admin receives:**
- New user registered
- New subscription purchased
- Failed queue job alert
- Daily summary notification

**Reader receives:**
- Reply to their comment
- Reaction on their comment
- New article in followed category
- Breaking news alert (if opted in)
- Subscription expiring in 3 days
- Weekly reading summary

### 4.3 Notification Grouping Logic
- Reactions grouped — not 47 separate lines
- Comments grouped — "3 new comments on Your Article"
- Grouping window — 1 hour (events in same hour = one notification)

### 4.4 Notification Delivery Channels
- In-app bell — always, every notification
- Email — user controls per type in preferences
  Batched into digest, not one email per event
- Real-time WebSocket push — breaking news and article
  approval only (time-sensitive events only)

### 4.5 Activity Log System
- Global `activity_logs` table — logs everything
- Every user: login, logout, failed login, password change
- Reader: article visited, reacted, bookmarked, commented
- Journalist: article created, edited, submitted, version restored
- Editor: article approved, rejected, edited, scheduled
- Moderator: comment deleted, user banned, report resolved
- Admin: user role changed, user banned, homepage updated

**Admin Activity Feed page:**
- Real-time feed of all system events — Livewire polling
- Filter by: role, user, action type, date range
- Export to CSV

**Per-user Activity History:**
- `/profile/activity` — user's own history
- Journalists see their full article lifecycle here

**Per-article Timeline:**
- Inside article edit page — full event timeline
- Every save, status change, edit, approval shown in order

---

## Sprint 5 — Analytics & Intelligence Dashboard
> Goal: Data tells the story of the newsroom

### 5.1 Admin Analytics Dashboard
- Total views today vs yesterday — percentage change
- New users today — registered readers
- Articles published this week — by category breakdown
- Top 10 most viewed articles — all time and last 7 days
- Top 5 most active journalists — by published count and views
- Category performance — bar chart views per category
- Daily views line chart — last 30 days
- Traffic growth chart — weekly comparison
- Peak reading hours heatmap — which hours get most traffic

### 5.2 Journalist Personal Analytics
- My articles performance table — views, comments, reactions per article
- Best performing article highlight card
- Total views lifetime counter
- Views per day chart — last 14 days for their articles
- Reader engagement rate — comments + reactions / views

### 5.3 Trending Algorithm
Score calculated every 15 minutes via scheduled job.

```
trending_score = (views × 1) + (comments × 3) + (reactions × 2)
                 divided by hours_since_published ^ 1.5
```

- Older articles decay naturally
- Score stored on article row for fast querying
- Trending articles highlighted with 🔥 badge on cards

### 5.4 Article Read Depth Analytics
- Track scroll depth — 25%, 50%, 75%, 100% milestones
- Store per article per session
- Show in article analytics — "68% of readers finish this article"
- Helps journalists know if their articles hold attention

### 5.5 Newsletter Builder
- Admin/Editor composes newsletter from inside CMS
- Pick up to 8 articles — drag to reorder
- Write short intro text above article list
- Preview renders as real email HTML
- Send to all newsletter subscribers via Laravel Queue
- Sent newsletters archived at `/admin/newsletters`
- Open rate tracked — pixel tracking per subscriber

---

## Quick Wins to Add Anytime
> Small features, big CV impact

- **Dark mode on public site** — respects system preference,
  manual toggle button in navbar
- **Article text-to-speech** — Listen button using Web Speech API,
  no external service, play/pause/progress
- **Reading time personalization** — "Fast reader? This takes 3 min"
  based on their historical reading speed
- **Keyboard shortcuts** — `S` to save draft, `P` to preview,
  `/` to focus search — journalists love this
- **Print-friendly article view** — `/article/slug/print`
  clean layout, no navbar, no ads
- **RSS Feed** — `/feed.xml` for each category and global
  one-line Laravel route, huge for credibility
- **Sitemap** — auto-generated `sitemap.xml` for SEO
- **Open Graph meta tags** — article thumbnail + title +
  description so sharing on WhatsApp and Twitter looks rich

---

## Recommended Sprint Order

| Order | Sprint | Why First |
|-------|--------|-----------|
| 1st | Sprint 1 — Public Site | Nothing to show without a public face |
| 2nd | Sprint 3 — Engagement | Reactions and comments make it feel real |
| 3rd | Sprint 2 — Reader Dashboard | Personal space after engagement works |
| 4th | Sprint 4 — Notifications | Needs engagement data to be meaningful |
| 5th | Sprint 5 — Analytics | Needs real data from all above sprints |

---

## Definition of Done for Each Sprint

Before moving to the next sprint, each sprint must have:

- [ ] Feature works on desktop and mobile
- [ ] Dark mode works correctly on new pages
- [ ] New routes protected by correct role middleware
- [ ] New models have factories and seeders
- [ ] Activity log records new actions
- [ ] README updated with new screenshots

---

## Current Stack — No Changes Needed

| Layer | Tool |
|-------|------|
| Backend | Laravel + Livewire 3 |
| Frontend | Alpine.js + Tailwind CSS |
| Rich Text | CKEditor 5 |
| Real-time | Pusher + Laravel Echo |
| Auth & Roles | Breeze + Spatie Permission |
| Media | Spatie Media Library |
| Versioning | Custom VersionService + ArticleObserver |
| Queue | Laravel Queue (database driver → Redis in production) |
| DB | MySQL |

---

> **Next action:** Start Sprint 1.1 — build the public homepage.
> The editorial engine is ready. Now the world needs to read it.
