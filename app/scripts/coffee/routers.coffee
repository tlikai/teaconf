define ->
    'use strict'

    (match) ->
        # site
        match 'login', 'site#login', name: 'login'
        match 'logout', 'site#logout', name: 'logout'
        match 'register', 'site#register', name: 'register'
        match 'resetPassword', 'site#resetPassword', name: 'resetPassword'

        # user
        match 'user/:id', 'user#home', params: {topic: true}
        match 'user/:id/topics', 'user#home', name: 'user-topics', params: {topic: true}
        match 'user/:id/posts', 'user#home', name: 'user-posts', params: {post: true}
        match 'user/:id/watch', 'user#home', name: 'user-watch', params: {watch: true}

        match 'settings', 'user#settings'
        match 'notifications', 'user#notifications', params: {unread: true}
        match 'notifications/all', 'user#notifications', name: 'notifications-all', params: {unread: false}

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
