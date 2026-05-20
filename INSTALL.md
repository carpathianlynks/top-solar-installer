# Solar Case Study — Gutenberg Template

## Files in this package
- `solar-case-study-gutenberg.html` — The page template (Gutenberg blocks + custom HTML)
- `tq-functions-snippet.php` — Add to your child theme's functions.php
- `INSTALL.md` — This file

---

## Installation (3 methods — pick one)

### METHOD A — Full Site Editing (FSE) Block Theme
*Requires a block theme like Twenty Twenty-Four, Kadence, or Blocksy*

1. Go to **Appearance → Editor → Templates**
2. Click **Add New Template → Page**  
3. Switch to **Code Editor** (top-right ⋮ → Code editor)
4. Paste the full contents of `solar-case-study-gutenberg.html`
5. Save, then assign it to your page

### METHOD B — Classic Theme with Page Template File
*Requires a child theme*

1. Create file: `wp-content/themes/YOUR-CHILD-THEME/templates/solar-case-study-gutenberg.html`
2. Paste contents of `solar-case-study-gutenberg.html` into it
3. Add the code from `tq-functions-snippet.php` to your child theme's `functions.php`
4. Create a new WordPress **Page**
5. In Page attributes (right sidebar) → Template → select **"Solar: Case Study"**
6. Publish

### METHOD C — Gutenberg Pattern / Reusable Block
*Quickest method, no theme changes needed*

1. Go to **Appearance → Editor → Patterns → Add New Pattern**
2. Switch to Code Editor, paste the contents
3. Save as a synced pattern
4. Add to any page via the block inserter

---

## CSS Setup

The template includes all CSS inline in a `<!-- wp:html -->` block, so it works out of the box.

For cleaner production use, extract the `<style>` block contents into:
`wp-content/themes/YOUR-CHILD-THEME/css/tq-case-study.css`

Then uncomment the `wp_enqueue_style` call in `tq-functions-snippet.php`.

---

## Contact Form

The CTA form uses `admin-post.php`. The handler in `tq-functions-snippet.php` sends submissions to the WordPress admin email. To change the recipient, edit `$to` in `tq_handle_contact_form()`.

For WPForms/Gravity Forms/CF7: replace the `<form>` block in the template with your shortcode inside a `<!-- wp:shortcode -->` block:
```
<!-- wp:shortcode -->
[contact-form-7 id="123"]
<!-- /wp:shortcode -->
```

---

## PHP in templates

The template includes a few PHP calls (`home_url()`, `date()`). These only run in `.php` template files or when processed by WordPress. In FSE/HTML templates, replace:
- `<?php echo home_url('/'); ?>` → your site URL
- `<?php echo date('Y'); ?>` → `2026`
