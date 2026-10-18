# Inventory Management

The inventory subsystem is the core of Inventoros, designed to handle products, stock levels, variants, and detailed tracking across multiple locations and warehouses.

## Products & Variants

Products are the fundamental items tracked in the system. They can be standard items, assemblies (built from a bill of materials), or services (which do not track stock).

- **Options and Variants:** A product can have multiple options (e.g., Color, Size), generating specific variants (e.g., Red-Large). Stock is typically tracked at the variant level if variants are configured.
- **Components (BOM):** Products can act as assemblies containing components. See the [Work Orders](#work-orders) section for how assemblies are built and stock is consumed.

## Tracking Types

Inventoros supports strict tracking for high-value or perishable goods:
- **Serial Tracking:** Each unit of a product has a unique serial number. Stock movements, adjustments, and order fulfillments require specifying the exact serial numbers involved.
- **Batch Tracking:** Products are tracked by batches or lots, which can optionally have expiry dates. This is critical for FIFO/FEFO accounting and quality control.
- **No Tracking:** Standard quantity-based tracking without specific serials or batches.

## Stock Levels & Locations

Stock is managed hierarchically to provide exact visibility:
- **Warehouses:** High-level storage facilities.
- **Locations (Bins/Aisles):** Specific areas within a warehouse where stock is physically kept.
- **Reorder Points:** Minimum stock thresholds that trigger reorder alerts or automatically populate purchase orders.

## Stock Movements

Stock is never updated arbitrarily; all changes are recorded through specific, auditable actions:

- **Stock Transfers:** Moving stock between warehouses or locations within the same organization.
- **Inter-company Transfers:** Moving stock between different legal entities or organizations managed within the multi-tenant setup.
- **Stock Adjustments:** Manual corrections to stock levels (e.g., write-offs for damage or shrinkage). These require a reason code and optionally an approval workflow.

## Audits & Cycle Counts

Regular stock verification is supported through:
- **Stock Audits (Full Physical Inventory):** A comprehensive process to freeze stock, count physical quantities, and apply bulk adjustments based on variances.
- **Cycle Counts:** Scheduled, partial counts of specific locations or high-value items (ABC analysis), ensuring continuous accuracy without shutting down operations.
