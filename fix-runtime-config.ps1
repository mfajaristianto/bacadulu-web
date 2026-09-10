param(
    [string]$ProjectRoot = "D:\Pkl\landing-page"
)

$ErrorActionPreference = "Stop"

function Set-EnvValue {
    param(
        [string]$Path,
        [string]$Key,
        [string]$Value
    )

    if (-not (Test-Path $Path)) {
        return
    }

    $content = Get-Content $Path -Raw
    $escapedKey = [regex]::Escape($Key)
    $pattern = "(?m)^\s*${escapedKey}\s*=.*$"
    $line = "${Key}=${Value}"

    if ([regex]::IsMatch($content, $pattern)) {
        $content = [regex]::Replace($content, $pattern, $line, 1)
    } else {
        if ($content.Length -gt 0 -and -not $content.EndsWith("`n")) {
            $content += "`r`n"
        }

        $content += "${line}`r`n"
    }

    Set-Content -Path $Path -Value $content -Encoding UTF8
}

$root = Resolve-Path $ProjectRoot
Set-Location $root

$timestamp = Get-Date -Format "yyyyMMdd-HHmmss"

if (-not (Test-Path ".env")) {
    throw ".env tidak ditemukan di $root"
}

if (-not (Test-Path "config\app.php")) {
    throw "config\app.php tidak ditemukan di $root"
}

Copy-Item ".env" ".env.backup-$timestamp" -Force
Copy-Item "config\app.php" "config\app.php.backup-$timestamp" -Force

Set-EnvValue ".env" "APP_NAME" '"Baca Dulu"'
Set-EnvValue ".env" "APP_TIMEZONE" "Asia/Jakarta"
Set-EnvValue ".env" "APP_LOCALE" "id"
Set-EnvValue ".env" "APP_FALLBACK_LOCALE" "en"
Set-EnvValue ".env" "APP_FAKER_LOCALE" "id_ID"

if (Test-Path ".env.example") {
    Set-EnvValue ".env.example" "APP_NAME" '"Baca Dulu"'
    Set-EnvValue ".env.example" "APP_TIMEZONE" "Asia/Jakarta"
    Set-EnvValue ".env.example" "APP_LOCALE" "id"
    Set-EnvValue ".env.example" "APP_FALLBACK_LOCALE" "en"
    Set-EnvValue ".env.example" "APP_FAKER_LOCALE" "id_ID"
}

$appConfig = Get-Content "config\app.php" -Raw

$timezonePattern = "(?m)^(\s*)'timezone'\s*=>\s*(?:'[^']*'|env\(\s*'APP_TIMEZONE'[^)]*\))\s*,"
$timezoneReplacement = '$1' + "'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),"

if ([regex]::IsMatch($appConfig, $timezonePattern)) {
    $appConfig = [regex]::Replace(
        $appConfig,
        $timezonePattern,
        $timezoneReplacement,
        1
    )

    Set-Content "config\app.php" -Value $appConfig -Encoding UTF8
}

$php = "C:\xampp\php\php.exe"

if (-not (Test-Path $php)) {
    $php = "php"
}

& $php artisan optimize:clear

Write-Host ""
Write-Host "Selesai. Verifikasi:" -ForegroundColor Green
Write-Host '  & "C:\xampp\php\php.exe" artisan about'
