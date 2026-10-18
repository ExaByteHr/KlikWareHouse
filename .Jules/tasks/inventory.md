# Inventory Subsystem Task Checklist

This checklist tracks tasks for expanding the documentation, testing, and UI consistency for the Inventory management subsystem of Inventoros.

## End-User Documentation
- [x] Create `docs/site/sections/inventory-management.md` overview.
- [x] Register `inventory-management` in `docs/site/docs.json`.
- [ ] Expand `inventory-management.md` with UI walkthroughs for creating a Product.
- [ ] Add API usage examples for Stock Adjustments to `inventory-management.md` or `rest-api.md`.
- [ ] Document the Approval workflow for manual Stock Adjustments in a new section (or append to Inventory).

## Architecture & Testing
- [ ] Ensure `app/Models/Inventory/Product.php` has complete test coverage in `tests/Feature/Inventory/ProductTest.php`.
- [ ] Verify `app/Services/ProductService.php` handles edge cases for variant creation (check `tests/Unit/Services/ProductServiceTest.php`).
- [ ] Audit `StockAdjustmentRequest.php` for proper approval state transitions (Draft -> Pending -> Approved/Rejected).

## Frontend & UI (Inertia/Vue)
- [ ] Audit `resources/js/Pages/Products/Index.vue` and `Create.vue` for proper ARIA labels and `ds-focus-ring` classes on interactive elements (as noted in `.Jules/palette.md`).
- [ ] Check keyboard accessibility for the batch/serial selection modals in the Stock Adjustment UI.
