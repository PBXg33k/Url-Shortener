<div class="jumbotron">
    <form method="post" id="link-unlock" autocomplete="off">
        <h1>{{tr(password_protected_title)}}</h1>
        <p class="lead">
            {{url(slug)}}
        </p>
        <p>
            {{tr(password_protected_body)}}
        </p>
        <p>
            {% if error is defined %}
            <div class="error">{{error}}</div>
            {% endif %}
            <input class="form-control input-large" name="password" type="text" placeholder="{{tr(password)}}" />
        </p>
        <p>
            <input type="submit" class="btn btn-large btn-success" value="{{tr(unlock_btn)}} » " />
        </p>
    </form>
</div>