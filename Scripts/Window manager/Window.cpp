///////
//  A console application to show / hide / control windows
///////
//
//  This works by enumerating through the open windows, 
// attempting to match the title of the window with the
// name that is given by the user.
//  The name of the window that the user gives may, optionally,
// be a wildcard string.
//
///////
//
// Copyright (c) Steve Kemp 1998-2004, steve@steve.org.uk
//
// http://www.steve.org.uk/
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
//
//////////////////////////////////////////////////////////////////


#include <windows.h>
#include <stdio.h>

#include "match.h"

#define DEBUG 0

// Action codes
 const int HIDE       = 1;
 const int SHOW       = 2;
 const int MIN        = 3;
 const int MAX        = 4;
 const int TOP        = 5;
 const int LIST       = 6;
 const int LISTALL    = 7;
 const int KILL       = 8;
 const int LISTHIDDEN = 9;

// Prototypes
  // Called with the handle of every open window
  BOOL CALLBACK EnumWindowProc( HWND hwnd, LPARAM parm );
  
  // Called if the user doesn't supply enough args
  void showHelp();
 
// Global variables
  int action = LISTALL;         // The default action to take
  char title[ 2048 ] = "";   // Title we are looking for


/**  This is the main driver routine.
     It tests for the argument flags that we accept,
    and modifiys the global variables if they are found.
     It also builds up the title of the window we are
    looking for, ignoring those specified args.
 */
void main( int argc, char *argv[] )
{

  
  // Test for some args - we must have at least one.
  if ( argc < 2 )
  { showHelp();
    return;
  }
 
  // Loop through the command line args
  for ( int i = 1; i < argc; i++ )
  { 
    // If an arg is /show then we set the global action
    // flag to show, rather than the default hide
    if ( strcmpi( argv[ i ], "/show" ) == 0 )
    { action = SHOW;
    }
    // If an arg is /hide then we set the global action
    // flag to hide [This is the default action anyway
    else if ( strcmpi( argv[ i ], "/hide" ) == 0 )
    { action = HIDE;
    }
    // If an arg is /min then we set the global action
    // flag to minimize, rather than the default hide
    else if ( strcmpi( argv[ i ], "/min" ) == 0 )
    { action = MIN;
    }
    // If an arg is /max then we set the global action
    // flag to maximize, rather than the default hide
    else if ( strcmpi( argv[ i ], "/max" ) == 0 )
    { action = MAX;
    }
    // If an arg is /top then we set the global action
    // flag to force the window to the top
    else if ( strcmpi( argv[ i ], "/top" ) == 0 )
    { action = TOP;
    }
    // If an arg is /list then we set the global action
    // flag to print the titles of matching windows
    else if ( strcmpi( argv[ i ], "/list" ) == 0 )
    { action = LIST;
    }
    // If an arg is /listall then we set the global action
    // flag to print the titles of all windows
    else if ( strcmpi( argv[ i ], "/listall" ) == 0 )
    { action = LISTALL;
    }
    else if ( strcmpi( argv[ i ], "/listhidden" ) == 0 )
    {
      action = LISTHIDDEN;
    }
    // If an arg is /kill then we set the global action
    // flag to print the titles of all windows
    else if ( strcmpi( argv[ i ], "/kill" ) == 0 )
    { action = KILL;
    }
    // If there is a /? there then we should stop
    // the processing, after showing some help
    else if ( strcmpi( argv[ i ], "/?" ) == 0 )
    { showHelp();
      return;
    }
    else
    { 
      // If this isn't the first arg add a space
      if ( strlen( title ) )
        strcat( title, " " );

      // Add on the arg to the window title we are building
      strcat( title, argv[ i ] );
    }
  }
   
  if ( DEBUG )
    printf( "Title is '%s'\n", title );

  if ( DEBUG )
  { if ( !is_pattern( title  ) )
      printf( "'%s' doesn't look like a pattern\n", title );
  }

  // Setup our callback function.  This will be
  // called for all windows.
  EnumWindows( (WNDENUMPROC) EnumWindowProc, NULL );
}


/** Show some brief help.
 */
void showHelp()
{
  printf( "Window v1.5 - steve@steve.org.ku\n\n" );
  printf( "   Usage: Window [/show] [/min] [/max] [/top] [/list] [/kill] Window Title\n" );
  printf( "\n" );
  printf( "/hide          Hide the matching windows. [Default]\n" );
  printf( "/show          Show the matching windows, don't hide them.\n" );
  printf( "/min           Minimize matching windows.\n" );
  printf( "/max           Maximize matching windows.\n" );
  printf( "/top           Toggle window 'Always on Top'.\n" );
  printf( "/list          List all non-hidden window titles.\n" );
  printf( "/listhidden    List only hidden window titles.\n" );
  printf( "/listall       List all window titles.\n" );
  printf( "/kill          Kill the given windows.\n" );
  printf( "\n" );
  printf( " 'Window Title' may optionally be a wildcard expression.  If this\n" );
  printf( "is the case be sure to surround it in quotes (\").\n" );
}


/** Callback routine that is called with the handle
    of all the windows found.
 */
BOOL CALLBACK EnumWindowProc( HWND hwnd, LPARAM parm )
{

  // Buffer to store the title of the window found
  char windowTitle[ 2050 ] = "";

  // Get the window title bar text
  GetWindowText( hwnd, windowTitle, 2048 );


  // If the window title is empty ignore it,
  // we wouldn't be able to match it anyway
  if ( !strlen( windowTitle )  )
    return TRUE;

  // If we are listing all windows
  if ( action == LISTALL )
  { 
    printf( "%s\n", windowTitle );
    return TRUE;
  }

  // Only listing hidden windows?
  if ( action == LISTHIDDEN )
  {
    if ( !IsWindowVisible( hwnd ) )
    {
      printf("%s\n", windowTitle );
      return TRUE; 
    }
  
  }

  // If we are listing windows, and the current window
  // is visible then print is title...
  if ( action == LIST )
  { 
    if ( IsWindowVisible( hwnd ) )
      printf( "%s\n", windowTitle );
    return TRUE;
  }

  int error = match( title, windowTitle );
  if ( error != MATCH_VALID )
      return TRUE;

  // If we are to hide the window
  if ( action == HIDE )
  { 
    // Hide the window
    ShowWindow( hwnd, SW_HIDE );
  }
  else if ( action == SHOW )
  { 
    // Restore the window
    ShowWindow( hwnd, SW_SHOWDEFAULT );
  }   
  else if ( action == MIN )
  {
    // Minimize the window
    ShowWindow( hwnd, SW_MINIMIZE );
  }
  else if ( action == MAX )
  {
    // Maximixe the window
    OpenIcon( hwnd );
    ShowWindow( hwnd, SW_MAXIMIZE);
  }
  else if ( action == TOP )
  {
    // Bring the window to the front
    SetWindowPos( hwnd,
        ( GetWindowLong( hwnd, GWL_EXSTYLE ) & WS_EX_TOPMOST  ) ?
          HWND_NOTOPMOST:HWND_TOPMOST,
          0, 0, 0, 0, SWP_NOMOVE | SWP_NOSIZE );
      
  }
  else if ( action == KILL )
  {
      // Close the window
      //
      //  NOTE:
      //   SendMessage just doesn't work
      //
      PostMessage( hwnd, WM_CLOSE, 0, 0 );

    /*    
          DWORD processID;
          GetWindowThreadProcessId(hwnd, &processID );
          HANDLE processHandle =  OpenProcess(PROCESS_ALL_ACCESS,
                                             FALSE,
                                             processID );
          if ( processHandle != NULL )    
          {
              TerminateProcess( processHandle , 0);
          }
    */
  }
  
  // Return true, so that we get more windows to
  // work with, this means we can match multiple 
  // windows... [If matching on the beginning of the
  // window title]
  return TRUE;
}


