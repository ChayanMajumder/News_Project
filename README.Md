# NEWS PROJECT

Clients Module ->
    dashboard,
    news,
    news-details

Admin Modules ->
    dashboard,
    all-news,
    news-details,
    news-create,
    news-edit,

    login

Database ->  news

    users ->
     
        userID, 
        userName, 
        userEmail, 
        userPassword, 
        userRole['admin','repoter->default'], 
        userStatus['active->default','inactive'], 
        userImage(null), 
        userJoinDate, 
        createdAt, 
        updatedAt

    posts -> 
        newsID, 
        newsTitle,
        newsSummary, 
        newsDescription(longtext), 
        newsImage, 
        newsCategory[fk, news_categories.categoryID], 
        newsAuthor[fk, ref -> users.userID], 
        newsDate, 
        newsStatus['published','unpublished'], 
        createdAt, 
        updatedAt

    news_categories -> 
        categoryID, 
        categoryName, 
        categoryDescription, 
        createdAt,
        updatedAt


