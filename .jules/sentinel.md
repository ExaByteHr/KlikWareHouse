## Sentinel Memory & Findings Journal

### Security Patterns Verified (Does NOT need fixing)
- **IDOR / Cross-Tenant Access:** Consistently prevented across the app. API controllers correctly check `$object->organization_id !== $request->user()->organization_id` before access.
- **SQL Injection in Sorting:** `orderBy` clauses safely use predefined allowlists (e.g., `in_array($request->input('sort_by'), $allowedSortColumns)`).
- **Pagination Abuse:** Enforced maximum page limits to prevent DoS (e.g., `min($request->input('per_page', 15), 100)`).
- **Zip-Slip / Archive Extraction:** `SafeZipExtractor` securely prevents path traversal (`..` escapes) and enforces size/file count limits when extracting plugin or update ZIPs.
- **Webhook Signatures:** Securely validated using HMAC-SHA256 and `hash_equals` to prevent timing attacks.
- **Authentication/Tokens:** Recovery codes and passwords use secure hashing (`hash_equals`, SHA256, and bcrypt/Argon2 via `Hash::make`).

### Known Security Posture
- **Plugins/Updates:** Plugins and updates allow RCE by design via ZIP extraction, but this is gated behind environment variables (`INVENTOROS_ALLOW_PLUGIN_UPLOADS=true`) and supports Ed25519 signature enforcement.
- **Eval/System Calls:** `exec()` is correctly used in `BackupService` with safe argument escaping (`escapeshellarg()`).

### TODOs for Future Runs
- Evaluate rate-limiting configuration across critical API endpoints (e.g., login, password reset).
- Verify Content Security Policy (CSP) implementation and other security headers.
- Audit input sanitization for XSS (especially user-provided fields displayed on the frontend).
- Check error handling configuration (ensure stack traces are properly hidden in production).
