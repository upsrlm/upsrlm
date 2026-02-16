$filePath = "c:\docker-yii2\src\upsrlm\bc\themes\field\views\layouts\main.php"

Write-Host "Fixing URLs in: $filePath" -ForegroundColor Yellow

# Read the file content
$content = Get-Content $filePath -Raw -Encoding UTF8

# Replace hardcoded URLs with baseUrl-prefixed URLs for all BC modules
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

# Save the file
$content | Set-Content $filePath -Encoding UTF8 -NoNewline

Write-Host "✓ Fixed!" -ForegroundColor Green
Write-Host "All href URLs in the theme layout have been updated with baseUrl prefix." -ForegroundColor Cyan
