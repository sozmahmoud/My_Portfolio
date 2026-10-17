$files = Get-ChildItem -Path 'c:\xampp\htdocs\LIORA' -Filter *.php
foreach ($file in $files) {
    $content = [System.IO.File]::ReadAllText($file.FullName)
    if ($content -match 'data-product-id="\d+"') {
        $newContent = [regex]::Replace($content, ' data-product-id="\d+"', '')
        [System.IO.File]::WriteAllText($file.FullName, $newContent, [System.Text.Encoding]::UTF8)
        Write-Host "Updated $($file.Name)"
    }
}
