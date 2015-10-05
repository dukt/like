# Like for Craft CMS

A simple plugin to connect to Like's API.

-------------------------------------------


## Warning

This plugin is still under development, please do not use on production.


## Installation

1. Download the latest release of the plugin
2. Drop the `like` plugin folder to `craft/plugins`
3. Install Like from the control panel in `Settings > Plugins`


## Templating


### Like button

    {% if currentUser %}
        {% if craft.like.isLike(element.id) %}
            <a class="btn btn-default" href="{{actionUrl('like/remove', {id:element.id})}}"><span class="glyphicon glyphicon-star"></span> Unlike</a>
        {% else %}
            <a class="btn btn-primary" href="{{actionUrl('like/add', {id:element.id})}}"><span class="glyphicon glyphicon-star"></span> Like</a>
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