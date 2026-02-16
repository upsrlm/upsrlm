$files = @(
    "c:\docker-yii2\src\upsrlm\bc\themes\field\views\layouts\main.php",
    "c:\docker-yii2\src\upsrlm\bc\themes\fiori\views\layouts\main.php"
)

foreach ($filePath in $files) {
    if (Test-Path $filePath) {
        Write-Host "Fixing URLs in: $filePath" -ForegroundColor Yellow
        
        # Read the file content
        $content = Get-Content $filePath -Raw -Encoding UTF8
        
        # Check if $baseUrl variable already exists
        if ($content -notmatch '\$baseUrl\s*=\s*Yii::') {
            Write-Host "  Adding \$baseUrl variable..." -ForegroundColor Cyan
            # Add $baseUrl variable after FieldAppAsset::register or FioriAppAsset::register
            $content = $content -replace '((?:Field|Fiori)AppAsset::register\(\$this\);)', "`$1`n`$baseUrl = Yii::`$app->request->baseUrl;"
        }
        
        # Replace hardcoded URLs with baseUrl-prefixed URLs for all BC modules
        $originalContent = $content
        
        # Training module
        $content = $content -replace 'href="/(training/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
        
        # Selection module
        $content = $content -replace 'href="/(selection/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
        
        # Report module
        $content = $content -replace 'href="/(report/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
        
        # Transaction module
        $content = $content -replace 'href="/(transaction/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
        
        # Partner agencies module
        $content = $content -replace 'href="/(partneragencies/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
        
        # MD module
        $content = $content -replace 'href="/(md/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
        
        # Corona module
        $content = $content -replace 'href="/(corona/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
        
        if ($content -ne $originalContent) {
            # Save the file
            $content | Set-Content $filePath -Encoding UTF8 -NoNewline
            Write-Host "  ✓ Fixed!" -ForegroundColor Green
        } else {
            Write-Host "  No changes needed" -ForegroundColor Gray
        }
    } else {
        Write-Host "File not found: $filePath" -ForegroundColor Red
    }
}

Write-Host "`nAll theme layout files have been updated with baseUrl prefix." -ForegroundColor Cyan
