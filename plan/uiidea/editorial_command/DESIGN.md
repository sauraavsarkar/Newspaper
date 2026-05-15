---
name: Editorial Command
colors:
  surface: '#fcf8fa'
  surface-dim: '#dcd9db'
  surface-bright: '#fcf8fa'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f6f3f5'
  surface-container: '#f0edef'
  surface-container-high: '#eae7e9'
  surface-container-highest: '#e4e2e4'
  on-surface: '#1b1b1d'
  on-surface-variant: '#45464d'
  inverse-surface: '#303032'
  inverse-on-surface: '#f3f0f2'
  outline: '#76777d'
  outline-variant: '#c6c6cd'
  surface-tint: '#565e74'
  primary: '#000000'
  on-primary: '#ffffff'
  primary-container: '#131b2e'
  on-primary-container: '#7c839b'
  inverse-primary: '#bec6e0'
  secondary: '#0051d5'
  on-secondary: '#ffffff'
  secondary-container: '#316bf3'
  on-secondary-container: '#fefcff'
  tertiary: '#000000'
  on-tertiary: '#ffffff'
  tertiary-container: '#271901'
  on-tertiary-container: '#98805d'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dae2fd'
  primary-fixed-dim: '#bec6e0'
  on-primary-fixed: '#131b2e'
  on-primary-fixed-variant: '#3f465c'
  secondary-fixed: '#dbe1ff'
  secondary-fixed-dim: '#b4c5ff'
  on-secondary-fixed: '#00174b'
  on-secondary-fixed-variant: '#003ea8'
  tertiary-fixed: '#fcdeb5'
  tertiary-fixed-dim: '#dec29a'
  on-tertiary-fixed: '#271901'
  on-tertiary-fixed-variant: '#574425'
  background: '#fcf8fa'
  on-background: '#1b1b1d'
  surface-variant: '#e4e2e4'
typography:
  display-lg:
    fontFamily: Geist
    fontSize: 40px
    fontWeight: '700'
    lineHeight: 48px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Geist
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Geist
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  headline-sm:
    fontFamily: Geist
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  body-sm:
    fontFamily: Inter
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 18px
  data-mono:
    fontFamily: JetBrains Mono
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
  label-caps:
    fontFamily: Inter
    fontSize: 11px
    fontWeight: '700'
    lineHeight: 16px
    letterSpacing: 0.05em
  headline-lg-mobile:
    fontFamily: Geist
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  base: 4px
  xs: 8px
  sm: 12px
  md: 16px
  lg: 24px
  xl: 32px
  sidebar-width: 260px
  gutter: 16px
---

## Brand & Style

The design system is anchored in the principles of **high-density utility** and **editorial authority**. It is built for a high-stakes, fast-moving environment where clarity of information is the primary driver of user success. The brand personality is clinical, reliable, and decisive.

The visual style is a hybrid of **Corporate Modern** and **Information Minimalism**. It rejects unnecessary ornamentation in favor of structural clarity, using a rigid block-based architecture. Drawing from contemporary developer tools and financial dashboards, it prioritizes "glanceability"—the ability for an editor to scan vast amounts of data, status updates, and metrics without cognitive fatigue. The aesthetic is "quietly powerful," staying out of the way of the content while providing a robust framework for complex workflows.

## Colors

The palette is designed to establish a clear hierarchy between the "vessel" (the interface) and the "cargo" (the news content). 

- **Primary (Deep Navy):** Reserved for the "Command Layer"—global navigation, sidebar containers, and primary headers. It provides a grounded, authoritative frame for the application.
- **Secondary (Professional Blue):** The "Action Layer." Used exclusively for interactive elements, primary calls to action, and focus states.
- **Semantic Accents:** Colors are used functionally rather than decoratively. **Success Green** indicates SEO health and growth metrics; **Alert Amber** signifies backlog items or pending reviews; **Revenue Emerald** highlights monetization and high-value performance data.
- **Surface Grays:** A nuanced range of neutral grays differentiates the workspace canvas from individual module cards, creating a subtle sense of depth without relying on heavy shadows.

## Typography

This design system utilizes a three-font strategy to manage its dense information architecture:

1.  **Geist (Headlines):** Chosen for its technical precision and modern, geometric structure. It provides an authoritative voice for section headers and page titles.
2.  **Inter (Body/UI):** The workhorse font for all interface text, inputs, and long-form descriptions. It is highly legible at small sizes, which is critical for the data-dense layouts of this system.
3.  **JetBrains Mono (Data/Metrics):** Used specifically for word counts, timestamps, SEO scores, and numerical metrics. The monospaced nature ensures that numbers align perfectly in tables and dashboard widgets.

Use `label-caps` for table headers and secondary navigation items to provide clear distinction from content text.

## Layout & Spacing

The system employs a **modular block-based grid** system. The layout is dominated by a persistent primary sidebar on the left, containing multi-module access, and a contextual utility bar on the right for metadata and SEO tools.

- **Grid:** A 12-column fluid grid for the main canvas, allowing for flexible card widths (e.g., 4-column widgets, 8-column editorial feeds).
- **Rhythm:** An 8px baseline grid (with a 4px sub-grid) governs all vertical and horizontal spacing.
- **Density:** Padding within cards is kept tight (16px) to maximize the visible data on screen.
- **Breakpoints:**
  - **Desktop (1440px+):** Full three-column layout (Sidebar + Canvas + Utility).
  - **Laptop (1024px - 1439px):** Canvas + Utility (Sidebar collapses to icons).
  - **Tablet/Mobile:** Single column fluid canvas with drawer-based navigation.

## Elevation & Depth

Hierarchy is achieved through **tonal layering** and **low-contrast outlines** rather than aggressive shadows. This keeps the interface feeling flat, fast, and digital-native.

- **Level 0 (Background):** `#F1F5F9` (Canvas) acts as the base floor.
- **Level 1 (Cards/Modules):** White (`#FFFFFF`) surfaces with a 1px border (`#E2E8F0`). A very soft, 4px blur shadow is applied to distinguish these from the background.
- **Level 2 (Popovers/Modals):** White surfaces with a more pronounced shadow (12px blur, 0.05 opacity) and a darker border (`#CBD5E1`).
- **Interactive State:** When dragging cards (Trello-style), increase shadow depth and apply a 2px Professional Blue border to indicate the active state.

## Shapes

The shape language is **Soft (Level 1)**, utilizing a 4px (0.25rem) corner radius for most UI components. This choice strikes a balance between the clinical sharpness of high-end data tools and the approachable nature of modern productivity apps.

- **Standard Elements:** Buttons, Input fields, and Status badges use 4px.
- **Containers:** Large cards and module containers use 8px (`rounded-lg`) to provide a clear structural boundary.
- **Indicators:** Progress bars and selection indicators remain sharp or use minimal rounding to maintain a professional, "engineered" look.

## Components

- **Cards:** The primary container. Must include a header area for titles and a footer for mini-sparklines or "last edited" metadata. 
- **Status Badges:** Compact, pill-shaped tags using the semantic color palette. Text must be in `data-mono` or `label-caps`.
- **Buttons:** 
  - *Primary:* Solid Professional Blue, white text.
  - *Secondary:* Ghost style with 1px border and Professional Blue text.
- **Input Fields:** Flat styling with a 1px border. Focus state uses a 2px Professional Blue ring.
- **Mini Sparklines:** Integrated into list items or card footers to show traffic trends or SEO growth without requiring a full dashboard view.
- **Sidebar Items:** High-contrast hover states. Active items should use a subtle left-aligned vertical "accent bar" in Professional Blue.
- **Progress Bars:** Thin (4px height) bars used within cards to show "Article Completion" or "Editorial Workflow" percentage.