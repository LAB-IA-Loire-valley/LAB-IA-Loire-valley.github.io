# ============================================
# LAB'IA WordPress - Test Script
# ============================================
# Usage: .\test-labia.ps1
# Tests all pages via both localhost and LAN IP

$ErrorActionPreference = "Stop"

# Configuration
$LocalUrl = "http://localhost:8082"
$LanUrl   = "http://10.0.18.56:8082"

$Pages = @(
    @{ Path = "/";                  Name = "Accueil" }
    @{ Path = "/notre-offre/";      Name = "Notre Offre" }
    @{ Path = "/nos-solutions/";    Name = "Nos Solutions" }
    @{ Path = "/qui-sommes-nous/";  Name = "Qui sommes-nous" }
    @{ Path = "/ils-nous-font-confiance/"; Name = "Ils nous font confiance" }
    @{ Path = "/partenariat/";      Name = "Partenariat" }
    @{ Path = "/presse/";           Name = "Presse" }
    @{ Path = "/contact/";          Name = "Contact" }
    @{ Path = "/actualites/";       Name = "Actualités" }
    @{ Path = "/wp-admin/";         Name = "Admin login" }
)

# Banner
Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  LAB'IA WordPress — Test complet" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  Local URL : $LocalUrl" -ForegroundColor Gray
Write-Host "  LAN URL   : $LanUrl" -ForegroundColor Gray
Write-Host ""

function Test-Url {
    param([string]$Url, [string]$PageName, [string]$PagePath)

    try {
        $request = [System.Net.HttpWebRequest]::Create($Url)
        $request.Timeout = 10000
        $request.UserAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) PowerShell-Test"
        $request.AllowAutoRedirect = $true

        $response = $request.GetResponse()
        $statusCode = [int]$response.StatusCode
        $contentLength = $response.ContentLength
        $finalUrl = $response.ResponseUri.AbsoluteUri
        $response.Close()

        $content = ""
        if ($statusCode -eq 200) {
            $req2 = [System.Net.HttpWebRequest]::Create($Url)
            $req2.Timeout = 10000
            $req2.UserAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) PowerShell-Test"
            $sr = New-Object System.IO.StreamReader($req2.GetResponse().GetResponseStream())
            $content = $sr.ReadToEnd()
            $sr.Close()
        }

        $color = if ($statusCode -eq 200) { "Green" }
                 elseif ($statusCode -eq 301 -or $statusCode -eq 302) { "Yellow" }
                 else { "Red" }

        $sizeKB = [math]::Round($contentLength / 1024, 1)
        Write-Host ("  {0,-30} {1}  {2} {3} KB" -f $PageName, $statusCode, $sizeKB, "KB") -ForegroundColor $color

        # Check that the page contains the expected content
        if ($statusCode -eq 200 -and $content.Length -gt 0) {
            $hasTitle = $content -match "LAB.IA Loire Valley"
            $hasNav = $content -match 'class="nav '
            $hasHero = $content -match "hero__title" -or $content -match "page-hero"

            $checks = @()
            $checks += if ($hasTitle) { "✓titre" } else { "✗titre" }
            $checks += if ($hasNav)  { "✓nav" }   else { "✗nav" }
            $checks += if ($hasHero) { "✓hero" }  else { "✗hero" }
            Write-Host ("    └─ contenu: " -NoNewline) -ForegroundColor Gray
            Write-Host ($checks -join "  ") -ForegroundColor $(if ($hasTitle -and $hasNav) { "Green" } else { "Yellow" })
        }
    }
    catch {
        Write-Host "  $PageName — ERREUR: $($_.Exception.Message)" -ForegroundColor Red
    }
}

# Test localhost
Write-Host "[1] TEST VIA LOCALHOST" -ForegroundColor Yellow
Write-Host "--------------------------------------------" -ForegroundColor DarkGray
foreach ($page in $Pages) {
    $url = $LocalUrl + $page.Path
    Test-Url -Url $url -PageName $page.Name -PagePath $page.Path
}

Write-Host ""

# Test LAN IP
Write-Host "[2] TEST VIA LAN IP" -ForegroundColor Yellow
Write-Host "--------------------------------------------" -ForegroundColor DarkGray
foreach ($page in $Pages) {
    $url = $LanUrl + $page.Path
    Test-Url -Url $url -PageName $page.Name -PagePath $page.Path
}

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  FIN DES TESTS" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Si tous les tests sont en vert : le site marche" -ForegroundColor Green
Write-Host "Si des tests sont en rouge : vérifie Docker et le port forwarding WSL" -ForegroundColor Yellow
Write-Host ""
