@ECHO OFF
ECHO Welcome to the GNaP.Tooling.Wiki installer
ECHO ==========================================

:AvailableOptions
ECHO Installable components provided by this installer:
ECHO  [1] Visual C++ Redistributable for Visual Studio 2012 Update 4
ECHO  [2] IIS URL Rewrite Module 2.0
ECHO  [3] FastCGI
ECHO  [4] PHP 5.5
ECHO  [5] DokuWiki
ECHO  [6] Base GNaP.Tooling.Wiki theme
ECHO  [7] GNaP.Tooling.Wiki example structure
ECHO  [8] GNaP.Tooling.Wiki example content
ECHO  [X] Exit
ECHO.
SET INSTALLOP=
SET /P INSTALLOP="Select an option: "

IF "%INSTALLOP%"=="2" ( GOTO InstallRewrite )

IF "%INSTALLOP%"=="4" ( GOTO InstallPHP )
IF "%INSTALLOP%"=="5" ( GOTO InstallDokuWiki )

IF "%INSTALLOP%"=="X" ( GOTO TheEnd )
IF "%INSTALLOP%"=="x" ( GOTO TheEnd )
IF "%INSTALLOP%"=="" ( GOTO TheEnd )

IF NOT "%INSTALLOP%"=="1" (
IF NOT "%INSTALLOP%"=="2" (
IF NOT "%INSTALLOP%"=="3" (
IF NOT "%INSTALLOP%"=="4" (
IF NOT "%INSTALLOP%"=="5" (
IF NOT "%INSTALLOP%"=="6" (
IF NOT "%INSTALLOP%"=="7" (
IF NOT "%INSTALLOP%"=="8" (
	ECHO Invalid option!
	ECHO.
	GOTO AvailableOptions
))))))))

REM ---------------------------------------------------------------------------
:InstallRewrite
SET REWRITE=x64
SET /P REWRITE="Install version (x64 or x86) [x64]: "

ECHO.
ECHO Installing IIS URL Rewrite Module 2.0 %REWRITE%

IF "%REWRITE%"=="x64" ( 
echo test
rewrite\rewrite_2.0_rtw_x64.msi 
)
IF "%REWRITE%"=="x86" ( rewrite\rewrite_2.0_rtw_x86.msi )

ECHO Installed IIS URL Rewrite Module 2.0 %REWRITE%
PAUSE

ECHO.
GOTO AvailableOptions
REM ---------------------------------------------------------------------------

REM ---------------------------------------------------------------------------
:InstallPHP
SET PHP=C:\PHP
SET /P PHP="Install path [C:\PHP]: "

ECHO.
ECHO Installing PHP to %PHP%

7za.exe x php\php-5.5.10-nts-Win32-VC11-x86.zip -o%PHP%

ECHO.
ECHO Installed PHP to %PHP%
PAUSE

ECHO.
GOTO AvailableOptions
REM ---------------------------------------------------------------------------

REM ---------------------------------------------------------------------------
:InstallDokuWiki
SET DOKUWIKI=C:\Wiki
SET /P DOKUWIKI="Install path [C:\Wiki]: "

ECHO.
ECHO Installing DokuWiki to %DOKUWIKI%

7za.exe e dokuwiki\base\dokuwiki-2014-05-05-ponder-stibbons.tgz -odokuwiki\base\
7za.exe x dokuwiki\base\dokuwiki-2014-05-05-ponder-stibbons.tar -o%DOKUWIKI%
RM dokuwiki\base\dokuwiki-2014-05-05-ponder-stibbons.tar
FOR /d %%a IN (%DOKUWIKI%\dokuwiki\*) DO MOVE "%%~a" "%DOKUWIKI%\"
MOVE "%DOKUWIKI%\dokuwiki\*" "%DOKUWIKI%\"

ECHO.
ECHO Installed DokuWiki to %DOKUWIKI%
PAUSE

ECHO.
GOTO AvailableOptions
REM ---------------------------------------------------------------------------

:TheEnd
