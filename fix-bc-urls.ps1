# BC Module URL Fix Script
# This script fixes URL routing issues by adding baseUrl prefix

Write-Host "=== BC Module URL Fix Script ===" -ForegroundColor Cyan
Write-Host "Backup branch: backup-before-url-fix-2026-02-14-105318" -ForegroundColor Green
Write-Host ""

$baseDir = "c:\docker-yii2\src\upsrlm\bc"
$fixedCount = 0
$errorCount = 0

# Function to fix JavaScript form actions
function Fix-FormActions {
    param([string]$filePath)
    
    try {
        $content = Get-Content $filePath -Raw -Encoding UTF8
        $originalContent = $content
        
        # Pattern 1: Fix form action attributes in JavaScript
        $content = $content -replace '([\s\(])action[""'']:[\s]*[""]/(training|report|selection|partneragencies|transaction|md|corona)/', '$1action":"<?= Yii::$app->request->baseUrl ?>/$2/'
        
        # Pattern 2: Fix value attributes with leading slash for module routes
        $content = $content -replace '([''"]value[''"][\s]*=>[\s]*[''"]\s*)/(training|report|selection|partneragencies|transaction|md|corona)/', '$1<?= Yii::$app->request->baseUrl ?>/$2/'
        
        if ($content -ne $originalContent) {
            Set-Content $filePath -Value $content -Encoding UTF8 -NoNewline
            return $true
        }
        return $false
    }
    catch {
        Write-Host "Error processing $filePath : $_" -ForegroundColor Red
        return $false
    }
}

# Function to fix HTML href attributes
function Fix-HtmlLinks {
    param([string]$filePath)
    
    try {
        $content = Get-Content $filePath -Raw -Encoding UTF8
        $originalContent = $content
        
        # Fix href attributes in anchor tags
        $content = $content -replace '(<a[\s]+[^>]*href=[""])/(training|report|selection|partneragencies|transaction|md|corona)/', '$1<?= Yii::$app->request->baseUrl ?>/$2/'
        
        if ($content -ne $originalContent) {
            Set-Content $filePath -Value $content -Encoding UTF8 -NoNewline
            return $true
        }
        return $false
    }
    catch {
        Write-Host "Error processing $filePath : $_" -ForegroundColor Red
        return $false
    }
}

Write-Host "Searching for files to fix..." -ForegroundColor Yellow

# Get all PHP view files in modules
$viewFiles = Get-ChildItem -Path "$baseDir\modules" -Filter "*.php" -Recurse | Where-Object { $_.FullName -match "\\views\\" }

Write-Host "Found $($viewFiles.Count) view files to process" -ForegroundColor Cyan
Write-Host ""

foreach ($file in $viewFiles) {
    $relativePath = $file.FullName.Replace("c:\docker-yii2\src\upsrlm\", "")
    
    # Check if file contains problematic patterns
    $content = Get-Content $file.FullName -Raw -Encoding UTF8
    
    if ($content -match '["'']/(training|report|selection|partneragencies|transaction|md|corona)/') {
        Write-Host "Processing: $relativePath" -ForegroundColor Yellow
        
        $jsFixed = Fix-FormActions -filePath $file.FullName
        $htmlFixed = Fix-HtmlLinks -filePath $file.FullName
        
        if ($jsFixed -or $htmlFixed) {
            $fixedCount++
            Write-Host "  ✓ Fixed" -ForegroundColor Green
        }
        else {
            Write-Host "  - No changes needed" -ForegroundColor Gray
        }
    }
}

# Fix theme layout files separately
$themeFiles = @(
    "$baseDir\themes\fiori\views\layouts\main.php",
    "$baseDir\themes\field\views\layouts\main.php"
)

Write-Host ""
Write-Host "Processing theme layout files..." -ForegroundColor Yellow

foreach ($themePath in $themeFiles) {
    if (Test-Path $themePath) {
        $relativePath = $themePath.Replace("c:\docker-yii2\src\upsrlm\", "")
        Write-Host "Processing: $relativePath" -ForegroundColor Yellow
        
        $fixed = Fix-HtmlLinks -filePath $themePath
        if ($fixed) {
            $fixedCount++
            Write-Host "  ✓ Fixed" -ForegroundColor Green
        }
    }
}

# Fix widget files
Write-Host ""
Write-Host "Processing widget files..." -ForegroundColor Yellow

$widgetFiles = Get-ChildItem -Path "$baseDir\widgets" -Filter "*.php" -Recurse -ErrorAction SilentlyContinue

foreach ($file in $widgetFiles) {
    $content = Get-Content $file.FullName -Raw -Encoding UTF8
    
    if ($content -match '["'']/(training|report|selection|partneragencies|transaction|md|corona)/') {
        $relativePath = $file.FullName.Replace("c:\docker-yii2\src\upsrlm\", "")
        Write-Host "Processing: $relativePath" -ForegroundColor Yellow
        
        $fixed = Fix-HtmlLinks -filePath $file.FullName
        if ($fixed) {
            $fixedCount++
            Write-Host "  ✓ Fixed" -ForegroundColor Green
        }
    }
}

Write-Host ""
Write-Host "=== Fix Summary ===" -ForegroundColor Cyan
Write-Host "Files fixed: $fixedCount" -ForegroundColor Green
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "1. Test the application at: http://upsrlm.local:8080/bc/" -ForegroundColor White
Write-Host "2. Click menu links and verify routes work correctly" -ForegroundColor White
Write-Host "3. If issues occur, rollback with:" -ForegroundColor White
Write-Host "   git checkout backup-before-url-fix-2026-02-14-105318" -ForegroundColor Cyan
Write-Host ""
