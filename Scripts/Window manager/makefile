#
# nmake makefile for window
#
SH=cmd
CC=cl.exe
CFLAGS=/O2 /Ot /GB /QI0f /GF

all:	window.exe

OBJS=window.obj match.obj

window.exe: $(OBJS)
	$(CC) $(CFLAGS) /ML /Fe$@ $(OBJS) user32.lib

window.obj:
	$(CC) /c $(CFLAGS) /Fo$@ window.cpp

match.obj:
	$(CC) /c $(CFLAGS) /Fo$@ match.cpp

clean:
	-del *.obj
	-del *~

distclean:
	-del window.exe

