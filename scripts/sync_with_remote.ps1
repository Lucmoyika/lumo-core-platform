<#
Script: sync_with_remote.ps1
Usage:
  - Mode sûr (par défaut): `.	ools\sync_with_remote.ps1 -Branch main -Mode safe`
    -> sauvegarde avec `git stash` si besoin, `git pull --rebase origin <branch>`
  - Mode force (destructif): `.	ools\sync_with_remote.ps1 -Branch main -Mode force`
    -> force le dépôt local pour correspondre exactement à `origin/<branch>` (perd les modifications non commit)
#>

[CmdletBinding()]
param(
    [string]
    $Branch = 'main',

    [ValidateSet('safe','force')]
    [string]
    $Mode = 'safe'
)

function Run-Git {
    param([string]$Cmd)
    Write-Host "git $Cmd"
    & git $Cmd
    if ($LASTEXITCODE -ne 0) { throw "git $Cmd a échoué (exit $LASTEXITCODE)" }
}

try {
    Write-Host "Branche choisie: $Branch | Mode: $Mode"

    # Vérifier que git est disponible
    if (-not (Get-Command git -ErrorAction SilentlyContinue)) {
        throw "git n'est pas disponible dans le PATH. Installez Git et relancez le script."
    }

    Run-Git "fetch --all"

    # Basculer sur la branche désirée
    $current = (git rev-parse --abbrev-ref HEAD).Trim()
    if ($current -ne $Branch) {
        Write-Host "Changement de branche: $current -> $Branch"
        Run-Git "checkout $Branch"
    }

    if ($Mode -eq 'safe') {
        # Si modifications non committées existent, on stash
        $status = (git status --porcelain)
        if ($status) {
            Write-Host "Modifications locales détectées — sauvegarde dans stash"
            Run-Git "stash push -m 'WIP sauvegarde avant sync'"
            $stashed = $true
        } else {
            $stashed = $false
        }

        Write-Host "Pull --rebase depuis origin/$Branch"
        Run-Git "pull --rebase origin $Branch"

        if ($stashed) {
            Write-Host "Restauration du stash"
            Run-Git "stash pop"
        }
    } else {
        # Mode force: reset hard
        Write-Host "Mode FORCE : le dépôt local sera aligné exactement sur origin/$Branch"
        Run-Git "checkout $Branch"
        Run-Git "fetch origin"
        Run-Git "reset --hard origin/$Branch"
        Run-Git "clean -fd"
    }

    Write-Host "Synchronisation terminée. Pousser les commits locaux si nécessaire."
    Write-Host "Pour pousser: git push origin $Branch"
}
catch {
    Write-Error "Erreur: $_"
    exit 1
}
