<?php
echo Form::open();
?>

    <legend>Login to LukePolo</legend>
    <?php
    if(isset($login_error) === true)
    {
    ?>
    <div class="row">
        <div class="alert alert-danger span3">
            <?php
                echo $login_error;
            ?>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="control-group">
        <div class="controls">
            <?php
                echo Form::input('username',isset($username) ? $username : '', array('placeholder'=>'Username or email'));
            ?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <?php
                echo Form::password('password','',array('placeholder'=>'Password'));
            ?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
           <?php
                echo Form::submit('submit','Sign In',array('class'=>'btn btn-success'))
           ?>
        </div>
    </div>
<?php
echo Form::close();