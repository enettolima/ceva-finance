<?php

/* index.html */
class __TwigTemplate_37a968442c22648ceb4a16069820cc5350b97e50f45f26c5442d7c036ad743d2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<?php ?>
<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <title><?php print TITLE ?></title>
    <meta charset=\"utf-8\"
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link REL=\"SHORTCUT ICON\" href=\"<?php print TEMPLATE ?>img/favicon.ico\">

    <!-- Bootstrap v3.0.3 (http://getbootstrap.com) -->
    <link href=\"";
        // line 11
        echo twig_escape_filter($this->env, (isset($context["path_to_theme"]) ? $context["path_to_theme"] : null), "html", null, true);
        echo "css/bootstrap.min.css\" media=\"all\" rel=\"stylesheet\" type=\"text/css\">
    <!-- Font Awesome -->
    <link href=\"";
        // line 13
        echo twig_escape_filter($this->env, (isset($context["path_to_theme"]) ? $context["path_to_theme"] : null), "html", null, true);
        echo "css/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\" />
    <!-- Ionicons -->
    <link href=\"";
        // line 15
        echo twig_escape_filter($this->env, (isset($context["path_to_theme"]) ? $context["path_to_theme"] : null), "html", null, true);
        echo "css/ionicons.min.css\" rel=\"stylesheet\" type=\"text/css\" />
    <!-- Main CSS -->
    <link href=\"";
        // line 17
        echo twig_escape_filter($this->env, (isset($context["path_to_theme"]) ? $context["path_to_theme"] : null), "html", null, true);
        echo "css/bootural-main.css\" media=\"all\" rel=\"stylesheet\" type=\"text/css\">

  </head>

  <body class=\"skin-gray fixed\">

    <header class=\"header\">
      <span class=\"logo\">
        <?php print TITLE ?>
      </span>
      <nav class=\"navbar navbar-static-top\" role=\"navigation\">
        <!-- Button to collapse navigation -->
        <a href=\"#\" class=\"navbar-btn sidebar-toggle\" data-toggle=\"offcanvas\" role=\"button\">
          <span class=\"sr-only\">Toggle navigation</span>
          <i class=\"fa fa-bars\"></i></a> </span>
        </a>
        <!-- Top right navigation -->
        <div class=\"navbar-right\">
          <ul class=\"nav navbar-nav\">
            <li><a href=\"#\">Dashboard</a></li>
            <li><a href=\"#\">Settings</a></li>
            <li><a href=\"#\">Profile</a></li>
            <li><a href=\"logout.php\" title=\"Logout\" class=\"logout\">Logout</a></li>
          </ul>
        </div>
      </div>
    </header>

    <div class=\"wrapper row-offcanvas row-offcanvas-left\">
      <!-- Left side -->
      <aside class=\"left-side sidebar-offcanvas\">
        <!-- Sidebar -->
        <section class=\"sidebar\">
          <!-- Main menu -->
          ";
        // line 51
        echo (isset($context["menu"]) ? $context["menu"] : null);
        echo "
        </section>
      </aside>
      <!-- Right side -->
      <aside class=\"right-side\">
        <!-- Content header  -->
        <section class=\"content-header\">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class=\"breadcrumb\">
            <li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li class=\"active\">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class=\"content\" id=\"content\">
          Main Content ";
        // line 70
        echo twig_escape_filter($this->env, (isset($context["pageTitle"]) ? $context["pageTitle"] : null), "html", null, true);
        echo "
          <?php //print \$content; ?>
        </section>
      </aside>
    </div>


    <div id=\"account-header\">
      <span id=\"account-topic\"><?php print \$account_topic; ?></span>
      <span id=\"back-link\"><?php print \$back_link; ?> </span>
    </div>



    <!-- loading
    <div id=\"loading\">
      Loading
    </div>
     end loading -->

    <!-- tooltip -->
    <div id=\"tooltip-box\"></div>
    <!-- end tooltip -->

    <!-- Placed at the end of the document so the pages load faster -->
    <!-- jQuery 2.0.2 -->
    <script type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js\"></script>
    <!-- jQuery UI 1.10.3 -->
    <script type=\"text/javascript\" src=\"";
        // line 98
        echo twig_escape_filter($this->env, (isset($context["path_to_theme"]) ? $context["path_to_theme"] : null), "html", null, true);
        echo "js/jquery-ui-1.10.3.min.js\"></script>
    <!-- Bootstrap v3.0.3 (http://getbootstrap.com) -->
    <script type=\"text/javascript\" src=\"";
        // line 100
        echo twig_escape_filter($this->env, (isset($context["path_to_theme"]) ? $context["path_to_theme"] : null), "html", null, true);
        echo "js/bootstrap.min.js\"></script>


    <!-- Natural Controler -->
    <script type=\"text/javascript\" src=\"lib/js/controller.js\"></script>

    <!-- Bootural Main -->
    <script type=\"text/javascript\" src=\"";
        // line 107
        echo twig_escape_filter($this->env, (isset($context["path_to_theme"]) ? $context["path_to_theme"] : null), "html", null, true);
        echo "js/bootural-main.js\"></script>



  </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  151 => 107,  141 => 100,  136 => 98,  105 => 70,  83 => 51,  46 => 17,  41 => 15,  36 => 13,  31 => 11,  19 => 1,);
    }
}
