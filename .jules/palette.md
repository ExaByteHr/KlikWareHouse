## 2023-10-24 - Standardizing Focus Rings
**Learning:** This app uses a custom Tailwind class `ds-focus-ring` for standardizing focus indicators across interactive components.
**Action:** Always append `ds-focus-ring` instead of default Tailwind focus rings (`focus:ring`, `focus-visible:ring`) when adding or modifying interactive elements to maintain visual consistency.
## 2024-05-14 - Keyboard Access in Image Components
**Learning:** Found that custom file upload areas (`div` elements) and zoom/navigation controls in `ImageGallery` lacked proper semantic tags (like `button`), missing ARIA labels, and had hidden controls on focus. Using `ds-focus-ring` with correct focus utilities like `focus-within` enables proper keyboard navigation without breaking visual designs.
**Action:** Consistently replace clickable `div` elements with `button` tags with `aria-label`s, add `ds-focus-ring` to interactive elements, and consider adding keyboard shortcuts (`@keydown.enter`) with tabindex="0" and `role="button"` for custom clickable zones.
## 2024-05-18 - Added focus states and aria labels to modal close buttons
**Learning:** Found an accessibility issue pattern where modal close buttons with only an `<X />` icon were missing `aria-label` attributes for screen readers and `ds-focus-ring` classes for keyboard navigation.
**Action:** When adding or reviewing modal components with icon-only close buttons, always verify that they include an `aria-label` (using translation strings like `t('common.cancel')`) and the standard `ds-focus-ring` class.
## 2024-05-14 - Standardize Top Navigation Icon Accessibility
**Learning:** Found multiple icon-only buttons in top navigation (ThemeToggle, NotificationDropdown) that were missing proper screen reader attributes and focus indication class. In this app, many icon buttons correctly use the `ds-focus-ring` class for focus consistency but top nav buttons were missed.
**Action:** Always verify icon-only buttons have an `aria-label` matching their `title` attribute for screen readers, and utilize the `ds-focus-ring` class to maintain consistent keyboard navigation focus states across the app.
