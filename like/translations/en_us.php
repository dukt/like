<?php

return array(

    // Like Entries

    "like.onlikeentries_label"   => "Notify me when someone likes my entries",
    "like.onlikeentries_message" => '{{sender.friendlyName}} liked “{{entry.title}}”.',
    "like.onlikeentries_subject" => "{{sender.friendlyName}} liked one of your entries",
    "like.onlikeentries_body"    => "Hello {{recipient.friendlyName}},\r\n\r\n".
                                    "{{sender.friendlyName}} liked one of your entries :\n\n".
                                    '<a href="{{entry.url}}">{{entry.title}}</a>',


    // LikesMe

    "like.onlikeme_label"        => "Notify me when someone likes me",
    "like.onlikeme_message"      => '{{sender.friendlyName}} likes you.',
    "like.onlikeme_subject"      => "{{sender.friendlyName}} likes you",
    "like.onlikeme_body"         => "Hello {{sender.friendlyName}},\n\n{{sender.friendlyName}} likes you.",
);