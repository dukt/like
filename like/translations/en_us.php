<?php

return array(

    // Like Entries

    "like.onlikeentries_settings_label" => "Notify me when someone likes my entries",
    "like.onlikeentries_heading"        => "When someone likes an entry:",
    "like.onlikeentries_subject"        => "Someone has liked one of your entries",
    "like.onlikeentries_body"           => "Hello {{user.friendlyName}},\n\n{{contextUser.friendlyName}} has liked one of your entries :\n\n"."{{(entry.url is defined ? entry.url : 'Entry ID:'~entry.id)}}",


    // LikesMe

    "like.onlikeme_settings_label"     => "Notify me when someone likes me",
    "like.onlikeme_heading"            => "When someone is getting liked:",
    "like.onlikeme_subject"            => "Someone likes you",
    "like.onlikeme_body"               => "Hello {{user.friendlyName}},\n\n{{contextUser.friendlyName}} likes you.",
);