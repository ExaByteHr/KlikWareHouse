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
## 2025-01-20 - [Sentinel Initial Security Sweep]
**Vulnerability:** No immediate critical vulnerabilities (< 50 lines fixable) were found.
**Learning:**
- The codebase relies heavily on Vue's `v-html` directive (e.g. `v-html="link.label"` in pagination and occasionally for messages). While this is mostly for rendering trusted links, future Sentinel sessions should closely monitor any user-controlled data being passed to `v-html` which could introduce Cross-Site Scripting (XSS).
- The `SafeZipExtractor` service successfully protects against zip-slip path traversal during plugin uploads and updates by validating archive contents.
- There are occurrences of SQL `DB::raw`, `whereRaw`, `selectRaw` and `orderByRaw`, but they appear to use static strings, enums, or well-controlled schema inputs (e.g., column names). SQL injection vectors were not immediately evident, but should be monitored.
- Content Security Policy (CSP) is implemented in `SecurityHeaders.php` but relies on `'unsafe-inline'` for `style-src`.
**Prevention:**
- Maintain strict control over data assigned to `v-html`. Avoid using user inputs here.
- Maintain the `SafeZipExtractor` logic for all archive processing.

### TODOs for future Sentinel sessions:
- Deep dive into any dynamic inputs rendering through `v-html`.
- Determine if the `unsafe-inline` directive in the Content Security Policy can be safely removed or replaced with strict nonces or hashes for styles.
- Regularly audit `DB::raw` occurrences.

**Note to Future Sentinels:** Please continue documenting your findings, learnings, and any new TODOs in this `.jules/sentinel.md` journal. Only add entries for CRITICAL security learnings as defined in your system prompt.
