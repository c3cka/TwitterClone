<!DOCTYPE html>
<html>
<head>
    <title>Phalcon Blog</title>
    <link rel="stylesheet" href="/www/pirate/public/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="/www/pirate/public/css/bootstrap-grid.min.css" type="text/css" />
</head>
<body>
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <a data-target=".nav-collapse"
               data-toggle="collapse" class="btn btn-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a href="/www/pirate" class="brand">Phalcon
                Blog</a>
            <div class="nav-collapse">
                <ul class="nav">
                    <li>{{ link_to("posts/", "Posts") }}</li>
                    <li>{{ link_to("posts/search", "Advanced
                                 Search") }}</li>
                    <li>{{ link_to("posts/new", "Create
                                 posts") }}</li>
                    <li><a href="/www/pirate/public/webtools.php?
                                 _url=/index">Webtools</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="content" class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="well">
                {{ form("posts/search", "method":"post",
                "autocomplete" : "off", "class" :
                "form-inline") }}
                <div class="input-append">
                    {{ text_field("body", "class" :
                    "input-medium") }}
                    {{ submit_button("Search", "class" :
                    "btn") }}
                </div>
                {{ end_form() }}
            </div>
        </div>
        <div class="span9 well">
            {{ content() }}
        </div>
    </div>
</div>
<script src="/www/pirate/public/js/jquery-3.2.1.min.js" type="text/
         javascript"></script>
<script src="/www/pirate/public/js/bootstrap.min.js"
        type="text/javascript"></script>
</body>
</html>