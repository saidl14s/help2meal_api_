@for ($i = 0; $i < 4; $i++)
    <!--single notice-->
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Well done!</strong> You successfully read <a href="#" class="alert-link">this important alert message</a>.
    </div>
    <!--single notice-->
    <div class="alert alert-dismissible alert-light">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Heads up!</strong> This <a href="#" class="alert-link">alert needs your attention</a>, but it's not super important.
    </div>    
@endfor