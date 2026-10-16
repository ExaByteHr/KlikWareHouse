## 2024-10-16 - Add ARIA label and focus styles to close button
**Learning:** Found that an icon-only button in the BarcodeScannerModal lacked an `aria-label` and visual focus styles, causing poor accessibility for screen reader and keyboard users. Added `t('common.cancel')` and `ds-focus-ring` to fix this.
**Action:** Always ensure icon-only buttons have an `aria-label` and `ds-focus-ring` applied, especially for modal close buttons.
