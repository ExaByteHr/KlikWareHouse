# Inventoros Jules AI Roadmap & Checklists

This document serves as a centralized roadmap for future Jules AI runs. It lists specific subsystems and features within Inventoros that need documentation, testing, or architectural review.

## Inventory Subsystem

### Documentation Tasks
- [ ] Create `docs/site/sections/inventory-management.md` detailing:
  - Products, Variants, and Options.
  - Tracking types (Batch, Serial, None).
  - Stock levels (Locations, Warehouses, Reorder Points).
  - Inter-company Transfers, Stock Transfers, and Stock Adjustments.
  - Stock Audits & Cycle Counts.
- [ ] Update `docs/site/docs.json` to include the `inventory-management` section.

### Code & Architecture Tasks
- [ ] Review `app/Models/Inventory` and `app/Services/ProductService.php` to identify any missing unit or feature tests.
- [ ] Audit frontend views under `resources/js/Pages/Products`, `resources/js/Pages/Locations`, and `resources/js/Pages/Warehouses` for proper `ds-focus-ring` semantic tags and accessibility (as per `palette.md`).

## Purchasing / Suppliers
- [ ] ...

## Sales / Orders
- [ ] ...
