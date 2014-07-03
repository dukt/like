<?php

return array(

    // Like Entries

    "like.onlikeentries_label"   => "Notify me when someone likes my entries",
    "like.onlikeentries_message" => "{{user.friendlyName}} likes {{entry.title}}",
    "like.onlikeentries_subject" => "{{user.friendlyName}} likes one of your entries",
    "like.onlikeentries_body"    => "Hello {{user.friendlyName}},\r\n\r\n{{user.friendlyName}} has liked one of your entries :\n\n"."{{(entry.url is defined ? entry.url : 'Entry ID:'~entry.id)}}",


    // LikesMe

    "like.onlikeme_label"        => "Notify me when someone likes me",
    "like.onlikeme_message"      => "{{user.friendlyName}} likes you",
    "like.onlikeme_subject"      => "{{user.friendlyName}} likes you",
    "like.onlikeme_body"         => "Hello {{user.friendlyName}},\n\n{{user.friendlyName}} likes you.",
);