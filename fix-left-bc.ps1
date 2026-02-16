$filePath = "c:\docker-yii2\src\upsrlm\common\themes\smartadmin\views\layouts\left_bc.php"

Write-Host "Fixing URLs in: left_bc.php" -ForegroundColor Yellow

# Read the file content
$content = Get-Content $filePath -Raw -Encoding UTF8

# Check if $baseUrl variable already exists in the file
if ($content -notmatch '\$baseUrl\s*=') {
    Write-Host "  Adding \$baseUrl variable..." -ForegroundColor Cyan
    # Add $baseUrl variable after the use statement
    $content = $content -replace '(use common\\models\\master\\MasterRole;)', "`$1`n`$baseUrl = Yii::`$app->request->baseUrl;"
}

# Count URLs before fixing
$beforeCount = ([regex]::Matches($content, 'href="/(training|selection|report|transaction|partneragencies|md|corona)/')).Count
Write-Host "  Found $beforeCount hardcoded URLs to fix" -ForegroundColor Yellow

# Replace hardcoded URLs with baseUrl-prefixed URLs for all BC modules
$content = $content -replace 'href="/(training/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
$content = $content -replace 'href="/(selection/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
$content = $content -replace 'href="/(report/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
$content = $content -replace 'href="/(transaction/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
$content = $content -replace 'href="/(partneragencies/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
$content = $content -replace 'href="/(md/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'
$content = $content -replace 'href="/(corona/[^"]+)"', 'href="<?= $baseUrl ?>/$1"'

# Count URLs after fixing
$afterCount = ([regex]::Matches($content, '<\?=\s*\$baseUrl\s*\?>')).Count
Write-Host "  Fixed $afterCount URLs with baseUrl prefix" -ForegroundColor Green

# Save the file
$content | Set-Content $filePath -Encoding UTF8 -NoNewline

Write-Host "`n✓ Done!" -ForegroundColor Green
Write-Host "All menu URLs in left_bc.php have been updated." -ForegroundColor Cyan
Write-Host "Please clear your browser cache (Ctrl+F5) and try again." -ForegroundColor Yellow
