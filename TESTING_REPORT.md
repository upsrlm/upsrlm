# BC Module URL Routing Fix - Complete Report

## Problem Summary
Menu links and form actions in the BC module were using absolute URLs (e.g., `/training/participants/certified`) instead of including the `/bc/` base path, causing 404 errors and incorrect redirects when clicking menu links.

## Root Cause
- The BC module is mounted at `/bc/` (http://upsrlm.local:8080/bc/)
- URLs starting with `/` are resolved from the web root, not from `/bc/`
- Should use `Yii::$app->request->baseUrl` to prepend the correct base path

## Backup Created
**Git Branch:** `backup-before-url-fix-2026-02-14-105318`

**To restore if needed:**
```bash
cd c:\docker-yii2\src\upsrlm
git checkout backup-before-url-fix-2026-02-14-105318
git reset --hard
```

## Files Modified

### 1. bc/modules/training/views/participants/certified.php
**Changes Applied:**
- ✅ Fixed JavaScript form actions to include `$baseUrl` prefix
- ✅ Fixed modal popup value attributes for all buttons
- ✅ Fixed BC name link in GridView

**Specific Fixes:**
```php
// BEFORE:
$("#Searchform").attr({ "action":"/training/participants/certified"});
'value' => '/training/participants/view?participantid=' . $model->id

// AFTER:
$("#Searchform").attr({ "action":"$baseUrl/training/participants/certified"});
'value' => <?= Yii::$app->request->baseUrl ?>/training/participants/view?participantid=' . $model->id
```

**Buttons/Actions Fixed:**
- Download BC Bank CSV
- Download CSV
- Download Pendency
- CSV Support
- Search form
- PAN Card available
- Handheld Machine provided
- Onboarding
- Change Onboarding
- BC-SHG Beneficiaries code
- Update BC Name and Phone No
- Confirm BC Settlement Bank
- View BC GP SHG
- Unwilling BC
- BC name modal popup

## Testing Instructions

### Test 1: Navigate to Report Page
1. Open browser: http://upsrlm.local:8080/bc/
2. Login to the system
3. Navigate to: http://upsrlm.local:8080/bc/report/cumulative/pendencyd
4. **Expected:** Page loads successfully

### Test 2: Click Training Menu
1. From the pendencyd page, click on "Training" menu
2. Click on "Participants" submenu
3. Click on "Certified"
4. **Expected URL:** http://upsrlm.local:8080/bc/training/participants/certified
5. **Expected:** Page loads without 404 error

### Test 3: Test Form Submissions
1. On the Certified page, use the search form
2. Click "Search" button
3. **Expected:** Form submits to `/bc/training/participants/certified`
4. **Expected:** Results display correctly

### Test 4: Test Download Buttons
1. Click "Download CSV" button
2. **Expected:** Downloads from `/bc/training/participants/downloadcsv`
3. Repeat for other download buttons

### Test 5: Test Modal Popups
1. Click on a BC name link (opens modal)
2. **Expected:** Modal loads participant details from `/bc/training/participants/view`
3. Click action buttons (PAN Card, Onboarding, etc.)
4. **Expected:** Modals open correctly with data

### Test 6: Test Dropdown Actions
1. Change district or block dropdown
2. **Expected:** Form auto-submits to `/bc/training/participants/certified`
3. **Expected:** Results filter correctly

## Additional Files That May Need Fixing

Based on the search results, these files also contain similar URL patterns and may need fixes:

### High Priority (Training Module):
- bc/modules/training/views/participants/index.php
- bc/modules/training/views/participants/verification.php
- bc/modules/training/views/participants/pfmspayment.php
- bc/modules/training/views/participants/paytm.php
- bc/modules/training/views/preselected/*.php
- bc/modules/training/views/certified/*.php

### Medium Priority (Other Modules):
- bc/modules/report/views/**/*.php
- bc/modules/selection/views/**/*.php
- bc/modules/transaction/views/**/*.php

### Low Priority (Themes):
- bc/themes/fiori/views/layouts/main.php
- bc/themes/field/views/layouts/main.php

## How to Fix Additional Files

**Pattern to find:**
```bash
grep -r "action.*['\"]/(training|report|selection)" bc/modules/*/views/
```

**Fix pattern:**
```php
// JavaScript form actions:
$("#Searchform").attr({ "action":"<?= Yii::$app->request->baseUrl ?>/training/..."});

// OR use variable:
$baseUrl = Yii::$app->request->baseUrl;
$js = <<<JS
$("#form").attr({ "action":"$baseUrl/training/..."});
JS;

// Button value attributes:
'value' => Yii::$app->request->baseUrl . '/training/participants/view?id=' . $model->id

// HTML links:
<a href="<?= Yii::$app->request->baseUrl ?>/training/participants/certified">Certified</a>
```

## Troubleshooting

### If pages still show 404:
1. Clear browser cache (Ctrl+F5)
2. Check PHP error logs: `docker-compose logs php`
3. Verify URL in browser address bar includes `/bc/`

### If forms don't submit correctly:
1. Open browser DevTools (F12)
2. Check Network tab when clicking submit
3. Verify form action includes `/bc/` prefix

### If you need to rollback:
```bash
cd c:\docker-yii2\src\upsrlm
git status  # Check current changes
git checkout backup-before-url-fix-2026-02-14-105318
git reset --hard
```

## Summary of Changes
- ✅ Created backup branch: `backup-before-url-fix-2026-02-14-105318`
- ✅ Fixed JavaScript form actions in certified.php
- ✅ Fixed all button/modal value attributes in certified.php
- ✅ Fixed BC name link in GridView
- ✅ Added `$baseUrl` variable for cleaner JavaScript code
- ✅ Created documentation and testing instructions

## Next Steps
1. Test the fixed certified.php page thoroughly
2. If working correctly, apply the same fixes to other view files
3. Consider creating a helper function or widget to generate URLs consistently
4. Update coding standards to always use `Yii::$app->request->baseUrl` for module URLs

## Files Created or Modified
- ✅ URL_FIX_CHANGES.md - Detailed change documentation
- ✅ fix-bc-urls.ps1 - Automated fix script (for reference)
- ✅ fix-certified-urls.ps1 - Applied fix script
- ✅ TESTING_REPORT.md - This file (testing instructions)
- ✅ bc/modules/training/views/participants/certified.php - **MODIFIED**

## Contact/Support
If issues persist after applying these fixes, check:
1. Yii2 URL Manager configuration in `bc/config/main.php`
2. Base URL setting in web server configuration
3. .htaccess or nginx conf for proper rewrite rules

# Android App Testing Report - BC Selection (Local)

## Scope
Validate the Android BC Selection app against local API services, including GP list loading, login OTP flow, and basic stability.

## Test Environment
- Date: 2026-02-15
- Android: Emulator (10.0.2.2) connected to local API
- API base URL (debug): http://10.0.2.2:8082/bcselection/
- API container: upsrlm-api-1
- DB container: yii2_mysql (ho_bc_selection)

## Preconditions
- API service running and reachable on http://localhost:8082
- GP list endpoint returns HTTP 200
- Test mobile number present in API test list

## Test Phases and Results

### Phase 1: API Health Check
**Steps:**
1. Send POST to /bcselection/user/getgp with form-data: app_id=0, imei_no, app_version, data JSON.
2. Verify HTTP status and JSON structure.

**Expected:**
- HTTP 200
- Top-level keys: status, message, data, support_text

**Result:**
- PASS. HTTP 200 and valid JSON structure confirmed.

### Phase 2: GP List Load (Login Screen)
**Steps:**
1. Launch app and wait for GP list to load on login screen.
2. Open district and GP dropdowns.

**Expected:**
- District and GP dropdowns populate.

**Result:**
- PASS. GP dropdown populated from DB-backed API.

### Phase 3: Login Request
**Steps:**
1. Enter mobile number: 9598830000
2. Tap Login.
3. Observe navigation to OTP screen.

**Expected:**
- OTP screen appears.

**Result:**
- PASS. OTP screen shown after login.

### Phase 4: OTP Verification (Local Test)
**Steps:**
1. Enter OTP: 000000
2. Tap Verify.

**Expected:**
- App proceeds to next screen after OTP verification.

**Result:**
- PASS. OTP verification successful using fixed test OTP.

## Notes and Observations
- Local SMS delivery is not expected; OTP is validated via fixed test OTP for test numbers.
- Large GP payload can cause UI jank; consider server-side filtering or client-side optimizations if needed.

## Test Data
- Test mobile: 9598830000
- Test OTP: 000000

## Known Limitations
- SMS gateway is not configured for local environment.
- GP response size is large; performance may degrade on low-end devices.

## Recommendations
- Add server-side filtering for GP list to reduce payload size.
- Disable full response body logging in Android for large API responses.
