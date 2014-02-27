<?php

/* list-table.html */
class __TwigTemplate_30ad7b4a0bfc53fc67596ef76a91221f33c1ff956ae244675b512ea810d9afdb extends Twig_Template
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
        echo "<div class=\"well\">
  <h4>Manage ";
        // line 2
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</h4>

  <br/><a href=\"create/\" class=\"btn btn-small\">Create</a></br/><br/>

  <table class=\"table table-hover\">
    <thead>
      <tr>
        <th>Test</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      ";
        // line 14
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["object_list"]) ? $context["object_list"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["object"]) {
            // line 15
            echo "        <tr>
          <td>";
            // line 16
            echo twig_escape_filter($this->env, (isset($context["object"]) ? $context["object"] : null), "html", null, true);
            echo "</td>
          <td></td>
        </tr>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['object'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 20
        echo "    </tbody>
  </table>

</div>

";
    }

    public function getTemplateName()
    {
        return "list-table.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 20,  44 => 16,  41 => 15,  37 => 14,  22 => 2,  19 => 1,);
    }
}
