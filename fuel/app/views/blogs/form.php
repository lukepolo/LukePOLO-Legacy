<script>
    $(document).ready(function()
    {
	$('.editable').editor({
            autoEnable: true,            // Enable the editor automaticly
            plugins: {                   // Plugin options
                dock: {                  // Dock specific plugin options
                    docked: true,        // Start the editor already docked
                    dockToElement: true, // Dock the editor inplace of the element
                    persist: false       // Do not save the docked state
                }
            }
        });
    });
</script>
<?php
    echo Form::open(Uri::base().'blog/create');
?>
    <p>Title</p>
        <?php
            echo Form::input('title','',array('required'=>'required'));
        ?>
        <p>Sub Title</p>
        <?php
            echo Form::input('sub_title','',array('required'=>'required'));
        ?>
        <p>Slug</p>
        <?php
            echo Form::input('slug','',array('required'=>'required'));
        ?>
        <p>Blog</p>
        <?php
            echo Form::textarea('text','',array('class'=>'editable','rows'=>'10','required'=>'required','style'=> 'width:100%;'));
        ?>
        <br>
        <?php
        echo Form::submit('submit','Create Blog',array('class' => 'btn btn-primary'));
    echo Form::close();