# BC Module URL Routing Fix

## Problem
Menu links and URLs in the `/bc/` module were missing the `/bc/` prefix, causing 404 errors and incorrect redirects.

## Root Cause
- Hardcoded URLs with leading slash (e.g., `/training/participants/certified`) 
- These URLs resolve from web root instead of `/bc/` base path
- Should be relative (e.g., `training/participants/certified`) or use Yii2 URL helpers

## Backup Created
**Git Branch:** `backup-before-url-fix-2026-02-14-105318`

To restore if needed:
```bash
git checkout backup-before-url-fix-2026-02-14-105318
```

## Files to be Fixed

### Priority 1: Module Views (Form Actions in JavaScript)
These files contain form action URLs that need the `/bc/` prefix:

1. **Training Module Views:**
   - bc/modules/training/views/certified/*.php
   - bc/modules/training/views/participants/*.php
   - bc/modules/training/views/preselected/*.php
   - bc/modules/training/views/honorarium/*.php

2. **Report Module Views:**
   - bc/modules/report/views/**/*.php

3. **Selection Module Views:**
   - bc/modules/selection/views/**/*.php

4. **Transaction Module Views:**
   - bc/modules/transaction/views/**/*.php

5. **Partner Agencies Module Views:**
   - bc/modules/partneragencies/views/**/*.php

### Priority 2: Theme/Layout Files
- bc/themes/fiori/views/layouts/main.php
- bc/themes/field/views/layouts/main.php

### Priority 3: Widget Views
- bc/widgets/bc/views/*.php

## Fix Pattern

### JavaScript Form Actions
**BEFORE:**
```javascript
$("#Searchform").attr({ "action":"/training/participants/certified"});
```

**AFTER:**
```javascript
$("#Searchform").attr({ "action":"<?= Yii::$app->request->baseUrl ?>/training/participants/certified"});
```

### Menu Links
**BEFORE:**
```php
<a href="/training/participants/certified">Certified</a>
```

**AFTER:**
```php
<?= Html::a('Certified', ['training/participants/certified']) ?>
// OR
<a href="<?= Yii::$app->request->baseUrl ?>/training/participants/certified">Certified</a>
```

### Button/Modal Value Attributes
**BEFORE:**
```php
'value' => '/training/participants/view?participantid=' . $model->id
```

**AFTER:**
```php
'value' => Yii::$app->request->baseUrl . '/training/participants/view?participantid=' . $model->id
```

## Testing After Fix
1. Navigate to: http://upsrlm.local:8080/bc/report/cumulative/pendencyd
2. Click menu links (e.g., "Training > Participants > Certified")
3. Verify URLs resolve correctly with `/bc/` prefix
4. Test form submissions and AJAX requests
5. Check modal popups and dynamic content

## Rollback Instructions
If something goes wrong:
```bash
cd c:\docker-yii2\src\upsrlm
git checkout backup-before-url-fix-2026-02-14-105318
```

Then hard reset current branch:
```bash
git reset --hard
```
