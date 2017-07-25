@echo off
set bin=d:\dev\common-tools\bin
set projectRoot=D:\dev\labs\qnut
set toolsDir=%projectRoot%\tools

if exist dist\qnut-project.zip del dist\qnut-project.zip
%bin%\7z a -tzip %projectRoot%\dist\qnut-project.zip @%toolsDir%\dist-files.txt