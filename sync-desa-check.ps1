$provinsi = 11,12,13,14,15,16,17,18,19,21,31,32,33,34,35,36,51,52,53,61,62,63,64,65,71,72,73,74,75,76,81,82,91,92,93,94,95,96

foreach ($id in $provinsi) {
  Write-Host "Check desa untuk provinsi $id..." -ForegroundColor Yellow
  php artisan wilayah:check --provinsi=$id --depth=desa --limit=0
  Write-Host "Sync desa untuk provinsi $id..." -ForegroundColor Cyan
  php artisan wilayah:sync --provinsi=$id --depth=desa
}
