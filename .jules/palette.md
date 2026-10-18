## 2024-05-14 - Keyboard Access in Image Components
**Learning:** Found that custom file upload areas (`div` elements) and zoom/navigation controls in `ImageGallery` lacked proper semantic tags (like `button`), missing ARIA labels, and had hidden controls on focus. Using `ds-focus-ring` with correct focus utilities like `focus-within` enables proper keyboard navigation without breaking visual designs.
**Action:** Consistently replace clickable `div` elements with `button` tags with `aria-label`s, add `ds-focus-ring` to interactive elements, and consider adding keyboard shortcuts (`@keydown.enter`) with tabindex="0" and `role="button"` for custom clickable zones.
## 2024-05-18 - Added focus states and aria labels to modal close buttons
**Learning:** Found an accessibility issue pattern where modal close buttons with only an `<X />` icon were missing `aria-label` attributes for screen readers and `ds-focus-ring` classes for keyboard navigation.
**Action:** When adding or reviewing modal components with icon-only close buttons, always verify that they include an `aria-label` (using translation strings like `t('common.cancel')`) and the standard `ds-focus-ring` class.
