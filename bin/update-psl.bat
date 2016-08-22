@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/jeremykendall/php-domain-parser/bin/update-psl
php "%BIN_TARGET%" %*
