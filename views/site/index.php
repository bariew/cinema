<?php
/**
 * @var yii\web\View $this
 */
$this->title = 'Cinema API';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Cinema API</h1>
        <p class="lead">Test Yii2 application.</p>
    </div>

    <div class="body-content">
        <label>Headers:</label>
        <ul>
            <li> Getting json: "Accept: application/json" </li>
            <li> Sending POST: "Content-Type: application/x-www-form-urlencoded" </li>
            <li> Pagination: use GET params 'page' and 'per-page' </li>
        </ul>
        <div class="row">
            <div class="col-lg-4">
                <h2>Sessions by cinema unit</h2>
                <p><pre>GET /api/cinema/&ltcinema_title&gt/schedule[?hall_title=hallTitle]</pre></p>
            </div>
            <div class="col-lg-4">
                <h2>Sessions by film title</h2>
                <p><pre>GET /api/film/&ltfilm_title&gt/schedule</pre></p>
            </div>
            <div class="col-lg-4">
                <h2>Session by id</h2>
                <p><pre>GET /api/session/&ltsession_id&gt/places</pre></p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4">
                <h2>Buy tickets</h2>
                <p><pre>POST /api/tickets/buy</pre></p>
                <p><pre>post body example: session_id=44&places[1][]=8&places[2][]=5</pre></p>
            </div>
            <div class="col-lg-4">
                <h2>Reject order</h2>
                <p><pre>DELETE /api/tickets/reject/&ltorder_id&gt</pre></p>
            </div>
        </div>

    </div>
</div>
