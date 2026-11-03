@echo off
rem ============================================================================================
rem  seance.bat : met le depot du cours a l'etat d'une seance, puis prepare la machine Docker.
rem
rem  Sur votre ordinateur, dans le dossier du depot du cours (tp-framework-php) :
rem      .\seance.bat 03            depuis PowerShell ou le terminal de VS Code
rem      seance 03                  depuis l'invite de commandes (cmd)
rem      double-clic                le script demande le numero de la seance
rem
rem  ATTENTION : toutes vos modifications DANS CE DOSSIER sont effacees. C'est voulu : toute la classe
rem  repart des memes fichiers et des memes donnees. Votre propre projet Laravel, dans un autre dossier,
rem  n'est pas touche. Gardez ailleurs ce que vous voulez conserver d'un TP.
rem  Les fichiers ignores par Git (.env, vendor, base SQLite) restent ; la base est recreee.
rem ============================================================================================
setlocal EnableExtensions
chcp 65001 >nul

rem Git va remplacer ce fichier pendant qu'il s'execute, et l'invite de commandes lit un .bat au fur
rem et a mesure : le script se recopie donc dans %TEMP%, puis continue depuis cette copie.
if /i not "%~1"=="--copie" (
  copy /y "%~f0" "%TEMP%\seance-cours.bat" >nul
  "%TEMP%\seance-cours.bat" --copie %*
)
shift

rem ---------------------------------------------------------------- la seance demandee
set "SEANCE=%~1"
set "CONFIRMER=oui"
if /i "%~1"=="/oui" (set "SEANCE=%~2" & set "CONFIRMER=non")
if /i "%~2"=="/oui" set "CONFIRMER=non"
if "%SEANCE%"=="" set /p "SEANCE=Numéro de la séance (par exemple 03) : "
set "SEANCE=%SEANCE:seance-=%"
if "%SEANCE%"=="" goto :erreur
if "%SEANCE:~1%"=="" set "SEANCE=0%SEANCE%"
set "BRANCHE=seance-%SEANCE%"

rem ---------------------------------------------------------------- ce dossier est-il le depot du cours ?
where git >nul 2>&1 || (echo Git est introuvable : installez Git pour Windows, puis relancez. & goto :erreur)
if not exist ".git" (
  echo Ce dossier n'est pas un dépôt Git : %CD%
  echo Ouvrez le dossier tp-framework-php, puis relancez.
  goto :erreur
)
set "ORIGINE="
for /f "delims=" %%u in ('git remote get-url origin 2^>nul') do set "ORIGINE=%%u"
echo(%ORIGINE%| findstr /i /c:"M2P-git/tp-framework-php" >nul || (
  echo Ce dossier n'est pas le dépôt du cours : %CD%
  echo Rien n'a été modifié. Ce script ne s'utilise que dans tp-framework-php.
  goto :erreur
)

echo Récupération des séances en ligne...
git fetch origin --prune || goto :erreur
git rev-parse --verify --quiet "origin/%BRANCHE%" >nul || (
  echo La séance %BRANCHE% n'existe pas en ligne. Séances disponibles :
  git branch -r --list "origin/seance-*"
  goto :erreur
)

rem ---------------------------------------------------------------- confirmation
if "%CONFIRMER%"=="oui" (
  echo.
  echo Le dossier %CD% va passer à la séance %BRANCHE%.
  echo Les modifications ci-dessous seront EFFACÉES ^(aucune ligne : rien à effacer^) :
  git status --short
  echo.
  choice /c ON /n /m "Continuer ? [O/N] "
  if errorlevel 2 goto :annule
)

rem ---------------------------------------------------------------- Git : remise a l'etat de la seance
git reset --hard -q
git clean -fdq
git checkout -q -B classe "origin/%BRANCHE%" || goto :erreur
git reset --hard -q "origin/%BRANCHE%"
echo Dépôt aligné sur %BRANCHE%.

if not exist "compose.yaml" (
  echo.
  echo Cette séance n'utilise pas Docker. Lisez README.md pour commencer.
  goto :fin
)

rem ---------------------------------------------------------------- Docker : la machine du cours
docker info >nul 2>&1 || call :demarrer_docker || goto :erreur
echo Démarrage de la machine Docker ^(la première fois : quelques minutes^)...
docker compose up -d --build || (
  echo Si le port 8000 est déjà pris, une autre machine du cours tourne encore :
  echo arrêtez-la avec docker compose down, dans son dossier, puis relancez.
  goto :erreur
)
echo Installation des paquets ^(composer install^)...
docker compose exec -T app composer install --no-interaction --no-progress || goto :erreur
docker compose exec -T app php scripts/prepare.php
docker compose exec -T app php artisan key:generate
echo Base de données de la séance ^(migrate:fresh --seed^)...
docker compose exec -T app php artisan migrate:fresh --seed
if errorlevel 1 (
  echo.
  echo Le remplissage de la base s'est arrêté sur une erreur. Au départ d'un TP, c'est souvent voulu :
  echo l'énoncé vous demande justement de la corriger.
)
docker compose exec -d app php artisan serve --host=0.0.0.0 --port=8000

echo.
echo ===============================================================
echo  Le dépôt est à la séance %BRANCHE%.
echo    Site de la séance       : http://127.0.0.1:8000
echo    Terminal de la machine  : docker compose exec app bash
echo    Tests                   : docker compose exec app php artisan test
echo ===============================================================
goto :fin

:demarrer_docker
echo Docker ne répond pas : démarrage de Docker Desktop...
if exist "%ProgramFiles%\Docker\Docker\Docker Desktop.exe" start "" "%ProgramFiles%\Docker\Docker\Docker Desktop.exe"
for /l %%i in (1,1,60) do (
  docker info >nul 2>&1 && exit /b 0
  timeout /t 3 /nobreak >nul
)
echo Docker Desktop ne démarre pas : lancez-le à la main, puis relancez ce script.
exit /b 1

:annule
echo Annulé : rien n'a été modifié.
goto :fin

:erreur
echo.
echo Arrêt du script.
if not defined SEANCE_SANS_PAUSE pause
endlocal & exit /b 1

:fin
if not defined SEANCE_SANS_PAUSE pause
endlocal & exit /b 0
