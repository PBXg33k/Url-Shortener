    <!-- Header -->
    <header id="top" class="header">
        <div class="text-vertical-center">
            <div class="row darken-bg top-shadow">
                <div class="col-lg-12 text-center">
                    <p>
                        <h1>l.has.mo&eacute; shortlinker</h1>
                        <h3>Share your links with more mo&eacute;</h3>
                    </p>
                </div>
            </div>
            {% if token %}
            <div class="row darken-bg bottom-shadow">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <p>
                        <h2>Enjoy!</h2>
                        <p>
                            Your shortened link is: <br/>
                            <h2><strong>{{url(token)}}</strong></h2>
                        </p>
                    </p>
                </div>
            </div>
            {% else %}
            <form method="post" class="darken-bg bottom-shadow" id="new-link" autocomplete="off" action="{{ url('links/create') }}">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 text-center">
                        <p>
                            <input class="form-control input-large" name="longurl" type="text" placeholder="{{url()}}" />
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-2">
                        <p>
                            <input type="checkbox" id="checkbox-password" name="checkbox-password" />
                            <label for="checkbox-password">{{tr(checkbox_password_protect)}}</label>
                        </p>
                    </div>
                    <div class="col-lg-2">
                        <p>
                            <input type="checkbox" name="show-moe" />
                            <label for="show-moe">Show mo&eacute; banner before redirecting</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 text-center">
                        <p><input class="form-control input-large" name="password" type="text" placeholder="{{tr(password)}}" style="display:none" /></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 text-center">
                        <p><input type="submit" class="btn btn-large btn-success" value="MOEfy my link » " /></p>
                    </div>
                </div>
            </form>
            {% endif %}
        </div>
    </header>