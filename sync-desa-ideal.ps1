$provinsi = 11,12,13,14,15,16,17,18,19,21,31,32,33,34,35,36,51,52,53,61,62,63,64,65,71,72,73,74,75,76,81,82,91,92,93,94,95,96
$timestamp = Get-Date -Format "yyyyMMdd-HHmmss"
$logPath = Join-Path "storage\\logs" "sync-desa-$timestamp.log"

foreach ($id in $provinsi) {
  Write-Host "Check desa untuk provinsi $id..." -ForegroundColor Yellow
  $checkOutput = php artisan wilayah:check --provinsi=$id --depth=desa --limit=0 | Out-String
  $checkOutput | Tee-Object -FilePath $logPath -Append | Out-Null

  $missingMatch = [regex]::Match($checkOutput, "Cek desa:\s*`r?`n\s*Missing:\s*(\d+)")
  $missingCount = if ($missingMatch.Success) { [int]$missingMatch.Groups[1].Value } else { -1 }

  if ($missingCount -eq 0) {
    Write-Host "Skip provinsi $id (Missing desa: 0)." -ForegroundColor Green
    continue
  }

  Write-Host "Sync desa untuk provinsi $id..." -ForegroundColor Cyan
  $syncOutput = php artisan wilayah:sync --provinsi=$id --depth=desa | Out-String
  $syncOutput | Tee-Object -FilePath $logPath -Append | Out-Null
}

Write-Host "Selesai. Log tersimpan di $logPath" -ForegroundColor Green
