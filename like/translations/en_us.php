<?php

return array(

    // Like Entries

    "like.likeentries_setting_label" => "Notify me when someone likes my assets",
    "like.likeentries_heading" => "When someone likes an entry:",
    "like.likeentries_subject" => "Someone has liked one of your entries",
    "like.likeentries_body"    => "{{user.friendlyName}} has liked one of your entries :\n\n".
                                  "{{(entry.url is defined ? entry.url : 'Entry ID:'~entry.id)}}"


    // Like Assets

    "like.likeassets_heading" => "When someone likes an asset:",
    "like.likeassets_subject" => "Someone has liked one of your assets",
    "like.likeassets_body"    => "{{user.friendlyName}} has liked one of your assets :\n\n".
                                 "{{(asset.url is defined ? asset.url : 'Asset ID:'~asset.id)}}",


    // LikesMe

    "like.likesme_heading" => "When someone is getting liked:",
    "like.likesme_subject" => "Someone likes you",
    "like.likesme_body"    => "{{user.friendlyName}} likes you.",
);