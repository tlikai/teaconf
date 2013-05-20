define [
    'views/base/view'    
    'text!views/templates/site.html'
], (View, template) ->
    'use strict'

    class SiteView extends View
        el: 'body'
        regions: 
            '#topnav .top-panel': 'top-panel'
            '#container': 'main'
        template: template
