{% extends DB.getTemplate('page_layout') %}

{% block title %}{{ title }}{% endblock %}

{% block metas %}
{% include 'metas.html.twig' %}
{% endblock %}

{% block body_attributes %}data-spy="scroll" data-target="#inpage_menu" data-offset="80"{% endblock %}

{% block body %}
    <div class="navbar navbar-inverse navbar-fixed-top hidden-printer">
        <div class="navbar-inner">
{% include DB.getTemplate('navbar') %}
        </div>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
{% include DB.getTemplate('ltie7_warning') %}
{% include DB.getTemplate('breadcrumbs') %}
{{ content|raw }}
        </div>
    </div>
{% endblock %}

{% block scripts %}
{{ parent() }}
<script src="{{ vendor_assets }}jquery.highlight.js"></script>
<script src="{{ vendor_assets }}jquery.juizScrollTo.js"></script>
<script src="{{ vendor_assets }}jquery.tablesorter/jquery.tablesorter.min.js"></script>
<script>
$(function() {
    initTables();
    initHighlighted('pre.code');
    initTablesorter('table.tablesorter');
    $('.tooltips').tooltip();
    initInpageNavigation();
    getToHash();
    initSearchFiled()
    initScrollTo();
    initTablesorter('table.indextable', {headers:{0:{sorter:false}}});
});
</script>
{% endblock %}
