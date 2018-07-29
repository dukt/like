# Like plugin for Craft CMS 3.x

A simple plugin to connect to Like's API.

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require dukt/like

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Like.

## Templating

### Like button

    {% if currentUser %}
        {% if craft.like.isLike(element.id) %}
            <a class="btn btn-default" href="/like/remove/{{element.id}}"><span class="glyphicon glyphicon-star"></span> Unlike</a>
        {% else %}
            <a class="btn btn-primary" href="/like/add/{{element.id}}"><span class="glyphicon glyphicon-star"></span> Like</a>
        {% endif %}
    {% else %}
        <a class="btn disabled btn-primary" href="#">Like</a>
    {% endif %}


### List likes for an element

    {% set likes = craft.like.getLikes(element.id) %}

    {% if likes|length > 0 %}

        {% for like in likes %}
            <a href="#">
                {% if like.user.photoUrl %}
                    <img src="{{like.user.photoUrl}}" width="34" class="img-rounded" data-toggle="tooltip" data-original-title="{{like.user.email}}" />
                {% else %}
                    <img src="http://placehold.it/34x34" data-toggle="tooltip" class="img-rounded" data-original-title="{{like.user.email}}">
                {% endif %}
            </a>
        {% endfor %}

    {% endif %}


### Your Likes

Entries and asset that you like.

Entries:

    {% set entries = craft.like.getUserLikes('Entry') %}

    {% if entries %}
        <ul>
            {% for entry in entries %}
                <li>{{entry.title}}</li>
            {% endfor %}
        </ul>
    {% else %}
        <p>You haven't liked any entry yet.</p>
    {% endif %}

Assets:

    {% set assets = craft.like.getUserLikes('Asset') %}

    {% if assets %}
        <div class="row">
            {% for asset in assets %}
                <div class="col-md-4">
                    <img class="thumbnail img-responsive" src="{{asset.url({width:200, height: 140})}}" />
                </div>
            {% endfor %}
        </div>
    {% else %}
        <p>You haven't liked any asset yet.</p>
    {% endif %}


## API


### LikeVariable

- isLike($elementId)
- getLikes($elementId = null)
- getUserLikes($elementType = null, $userId = null)

Brought to you by [Benjamin David](https://github.com/benjamindavid)
