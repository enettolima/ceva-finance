<?php

/* menu.html */
class __TwigTemplate_0652d520db146c2db44cc074306f3f23e2302b40f52f758ceda56800e4e942d2 extends Twig_Template
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
        if (((isset($context["first"]) ? $context["first"] : null) == true)) {
            // line 2
            echo "  <ul class=\"sidebar-menu\">
";
        } else {
            // line 4
            echo "  <ul class=\"treeview-menu\">
";
        }
        // line 6
        echo "  ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["links"]) ? $context["links"] : null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 7
            echo "    ";
            if ($this->getAttribute((isset($context["link"]) ? $context["link"] : null), "children")) {
                // line 8
                echo "      <li class=\"treeview\">
        <a href=\"#\">
          ";
                // line 10
                if ($this->getAttribute((isset($context["link"]) ? $context["link"] : null), "icon_class")) {
                    // line 11
                    echo "            <i class=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["link"]) ? $context["link"] : null), "icon_class"), "html", null, true);
                    echo "\"></i>
          ";
                } else {
                    // line 13
                    echo "            <i class=\"fa fa-angle-double-right\"></i>
          ";
                }
                // line 15
                echo "          ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["link"]) ? $context["link"] : null), "label"), "html", null, true);
                echo "
          <i class=\"fa pull-right fa-angle-down\"></i>
        </a>
        ";
                // line 18
                $this->env->loadTemplate("menu.html")->display(array_merge($context, array("links" => $this->getAttribute((isset($context["link"]) ? $context["link"] : null), "children"), "first" => false)));
                // line 19
                echo "      </li>
    ";
            } else {
                // line 21
                echo "      <li>
        <a href=\"javascript:menu_navigation('";
                // line 22
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["link"]) ? $context["link"] : null), "element_name"), "html", null, true);
                echo "', '";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["link"]) ? $context["link"] : null), "func"), "html", null, true);
                echo "', '";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["link"]) ? $context["link"] : null), "module"), "html", null, true);
                echo "')\">
          ";
                // line 23
                if ($this->getAttribute((isset($context["link"]) ? $context["link"] : null), "icon_class")) {
                    // line 24
                    echo "            <i class=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["link"]) ? $context["link"] : null), "icon_class"), "html", null, true);
                    echo "\"></i>
          ";
                } else {
                    // line 26
                    echo "            <i class=\"fa fa-angle-double-right\"></i>
          ";
                }
                // line 28
                echo "          ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["link"]) ? $context["link"] : null), "label"), "html", null, true);
                echo "
        </a>
      </li>
    ";
            }
            // line 32
            echo "  ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        echo "</ul>";
    }

    public function getTemplateName()
    {
        return "menu.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  124 => 33,  110 => 32,  102 => 28,  98 => 26,  92 => 24,  90 => 23,  82 => 22,  79 => 21,  75 => 19,  73 => 18,  66 => 15,  62 => 13,  56 => 11,  54 => 10,  50 => 8,  47 => 7,  29 => 6,  25 => 4,  21 => 2,  19 => 1,);
    }
}
