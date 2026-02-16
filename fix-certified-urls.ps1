# Simple BC URL Fix - Replace hardcoded module URLs with baseUrl prefix
$filePath = "c:\docker-yii2\src\upsrlm\bc\modules\training\views\participants\certified.php"

Write-Host "Fixing: $filePath" -ForegroundColor Yellow

$content = Get-Content $filePath -Raw -Encoding UTF8

# Fix 'value' => '/training/... patterns
$content = $content -replace "('value'\s*=>\s*')/(training/[^']+)", "`$1<?= Yii::\`$app->request->baseUrl ?>/`$2"

Set-Content $filePath -Value $content -Encoding UTF8 -NoNewline

Write-Host "✓ Fixed!" -ForegroundColor Green
