<?php

return array(

    // Like Entries

    "like.likeentries_setting_label" => "Notify me when someone likes my assets",
    "like.likeentries_heading" => "When someone likes an entry:",
    "like.likeentries_subject" => "Someone has liked one of your entries",
    "like.likeentries_body"    => "A user has liked one of your entries :
                                    - user : {{user.username}}
                                    - entry : {{(entry.url is defined ? entry.url : entry.id)}}",


    // Like Assets

    "like.likeassets_heading" => "When someone likes an asset:",
    "like.likeassets_subject" => "Someone has liked one of your assets",
    "like.likeassets_body"    => "A user has liked one of your assets :
                                    - user : {{user.username}}
                                    - asset : {{(asset.url is defined ? asset.url : asset.id)}}",


    // LikesMe

    "like.likesme_heading" => "When someone is getting liked:",
    "like.likesme_subject" => "Someone likes you",
    "like.likesme_body"    => "{{user.username}} likes you.",
);