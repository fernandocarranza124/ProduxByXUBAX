<header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <div class="logo-mini">
            <!--<span class="logo-mini"><b>S</b>MX</span>-->
            <img class="sm-logo-img" src="/static/v/img/logo.png">
          </div>

          <!-- logo for regular state and mobile devices -->
          <!--<span class="logo-lg"><img src="/static/v/img/logo.png">  <b>See</b>metrix  </span>-->
          <div class="logo-lg">
            <div class="pull-left">
              <img class="sm-logo-img" src="/static/v/img/logo.png">
            </div>

            <div class="pull-left sm-logo-brand">
              <span><b>PRODUX</b></span>
            </div>
          </div>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <li>
                <a href="/accounts/profile/" title="My account">
                  <i class="fa fa-gear"></i>
                  <span class="hidden-xs">&nbsp;Mi cuenta</span>
                </a>
              </li>

              <li>
                <a href="#" title="Log out"  onclick="logout()">      
                    <i class="fa fa-sign-out"></i>
                    <span class="hidden-xs">&nbsp;Salir</span>
                    </a>
                  <form action="logout" method="post" accept-charset="utf-8">
                    @csrf
                    <button type="submit" id="logoutTag" style="display: none;"></button>
                  </form>
                <script>
                  function logout(){
                    document.getElementById("logoutTag").click();

                  }
                </script>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <script src="js/app.min.js"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout.
       -->



       <script type="text/javascript" id="">(function(a,e,f,g,b,c,d){a[b]=a[b]||function(){(a[b].a=a[b].a||[]).push(arguments)};a[b].l=1*new Date;c=e.createElement(f);d=e.getElementsByTagName(f)[0];c.async=1;c.src=g;d.parentNode.insertBefore(c,d)})(window,document,"script","https://mc.yandex.ru/metrika/tag.js","ym");ym(62429554,"init",{clickmap:!0,trackLinks:!0,accurateTrackBounce:!0,webvisor:!0});</script>
       <noscript><div><img src="https://mc.yandex.ru/watch/62429554" style="position:absolute; left:-9999px;" alt=""></div></noscript>

       <script type="text/javascript" id="">!function(b,e,f,g,a,c,d){b.fbq||(a=b.fbq=function(){a.callMethod?a.callMethod.apply(a,arguments):a.queue.push(arguments)},b._fbq||(b._fbq=a),a.push=a,a.loaded=!0,a.version="2.0",a.queue=[],c=e.createElement(f),c.async=!0,c.src=g,d=e.getElementsByTagName(f)[0],d.parentNode.insertBefore(c,d))}(window,document,"script","https://connect.facebook.net/en_US/fbevents.js");fbq("init","497296693808051");fbq("set","agent","tmgoogletagmanager","497296693808051");fbq("track","PageView");</script>
       <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=497296693808051&amp;ev=PageView&amp;noscript=1"></noscript>
