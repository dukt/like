<?php

return array(

    // Like Entries

    "like.onlikeentries_label" => "Notify me when someone likes my entries",
    "like.onlikeentries_heading"        => "When someone likes an entry:",
    "like.onlikeentries_message"        => "{{contextUser.friendlyName}} has liked {{contextElement.title}}",
    "like.onlikeentries_subject"        => "Someone has liked one of your entries",
    "like.onlikeentries_body"           => "Hello {{user.friendlyName}},\n\n{{contextUser.friendlyName}} has liked one of your entries :\n\n"."{{(entry.url is defined ? entry.url : 'Entry ID:'~entry.id)}}",


    // LikesMe

    "like.onlikeme_label"     => "Notify me when someone likes me",
    "like.onlikeme_heading"            => "When someone is getting liked:",
    "like.onlikeme_message"            => "{{contextUser.friendlyName}} likes you",
    "like.onlikeme_subject"            => "Someone likes you",
    "like.onlikeme_body"               => "Hello {{user.friendlyName}},\n\n{{contextUser.friendlyName}} likes you.",
);