define ->
    'use strict'

    (match) ->
        # site
        match 'login', 'site#login', name: 'login'
        match 'logout', 'site#logout', name: 'logout'
        match 'register', 'site#register', name: 'register'
        match 'resetPassword', 'site#resetPassword', name: 'resetPassword'

        # user
        match 'home/:id', 'user#home'
        match 'settings', 'user#settings'
        match 'notifications', 'user#notifications'

        # topic
        match '', 'topic#list', name: 'index'
        match 'topic/create', 'topic#create'
        match ':tab', 'topic#list', name: 'list-by-tab', constraints: {tab: /(popular|latest|watch|suggest)/}
        match 'topic/:id', 'topic#show'

        # node
        match 'node', 'node#list'
        match 'node/:node', 'topic#list', name: 'list-by-node',  constraints: {node: /\w+/}
        match 'node/:node/:tab', 'topic#list', name: 'list-by-node-tab',  constraints: {node: /\w+/, tab: /(popular|latest|watch|suggest)/}

        # error page
        match '*action', 'site#404', name: '404'
